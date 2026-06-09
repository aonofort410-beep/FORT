/* ============================================================
   株式会社FORT ブランドサイト / JavaScript
   ------------------------------------------------------------
   この1ファイルで以下の動きを管理しています：
   1. ヘッダー：スクロールすると背景を白くする
   2. ハンバーガーメニュー：スマホでナビを開閉する
   3. スクロールで要素をふわっと表示する（reveal）
   4. メニュー内リンクを押したら自動で閉じる
   5. 現在のセクションに合わせてナビを光らせる（任意）

   ※ 初心者の方へ：基本的にここを編集しなくても動きます。
============================================================ */

// HTMLの読み込みが終わってから実行する（安全のため）
document.addEventListener('DOMContentLoaded', function () {

  /* --------------------------------------------------------
     よく使う要素を最初に取得しておく
  -------------------------------------------------------- */
  var header    = document.getElementById('header');
  var hamburger = document.getElementById('hamburger');
  var nav       = document.getElementById('nav');
  var body      = document.body;

  /* --------------------------------------------------------
     1. ヘッダー：スクロール量で見た目を切り替える
        60pxより下にスクロールしたら .is-scrolled を付ける
  -------------------------------------------------------- */
  function onScroll() {
    if (window.scrollY > 60) {
      header.classList.add('is-scrolled');
    } else {
      header.classList.remove('is-scrolled');
    }
  }
  // ページ表示時とスクロール時に判定
  onScroll();
  window.addEventListener('scroll', onScroll, { passive: true });

  /* --------------------------------------------------------
     2. ハンバーガーメニューの開閉（スマホ用）
  -------------------------------------------------------- */
  function closeMenu() {
    hamburger.classList.remove('is-open');
    nav.classList.remove('is-open');
    body.classList.remove('menu-open');
    hamburger.setAttribute('aria-expanded', 'false');
  }

  function toggleMenu() {
    var willOpen = !nav.classList.contains('is-open');
    hamburger.classList.toggle('is-open', willOpen);
    nav.classList.toggle('is-open', willOpen);
    body.classList.toggle('menu-open', willOpen);
    // スクリーンリーダー向けに開閉状態を伝える
    hamburger.setAttribute('aria-expanded', willOpen ? 'true' : 'false');
  }

  if (hamburger) {
    hamburger.addEventListener('click', toggleMenu);
  }

  /* --------------------------------------------------------
     4. メニュー内のリンクを押したらメニューを閉じる
        （ページ内移動した後にメニューが開いたままになるのを防ぐ）
  -------------------------------------------------------- */
  nav.querySelectorAll('a').forEach(function (link) {
    link.addEventListener('click', closeMenu);
  });

  // 画面を広げてPC表示になったらメニュー状態をリセット
  window.addEventListener('resize', function () {
    if (window.innerWidth > 767) closeMenu();
  });

  /* --------------------------------------------------------
     3. スクロールで要素をふわっと表示する（reveal）
        data-reveal が付いた要素が画面に入ったら .is-visible を付与
        → CSS側でフェードイン
  -------------------------------------------------------- */
  var revealTargets = document.querySelectorAll('[data-reveal]');

  // IntersectionObserver が使えるブラウザなら効率的に監視
  if ('IntersectionObserver' in window) {
    var observer = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          entry.target.classList.add('is-visible');
          observer.unobserve(entry.target); // 一度表示したら監視終了
        }
      });
    }, {
      threshold: 0.12,        // 12%見えたら発火
      rootMargin: '0px 0px -8% 0px'
    });

    revealTargets.forEach(function (el) { observer.observe(el); });
  } else {
    // 古いブラウザ向けのフォールバック：すべて表示
    revealTargets.forEach(function (el) { el.classList.add('is-visible'); });
  }

  /* --------------------------------------------------------
     5. 現在地に合わせてナビを光らせる（スクロールスパイ）
        各セクションが画面中央付近に来たら、対応するナビに .is-active
  -------------------------------------------------------- */
  var sections = document.querySelectorAll('main section[id]');
  var navLinks = nav.querySelectorAll('.nav__link');

  if ('IntersectionObserver' in window && navLinks.length) {
    var spy = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          var id = entry.target.getAttribute('id');
          navLinks.forEach(function (link) {
            var match = link.getAttribute('href') === '#' + id;
            link.classList.toggle('is-active', match);
          });
        }
      });
    }, { rootMargin: '-45% 0px -45% 0px' });

    sections.forEach(function (sec) { spy.observe(sec); });
  }

  /* --------------------------------------------------------
     6. 画像の保険（フォールバック）
        images/ フォルダの写真がまだ無い場合でも、
        「画像が壊れたアイコン」ではなく仮画像を表示する。
        → 写真をアップロードすれば自動で本物に切り替わります。
  -------------------------------------------------------- */
  document.querySelectorAll('img[src^="images/"]').forEach(function (img) {
    img.addEventListener('error', function () {
      // 二重に発火しないよう、一度だけ差し替える
      if (img.dataset.fallback) return;
      img.dataset.fallback = '1';
      img.src = 'https://placehold.co/1200x800/e7e3dc/b3a896?text=FORT';
    });
  });

});
