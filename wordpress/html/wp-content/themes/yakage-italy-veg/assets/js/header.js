/**
 * ヘッダー: TOP スクロール時スライドイン / ドロワーメニュー
 */
(function () {
  'use strict';

  const SCROLL_THRESHOLD = 800;
  const header = document.getElementById('site-header');
  const hamburger = document.querySelector('.c-hamburger');
  const drawer = document.getElementById('drawer-nav');
  const overlay = document.getElementById('drawer-overlay');

  if (!header) return;

  // TOP ページ: スクロールで固定ヘッダーにクラス付与（スライドイン/スライドアウト）
  if (header.classList.contains('l-header--top')) {
    function onScroll() {
      if (window.scrollY > SCROLL_THRESHOLD) {
        header.classList.remove('is-sliding-out');
        header.classList.add('is-scrolled');
      } else {
        if (header.classList.contains('is-scrolled')) {
          header.classList.add('is-sliding-out');
        } else {
          header.classList.remove('is-scrolled');
          header.classList.remove('is-sliding-out');
        }
      }
    }

    header.addEventListener('animationend', function (e) {
      if (e.animationName === 'headerSlideOut' && header.classList.contains('is-sliding-out')) {
        header.classList.remove('is-scrolled');
        header.classList.remove('is-sliding-out');
      }
    });

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

  // フッター: ページトップへスクロール（700px スクロールでフェードイン）
  const SCROLL_TOP_THRESHOLD = 700;
  const scrollTopBtn = document.querySelector('.c-scroll-top');
  if (scrollTopBtn) {
    function updateScrollTopVisibility() {
      if (window.scrollY > SCROLL_TOP_THRESHOLD) {
        scrollTopBtn.classList.add('is-visible');
      } else {
        scrollTopBtn.classList.remove('is-visible');
      }
    }
    window.addEventListener('scroll', updateScrollTopVisibility, { passive: true });
    updateScrollTopVisibility(); // 初回

    scrollTopBtn.addEventListener('click', function () {
      window.scrollTo({ top: 0, behavior: 'smooth' });
    });
  }
})();
