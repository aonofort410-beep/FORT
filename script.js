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
    { en: 'CONCEPT',  ja: '私たちの想い',       href: 'index.html#concept' },
    { en: 'WHY FORT', ja: '選ばれる理由',       href: 'index.html#why' },
    { en: 'WORKS',    ja: '施工事例',           href: 'works.html' },
    { en: 'FEATURE',  ja: '特集',               href: 'index.html#feature' },
    { en: 'PERFORMANCE', ja: '構造・性能',      href: 'index.html#performance' },
    { en: 'LINEUP',   ja: '商品ラインナップ',   href: 'lineup.html' },
    { en: 'EVENT',    ja: '見学会・イベント',   href: 'event.html' },
    { en: 'FLOW',     ja: '家づくりの流れ',     href: 'index.html#flow' },
    { en: 'STUDIO',   ja: 'スタジオ・モデルハウス', href: 'studio.html' },
    { en: 'STAFF',    ja: 'スタッフ紹介',       href: 'staff.html' },
    { en: 'NEWS',     ja: 'お知らせ',           href: 'index.html#news' },
    { en: 'COMPANY',  ja: '会社概要',           href: 'company.html' },
    { en: 'CONTACT',  ja: 'ご予約・お問い合わせ', href: 'index.html#reserve' }
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
    +       '<a class="btn btn--accent" href="index.html#reserve">来場予約・お問い合わせ</a>'
    +       '<a class="btn btn--outline btn--outline-light" href="index.html#reserve">資料請求</a>'
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

});
