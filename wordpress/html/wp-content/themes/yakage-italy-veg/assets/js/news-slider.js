/**
 * お知らせセクション: PICKUP スライダー（ループ・自動再生・常に右→左）
 */
(function () {
  'use strict';

  const track = document.querySelector('.p-news__pickup-track');
  const dotsContainer = document.querySelector('[data-slider-dots]');
  const prevBtn = document.querySelector('.p-news__pickup-arrow--prev');
  const nextBtn = document.querySelector('.p-news__pickup-arrow--next');
  const sliderEl = document.querySelector('.p-news__pickup-slider');

  if (!track || !dotsContainer) return;

  const slides = track.querySelectorAll('.p-news__pickup-slide');
  const realTotal = slides.length;
  if (realTotal <= 1) return;

  // ループ用: 先頭スライドのクローンを末尾に追加（右→左で最後→最初に戻るため）
  const firstClone = slides[0].cloneNode(true);
  track.appendChild(firstClone);

  const total = realTotal + 1;
  const allSlides = track.querySelectorAll('.p-news__pickup-slide');
  track.style.width = (total * 100) + '%';
  Array.prototype.forEach.call(allSlides, function (s) {
    s.style.flex = '0 0 ' + (100 / total) + '%';
  });

  let current = 0;
  const slideWidthPercent = 100 / total;
  const AUTO_PLAY_INTERVAL = 5000;
  let autoPlayTimer = null;
  let isTransitioning = false;

  function goTo(index, noTransition) {
    if (noTransition) {
      track.style.transition = 'none';
    }
    current = ((index % total) + total) % total;
    track.style.transform = 'translateX(-' + current * slideWidthPercent + '%)';
    var displayIndex = current >= realTotal ? 0 : current;
    dotsContainer.querySelectorAll('.p-news__pickup-dot').forEach(function (dot, i) {
      dot.classList.toggle('p-news__pickup-dot--active', i === displayIndex);
    });
    if (noTransition) {
      track.offsetHeight; // reflow
      track.style.transition = '';
    }
    resetAutoPlay();
  }

  function onTransitionEnd() {
    if (current === total - 1) {
      isTransitioning = true;
      goTo(0, true);
      isTransitioning = false;
    }
  }

  track.addEventListener('transitionend', onTransitionEnd);

  function goNext() {
    if (isTransitioning) return;
    goTo(current + 1);
  }

  function goPrev() {
    if (isTransitioning) return;
    if (current === 0) {
      goTo(realTotal - 1);
    } else {
      goTo(current - 1);
    }
  }

  function startAutoPlay() {
    stopAutoPlay();
    autoPlayTimer = setInterval(goNext, AUTO_PLAY_INTERVAL);
  }

  function stopAutoPlay() {
    if (autoPlayTimer) {
      clearInterval(autoPlayTimer);
      autoPlayTimer = null;
    }
  }

  function resetAutoPlay() {
    startAutoPlay();
  }

  if (prevBtn) {
    prevBtn.addEventListener('click', goPrev);
  }
  if (nextBtn) {
    nextBtn.addEventListener('click', goNext);
  }
  dotsContainer.querySelectorAll('.p-news__pickup-dot').forEach(function (dot) {
    dot.addEventListener('click', function () {
      var index = parseInt(dot.getAttribute('data-index'), 10);
      if (!isNaN(index)) goTo(index);
    });
  });

  if (sliderEl) {
    sliderEl.addEventListener('mouseenter', stopAutoPlay);
    sliderEl.addEventListener('mouseleave', startAutoPlay);
  }

  startAutoPlay();
})();
