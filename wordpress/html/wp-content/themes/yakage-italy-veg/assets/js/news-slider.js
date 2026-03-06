/**
 * お知らせセクション: PICKUP スライダー（ループ）
 */
(function () {
  'use strict';

  const track = document.querySelector('.p-news__pickup-track');
  const dotsContainer = document.querySelector('[data-slider-dots]');
  const prevBtn = document.querySelector('.p-news__pickup-arrow--prev');
  const nextBtn = document.querySelector('.p-news__pickup-arrow--next');

  if (!track || !dotsContainer) return;

  const slides = track.querySelectorAll('.p-news__pickup-slide');
  const total = slides.length;
  if (total <= 1) return;

  track.style.width = (total * 100) + '%';
  Array.prototype.forEach.call(slides, function (s) {
    s.style.flex = '0 0 ' + (100 / total) + '%';
  });

  let current = 0;

  function goTo(index) {
    current = ((index % total) + total) % total;
    track.style.transform = 'translateX(-' + current * 100 + '%)';
    dotsContainer.querySelectorAll('.p-news__pickup-dot').forEach(function (dot, i) {
      dot.classList.toggle('p-news__pickup-dot--active', i === current);
    });
  }

  if (prevBtn) {
    prevBtn.addEventListener('click', function () {
      goTo(current - 1);
    });
  }
  if (nextBtn) {
    nextBtn.addEventListener('click', function () {
      goTo(current + 1);
    });
  }
  dotsContainer.querySelectorAll('.p-news__pickup-dot').forEach(function (dot) {
    dot.addEventListener('click', function () {
      var index = parseInt(dot.getAttribute('data-index'), 10);
      if (!isNaN(index)) goTo(index);
    });
  });
})();
