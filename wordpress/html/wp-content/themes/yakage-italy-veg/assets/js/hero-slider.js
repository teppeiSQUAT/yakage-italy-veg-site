/**
 * ヒーローセクション: 8枚の画像をフェードイン・フェードアウトで切り替え
 */
(function () {
  'use strict';

  var INTERVAL_MS = 5000;

  var section = document.getElementById('hero-slider');
  if (!section) return;

  var slides = section.querySelectorAll('.p-hero__slide');
  var dots = section.querySelectorAll('[data-hero-dot-index]');
  var total = slides.length;
  if (total === 0) return;

  var current = 0;
  var timer = null;

  function goTo(index) {
    current = ((index % total) + total) % total;
    slides.forEach(function (slide, i) {
      slide.classList.toggle('p-hero__slide--active', i === current);
    });
    dots.forEach(function (dot, i) {
      dot.classList.toggle('p-hero__dot--active', i === current);
      dot.setAttribute('aria-current', i === current ? 'true' : 'false');
    });
  }

  function next() {
    goTo(current + 1);
  }

  function startTimer() {
    stopTimer();
    timer = setInterval(next, INTERVAL_MS);
  }

  function stopTimer() {
    if (timer) {
      clearInterval(timer);
      timer = null;
    }
  }

  dots.forEach(function (dot) {
    dot.addEventListener('click', function () {
      var index = parseInt(dot.getAttribute('data-hero-dot-index'), 10);
      if (!isNaN(index)) {
        goTo(index);
        startTimer();
      }
    });
  });

  section.addEventListener('mouseenter', stopTimer);
  section.addEventListener('mouseleave', startTimer);

  startTimer();
})();
