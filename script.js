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

  // 同じ親の中で順番に現れる「ずらし表示」（リズム感のある動き）
  revealTargets.forEach(function (el) {
    if (el.closest('.hero')) return; // ヒーローは専用アニメ
    var sibs = Array.prototype.filter.call(el.parentNode.children, function (c) { return c.hasAttribute && c.hasAttribute('data-reveal'); });
    var i = sibs.indexOf(el);
    if (i > 0) el.style.transitionDelay = Math.min(i * 0.08, 0.4) + 's';
  });

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
     6. イントロのヴェール（読み込み時にFORTがふわっと開く）
        ・1セッションに1回だけ表示（ページ遷移のたびには出さない）
  -------------------------------------------------------- */
  var reduceMotion = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  try {
    if (!reduceMotion && !sessionStorage.getItem('fortIntroDone')) {
      var intro = document.createElement('div');
      intro.className = 'intro';
      intro.innerHTML = '<div class="intro__inner"><span class="intro__logo">FORT</span><span class="intro__line"></span><span class="intro__tag">Design × Performance × Balance</span></div>';
      body.appendChild(intro);
      body.classList.add('intro-lock');
      sessionStorage.setItem('fortIntroDone', '1');
      window.setTimeout(function () {
        intro.classList.add('is-hidden');
        body.classList.remove('intro-lock');
        window.setTimeout(function () { intro.remove(); }, 1000);
      }, 1900);
    }
  } catch (err) { /* sessionStorage が使えない環境は無視 */ }

  /* --------------------------------------------------------
     7. 上部のスクロール進捗バー
  -------------------------------------------------------- */
  var bar = document.createElement('div');
  bar.className = 'scrollbar';
  body.appendChild(bar);
  function onProgress() {
    var h = document.documentElement;
    var max = h.scrollHeight - h.clientHeight;
    bar.style.width = (max > 0 ? (h.scrollTop / max) * 100 : 0) + '%';
  }
  onProgress();
  window.addEventListener('scroll', onProgress, { passive: true });
  window.addEventListener('resize', onProgress);

  /* --------------------------------------------------------
     8. パララックス（[data-parallax] をゆっくり動かす）
        data-parallax="0.2" のように強さを指定（省略時0.15）
  -------------------------------------------------------- */
  var parallaxEls = Array.prototype.slice.call(document.querySelectorAll('[data-parallax]'));
  if (parallaxEls.length && !reduceMotion) {
    var ticking = false;
    function parallax() {
      var vh = window.innerHeight;
      parallaxEls.forEach(function (el) {
        var r = el.getBoundingClientRect();
        if (r.bottom < 0 || r.top > vh) return;
        var speed = parseFloat(el.dataset.parallax) || 0.15;
        var offset = (r.top + r.height / 2 - vh / 2) * -speed;
        el.style.transform = 'translate3d(0,' + offset.toFixed(1) + 'px,0)';
      });
      ticking = false;
    }
    window.addEventListener('scroll', function () {
      if (!ticking) { window.requestAnimationFrame(parallax); ticking = true; }
    }, { passive: true });
    parallax();
  }

});
