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
})();
