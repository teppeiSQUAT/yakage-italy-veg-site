/**
 * ヘッダー: TOP スクロール時スライドイン / ドロワーメニュー
 */
(function () {
  'use strict';

  const SCROLL_THRESHOLD = 80;
  const header = document.getElementById('site-header');
  const hamburger = document.querySelector('.c-hamburger');
  const drawer = document.getElementById('drawer-nav');
  const overlay = document.getElementById('drawer-overlay');

  if (!header) return;

  // TOP ページ: スクロールで固定ヘッダーにクラス付与
  if (header.classList.contains('l-header--top')) {
    function onScroll() {
      if (window.scrollY > SCROLL_THRESHOLD) {
        header.classList.add('is-scrolled');
      } else {
        header.classList.remove('is-scrolled');
      }
    }
    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll(); // 初回
  }

  // ドロワー開閉
  function openDrawer() {
    document.body.classList.add('is-drawer-open');
    if (hamburger) {
      hamburger.setAttribute('aria-expanded', 'true');
      hamburger.setAttribute('aria-label', 'メニューを閉じる');
    }
    if (overlay) overlay.setAttribute('aria-hidden', 'false');
    if (drawer) drawer.setAttribute('aria-hidden', 'false');
  }

  function closeDrawer() {
    document.body.classList.remove('is-drawer-open');
    if (hamburger) {
      hamburger.setAttribute('aria-expanded', 'false');
      hamburger.setAttribute('aria-label', 'メニューを開く');
    }
    if (overlay) overlay.setAttribute('aria-hidden', 'true');
    if (drawer) drawer.setAttribute('aria-hidden', 'true');
  }

  if (hamburger) {
    hamburger.addEventListener('click', function () {
      if (document.body.classList.contains('is-drawer-open')) {
        closeDrawer();
      } else {
        openDrawer();
      }
    });
  }

  if (overlay) {
    overlay.addEventListener('click', closeDrawer);
  }

  // ドロワー内リンククリックで閉じる
  if (drawer) {
    drawer.addEventListener('click', function (e) {
      if (e.target.matches('a')) closeDrawer();
    });
  }

  // フッター: ページトップへスクロール
  const scrollTopBtn = document.querySelector('.c-scroll-top');
  if (scrollTopBtn) {
    scrollTopBtn.addEventListener('click', function () {
      window.scrollTo({ top: 0, behavior: 'smooth' });
    });
  }
})();
