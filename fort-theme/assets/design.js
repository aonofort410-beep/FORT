/* ============================================================
   FORT DESIGN 特設ページの動き
   ・[data-progress] の要素に、スクロールの進み具合 --p（0〜1）を書き込む
     （見た目の変化は CSS 側で --p を使って描く）
   ・[data-dz-lines] の行を、画面に入ったら1行ずつ浮かび上がらせる（[data-dz-reveal] は写真の幕が開く）
   ・PC（マウス操作）だけ、追従する小さなカーソルを表示
   ・「動きを減らす」設定では何もしない（CSSが静的表示に切り替える）
============================================================ */
(function () {
  var reduce = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  var root = document.documentElement;
  document.body.classList.add('dz-ready');
  if (reduce) { document.body.classList.add('dz-static'); return; }

  /* 1. スクロール進み具合 */
  var els = Array.prototype.slice.call(document.querySelectorAll('[data-progress]'));
  var ticking = false;
  function update() {
    var vh = window.innerHeight;
    els.forEach(function (el) {
      var r = el.getBoundingClientRect();
      var total = r.height - vh;
      var p = total > 0 ? -r.top / total : (vh - r.top) / (vh + r.height);
      p = Math.max(0, Math.min(1, p));
      el.style.setProperty('--p', p.toFixed(4));
    });
    ticking = false;
  }
  function onScroll() { if (!ticking) { ticking = true; requestAnimationFrame(update); } }
  window.addEventListener('scroll', onScroll, { passive: true });
  window.addEventListener('resize', onScroll);
  update();

  /* 2-0. 1文字ずつ浮かび上がる（[data-dz-chars] の各行を文字に分ける） */
  document.querySelectorAll('[data-dz-chars]').forEach(function (box) {
    var n = 0;
    Array.prototype.forEach.call(box.children, function (line) {
      var text = line.textContent;
      line.setAttribute('aria-label', text);
      line.innerHTML = text.split('').map(function (ch) {
        return '<span class="dz-char" aria-hidden="true" style="--c:' + (n++) + '">' + ch + '</span>';
      }).join('');
    });
    box.classList.add('dz-chars-ready');
  });

  /* 2. 行ごとの浮かび上がり */
  var lineBoxes = document.querySelectorAll('[data-dz-lines], [data-dz-reveal], [data-dz-chars]');
  lineBoxes.forEach(function (box) {
    Array.prototype.forEach.call(box.children, function (line, i) { line.style.setProperty('--li', i); });
  });
  if ('IntersectionObserver' in window) {
    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (en) { if (en.isIntersecting) { en.target.classList.add('is-in'); io.unobserve(en.target); } });
    }, { threshold: 0.25 });
    lineBoxes.forEach(function (b) { io.observe(b); });
  } else {
    lineBoxes.forEach(function (b) { b.classList.add('is-in'); });
  }

  /* 3. カーソル（PCのみ） */
  if (window.matchMedia('(pointer: fine)').matches) {
    var c = document.createElement('div');
    c.className = 'dz-cursor';
    c.setAttribute('aria-hidden', 'true');
    c.innerHTML = '<span></span>';
    document.body.appendChild(c);
    var x = innerWidth / 2, y = innerHeight / 2, cx = x, cy = y;
    window.addEventListener('mousemove', function (e) { x = e.clientX; y = e.clientY; c.classList.add('is-on'); }, { passive: true });
    document.addEventListener('mouseleave', function () { c.classList.remove('is-on'); });
    document.addEventListener('mouseover', function (e) {
      var t = e.target.closest('a, button');
      c.classList.toggle('is-link', !!t);
      var label = t && t.getAttribute('data-cursor');
      c.firstChild.textContent = label || '';
      c.classList.toggle('is-label', !!label);
    });
    (function loop() {
      cx += (x - cx) * 0.18; cy += (y - cy) * 0.18;
      c.style.transform = 'translate3d(' + cx + 'px,' + cy + 'px,0)';
      requestAnimationFrame(loop);
    })();
  }

  /* 4. 平面図：画面に入ったら、CADで1本ずつ線を引くように描く
        ① 外周の補助線（薄い破線）を引く → ② ペン先が線を1本ずつなぞる → ③ 細部（部屋名など）が浮かぶ */
  var plan = document.querySelector('.dz-draw__plan');
  if (plan) {
    var svg = plan.querySelector('svg');
    var lines = Array.prototype.slice.call(svg.querySelectorAll('.dz-plan__lines line'));
    var guidesG = svg.querySelector('.dz-plan__guides');
    var pen = svg.querySelector('.dz-plan__pen');
    var vb = svg.viewBox.baseVal;
    var NS = 'http://www.w3.org/2000/svg';
    var steps = Array.prototype.slice.call(document.querySelectorAll('.dz-draw__steps li'));
    lines.forEach(function (l) { l.setAttribute('pathLength', '1'); l.style.strokeDashoffset = '1'; });

    var seg = lines.map(function (l) {
      var x1 = +l.getAttribute('x1'), y1 = +l.getAttribute('y1'), x2 = +l.getAttribute('x2'), y2 = +l.getAttribute('y2');
      return { el: l, x1: x1, y1: y1, x2: x2, y2: y2, len: Math.hypot(x2 - x1, y2 - y1) };
    });
    // 線の長さに応じた時間（短い線ほど速く、全体でおよそ9秒）
    var TOTAL = 9000, raw = seg.map(function (s, i) {
      var travel = i ? Math.hypot(s.x1 - seg[i - 1].x2, s.y1 - seg[i - 1].y2) : 0;
      return { draw: 40 + Math.sqrt(s.len) * 14, lift: Math.min(travel, 300) * .35 + 14 };
    });
    var sum = raw.reduce(function (a, r) { return a + r.draw + r.lift; }, 0), k = TOTAL / sum;
    var t = 0; seg.forEach(function (s, i) { s.start = t + raw[i].lift * k; s.end = s.start + raw[i].draw * k; t = s.end; });

    function ease(x) { return x < .5 ? 2 * x * x : 1 - Math.pow(-2 * x + 2, 2) / 2; }

    function drawGuides(done) {
      var outer = seg.filter(function (s) { return s.el.classList.contains('o'); });
      outer.forEach(function (s, i) {
        var g = document.createElementNS(NS, 'line');
        if (s.y1 === s.y2) { g.setAttribute('x1', vb.x - 40); g.setAttribute('x2', vb.width + 40); g.setAttribute('y1', s.y1); g.setAttribute('y2', s.y2); }
        else { g.setAttribute('y1', vb.y - 40); g.setAttribute('y2', vb.height + 40); g.setAttribute('x1', s.x1); g.setAttribute('x2', s.x2); }
        g.setAttribute('pathLength', '1');
        g.style.animationDelay = (i * 70) + 'ms';
        guidesG.appendChild(g);
      });
      setTimeout(done, outer.length * 70 + 600);
    }

    function run() {
      plan.classList.add('is-drawing');
      drawGuides(function () {
        var t0 = performance.now(), idx = 0;
        (function frame(now) {
          var el = now - t0;
          while (idx < seg.length && seg[idx].end <= el) { seg[idx].el.style.strokeDashoffset = '0'; idx++; }
          if (idx < seg.length) {
            var s = seg[idx], p = el < s.start ? 0 : ease((el - s.start) / (s.end - s.start));
            s.el.style.strokeDashoffset = String(1 - p);
            // ペン先：線を引いている間は線の先端、持ち上げている間は次の線の始点へ移動
            var px, py;
            if (el < s.start && idx > 0) { var prev = seg[idx - 1], q = ease(Math.min(1, (el - prev.end) / Math.max(1, s.start - prev.end))); px = prev.x2 + (s.x1 - prev.x2) * q; py = prev.y2 + (s.y1 - prev.y2) * q; pen.classList.add('is-up'); }
            else { px = s.x1 + (s.x2 - s.x1) * p; py = s.y1 + (s.y2 - s.y1) * p; pen.classList.remove('is-up'); }
            pen.setAttribute('cx', px); pen.setAttribute('cy', py);
            var stage = Math.min(steps.length - 1, Math.floor(idx / seg.length * steps.length));
            steps.forEach(function (li, j) { li.classList.toggle('is-on', j <= stage); });
            requestAnimationFrame(frame);
          } else {
            plan.classList.add('is-done');
            steps.forEach(function (li) { li.classList.add('is-on'); });
          }
        })(t0);
      });
    }

    if ('IntersectionObserver' in window) {
      var po = new IntersectionObserver(function (en) { if (en[0].isIntersecting) { po.disconnect(); setTimeout(run, 300); } }, { threshold: .45 });
      po.observe(plan);
    } else { run(); }
  }
})();
