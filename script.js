/* ============================================================
   株式会社FORT ブランドサイト / JavaScript
   ------------------------------------------------------------
   この1ファイルで以下の動きを管理しています：
   1. ヘッダー：スクロールすると背景を白くする
   2. 全ページメニュー（右上MENUボタンで開く目次）を自動生成＆開閉
   3. スクロールで要素をふわっと表示する（reveal）
   4. 画像が無いときの保険（フォールバック）

   ★ ページを増やしたときは、下の「MENU（メニュー項目）」に
     1行追加するだけで、全ページの目次に反映されます。
============================================================ */

document.addEventListener('DOMContentLoaded', function () {

  var header = document.getElementById('header');
  var body   = document.body;

  /* --------------------------------------------------------
     1. ヘッダー：スクロール量で見た目を切り替える
  -------------------------------------------------------- */
  function onScroll() {
    if (window.scrollY > 60) header.classList.add('is-scrolled');
    else header.classList.remove('is-scrolled');
  }
  onScroll();
  window.addEventListener('scroll', onScroll, { passive: true });

  /* --------------------------------------------------------
     2. 全ページメニュー（目次）
     ------------------------------------------------------------
     ▼ MENU：サイトの全ページ一覧。
       { en: 英語表記, ja: 日本語, href: リンク先 }
       ページを増やしたらここに1行足してください。
  -------------------------------------------------------- */
  var MENU = [
    { en: 'HOME',     ja: 'トップ',             href: 'index.html' },
    { en: 'PHILOSOPHY', ja: 'FORTの思い',       href: 'index.html#philosophy' },
    { en: 'EVENT',    ja: '見学会・イベント',   href: 'event.html' },
    { en: 'PERFORMANCE', ja: '構造・性能',      href: 'performance.html' },
    { en: 'WORKS',    ja: '施工事例',           href: 'works.html' },
    { en: 'FORT FAMILY', ja: 'お客様の声',      href: 'index.html#family' },
    { en: 'LINEUP',   ja: '商品ラインナップ',   href: 'lineup.html' },
    { en: 'FLOW',     ja: '家づくりの流れ',     href: 'flow.html' },
    { en: 'STAFF',    ja: 'スタッフ紹介',       href: 'staff.html' },
    { en: 'STUDIO',   ja: 'モデルハウス・スタジオ', href: 'studio.html' },
    { en: 'NEWS',     ja: 'お知らせ',           href: 'index.html#news' },
    { en: 'COMPANY',  ja: '会社概要',           href: 'company.html' },
    { en: 'CONTACT',  ja: 'ご予約・お問い合わせ', href: 'contact.html' }
  ];

  // 今開いているページのファイル名（例：staff.html）を調べる
  var currentFile = location.pathname.split('/').pop() || 'index.html';

  // メニューの中身（HTML）を組み立てる
  var itemsHtml = MENU.map(function (item, i) {
    var num  = ('0' + (i + 1)).slice(-2);            // 01, 02, ...
    var file = item.href.split('#')[0];              // リンク先のファイル名
    var isActive = (file === currentFile && item.href.indexOf('#') === -1);
    return ''
      + '<li class="gmenu__item' + (isActive ? ' is-active' : '') + '" style="--i:' + i + '">'
      +   '<a href="' + item.href + '">'
      +     '<span class="gmenu__num">' + num + '</span>'
      +     '<span class="gmenu__en">' + item.en + '</span>'
      +     '<span class="gmenu__ja">' + item.ja + '</span>'
      +   '</a>'
      + '</li>';
  }).join('');

  // オーバーレイ（目次）本体を作ってページに追加
  var overlay = document.createElement('div');
  overlay.className = 'gmenu';
  overlay.id = 'globalMenu';
  overlay.setAttribute('aria-hidden', 'true');
  overlay.innerHTML = ''
    + '<div class="gmenu__panel">'
    +   '<ul class="gmenu__list">' + itemsHtml + '</ul>'
    +   '<div class="gmenu__foot">'
    +     '<div class="gmenu__cta">'
    +       '<a class="btn btn--accent" href="visit.html">ご来場予約</a>'
    +       '<a class="btn btn--outline btn--outline-light" href="request.html">資料請求</a>'
    +     '</div>'
    +     '<p class="gmenu__company">株式会社FORT｜岡山・倉敷・福山エリアの家づくり<br>岡山スタジオ 086-236-9600 ／ 福山スタジオ 084-982-7404（9:00〜18:00 / 水曜定休）</p>'
    +   '</div>'
    + '</div>';
  body.appendChild(overlay);

  // 開く・閉じるの処理
  var toggle = document.getElementById('menuToggle');

  function openMenu() {
    overlay.classList.add('is-open');
    body.classList.add('menu-open');
    overlay.setAttribute('aria-hidden', 'false');
    if (toggle) toggle.setAttribute('aria-expanded', 'true');
  }
  function closeMenu() {
    overlay.classList.remove('is-open');
    body.classList.remove('menu-open');
    overlay.setAttribute('aria-hidden', 'true');
    if (toggle) toggle.setAttribute('aria-expanded', 'false');
  }
  function toggleMenu() {
    if (overlay.classList.contains('is-open')) closeMenu();
    else openMenu();
  }

  if (toggle) toggle.addEventListener('click', toggleMenu);

  // 背景（パネルの外）をクリックしたら閉じる
  overlay.addEventListener('click', function (e) {
    if (e.target === overlay) closeMenu();
  });
  // メニュー内のリンクを押したら閉じる
  overlay.querySelectorAll('a').forEach(function (a) {
    a.addEventListener('click', closeMenu);
  });
  // Escキーで閉じる
  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') closeMenu();
  });

  /* --------------------------------------------------------
     3. スクロールで要素をふわっと表示する（reveal）
  -------------------------------------------------------- */
  var revealTargets = document.querySelectorAll('[data-reveal]');

  if ('IntersectionObserver' in window) {
    var observer = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          entry.target.classList.add('is-visible');
          observer.unobserve(entry.target);
        }
      });
    }, { threshold: 0.12, rootMargin: '0px 0px -8% 0px' });

    revealTargets.forEach(function (el) { observer.observe(el); });
  } else {
    revealTargets.forEach(function (el) { el.classList.add('is-visible'); });
  }

  /* --------------------------------------------------------
     4. 画像の保険（フォールバック）
        images/ の写真がまだ無い場合でも、
        「画像が壊れたアイコン」ではなく仮画像を表示する。
  -------------------------------------------------------- */
  document.querySelectorAll('img[src^="images/"]').forEach(function (img) {
    img.addEventListener('error', function () {
      if (img.dataset.fallback) return;
      img.dataset.fallback = '1';
      img.src = 'https://placehold.co/1200x800/e7e3dc/b3a896?text=FORT';
    });
  });

  /* --------------------------------------------------------
     5. 施工事例（WORKS）の絞り込み
        ・カテゴリタブ（data-filter）と金額プルダウン（#worksPrice）で
          .works__card を出し分けする
  -------------------------------------------------------- */
  var worksFilter = document.getElementById('worksFilter');
  var worksGrid   = document.getElementById('worksGrid');
  if (worksFilter && worksGrid) {
    var priceSel = document.getElementById('worksPrice');
    var emptyMsg = document.getElementById('worksEmpty');
    var cards    = Array.prototype.slice.call(worksGrid.querySelectorAll('.works__card'));
    var curCat   = 'all';

    function applyWorksFilter() {
      var pr = priceSel ? priceSel.value : 'all';
      var lo = -Infinity, hi = Infinity;
      if (pr !== 'all') { var p = pr.split('-'); lo = +p[0]; hi = +p[1]; }
      var shown = 0;
      cards.forEach(function (card) {
        var cats  = (card.dataset.cat || '').split(/\s+/);
        var price = +card.dataset.price || 0;
        var okCat = (curCat === 'all') || cats.indexOf(curCat) !== -1;
        var okPr  = (pr === 'all') || (price >= lo && price <= hi);
        var show  = okCat && okPr;
        card.classList.toggle('is-hidden', !show);
        if (show) shown++;
      });
      if (emptyMsg) emptyMsg.classList.toggle('is-shown', shown === 0);
    }

    worksFilter.addEventListener('click', function (e) {
      var a = e.target.closest('a[data-filter]');
      if (!a) return;
      e.preventDefault();
      curCat = a.dataset.filter;
      worksFilter.querySelectorAll('a').forEach(function (x) { x.classList.toggle('is-active', x === a); });
      applyWorksFilter();
    });
    if (priceSel) priceSel.addEventListener('change', applyWorksFilter);
  }

  /* --------------------------------------------------------
     6. 横スクロールのカルーセルをマウスでドラッグできるように
        （.hscroll を掴んで左右に動かせる。スマホは標準スワイプ）
  -------------------------------------------------------- */
  document.querySelectorAll('.hscroll').forEach(function (track) {
    var down = false, startX = 0, startLeft = 0, moved = 0;
    track.addEventListener('pointerdown', function (e) {
      if (e.pointerType !== 'mouse') return; // タッチは標準スクロールに任せる
      down = true; moved = 0;
      startX = e.clientX; startLeft = track.scrollLeft;
      track.setPointerCapture(e.pointerId);
    });
    track.addEventListener('pointermove', function (e) {
      if (!down) return;
      var dx = e.clientX - startX;
      if (Math.abs(dx) > 4) { track.classList.add('is-dragging'); moved = Math.abs(dx); }
      track.scrollLeft = startLeft - dx;
    });
    function end() {
      down = false;
      window.setTimeout(function () { track.classList.remove('is-dragging'); }, 0);
    }
    track.addEventListener('pointerup', end);
    track.addEventListener('pointercancel', end);
    track.addEventListener('pointerleave', function () { if (down) end(); });
    // ドラッグ直後のクリックでリンクが飛ぶのを防ぐ
    track.addEventListener('click', function (e) {
      if (moved > 6) { e.preventDefault(); moved = 0; }
    }, true);
  });

  /* --------------------------------------------------------
     7. 没入スクロール演出
        7-1 写真のカーテンリビール（[data-wipe]）
        7-2 文章の行ごと点灯（[data-lines]）
        7-3 FORT STORY 固定章（.story）
        7-4 パララックス（[data-parallax]）
        7-5 ヒーローがスクロールで溶けるように退場
  -------------------------------------------------------- */
  var reduceMotion = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  // 7-1 [data-wipe] にも is-visible を付与（既存の reveal と同じ考え方）
  var wipeTargets = document.querySelectorAll('[data-wipe]');
  if (wipeTargets.length) {
    if ('IntersectionObserver' in window && !reduceMotion) {
      var wipeObs = new IntersectionObserver(function (entries) {
        entries.forEach(function (en) {
          if (en.isIntersecting) { en.target.classList.add('is-visible'); wipeObs.unobserve(en.target); }
        });
      }, { threshold: 0.25 });
      wipeTargets.forEach(function (el) { wipeObs.observe(el); });
    } else {
      wipeTargets.forEach(function (el) { el.classList.add('is-visible'); });
    }
  }

  // 7-2 [data-lines]：<br> 区切りの各行を span.line に分割して時間差表示
  document.querySelectorAll('[data-lines]').forEach(function (el) {
    var parts = el.innerHTML.split(/<br\s*\/?>/i);
    el.innerHTML = parts.map(function (p, i) {
      if (p.replace(/&nbsp;|\s/g, '') === '') return '<br>';
      return '<span class="line" style="--line-delay:' + (i * 0.14) + 's">' + p + '</span><br>';
    }).join('');
  });

  // 7-3 FORT STORY：スクロール量で言葉を切り替える
  var story = document.querySelector('.story');
  var storyWords = story ? Array.prototype.slice.call(story.querySelectorAll('.story__word')) : [];
  var storyBar = story ? story.querySelector('.story__progress span') : null;

  // 7-4 パララックス対象
  var parallaxEls = Array.prototype.slice.call(document.querySelectorAll('[data-parallax]'));

  // 7-5 ヒーロー退場の対象（トップページのみ存在）
  var heroSec  = document.querySelector('.hero--logo');
  var heroBits = heroSec ? Array.prototype.slice.call(
    heroSec.querySelectorAll('.hero__logobox, .hero__note, .hero__actions--br')) : [];
  var heroIntroKilled = false;

  function immersiveFrame() {
    var vh = window.innerHeight;

    // --- FORT STORY ---
    if (story && storyWords.length) {
      var r = story.getBoundingClientRect();
      var total = r.height - vh;
      var p = total > 0 ? Math.min(1, Math.max(0, -r.top / total)) : 0;
      var idx = Math.min(storyWords.length - 1, Math.floor(p * storyWords.length));
      storyWords.forEach(function (w, i) { w.classList.toggle('is-active', i === idx); });
      if (storyBar) storyBar.style.width = (p * 100) + '%';
    }

    // --- パララックス ---
    if (!reduceMotion) {
      parallaxEls.forEach(function (el) {
        var pr = el.getBoundingClientRect();
        if (pr.bottom < 0 || pr.top > vh) return;
        var speed = parseFloat(el.dataset.parallax) || 0.12;
        var off = (pr.top + pr.height / 2 - vh / 2) * -speed;
        var scale = el.dataset.pscale ? ' scale(' + el.dataset.pscale + ')' : '';
        el.style.transform = 'translate3d(0,' + off.toFixed(1) + 'px,0)' + scale;
      });
    }

    // --- ヒーロー退場（下へスクロールすると静かに溶ける） ---
    if (heroSec && heroBits.length && !reduceMotion) {
      var y = window.scrollY;
      if (y > 30 && !heroIntroKilled) {
        // 登場アニメ（CSS animation）を止めてJS制御に切り替える
        heroBits.forEach(function (el) { el.style.animation = 'none'; el.style.filter = 'none'; });
        heroIntroKilled = true;
      }
      if (heroIntroKilled) {
        var hp = Math.min(1, y / (vh * 0.85));
        heroBits.forEach(function (el) {
          el.style.opacity = String(1 - hp * 1.15);
          el.style.transform = 'translateY(' + (-hp * 46).toFixed(1) + 'px)';
        });
      }
    }
  }

  var immersiveTick = false;
  function onImmersiveScroll() {
    if (!immersiveTick) {
      window.requestAnimationFrame(function () { immersiveFrame(); immersiveTick = false; });
      immersiveTick = true;
    }
  }
  if (story || parallaxEls.length || heroSec) {
    window.addEventListener('scroll', onImmersiveScroll, { passive: true });
    window.addEventListener('resize', onImmersiveScroll);
    immersiveFrame();
  }

});
