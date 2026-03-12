/**
 * 生産者紹介: 無限ループスライダー（自走再生・左に流れる）
 * 末尾に先頭6枚のクローンを追加し、最後の次は先頭が続いて見えるようにする。
 */
(function () {
  'use strict';

  var AUTO_INTERVAL_MS = 5000;

  var section = document.querySelector('.p-producers');
  var track = document.querySelector('[data-producers-track]');
  var dotsContainer = document.querySelector('[data-producers-dots]');
  var prevBtn = document.querySelector('.p-producers__arrow--prev');
  var nextBtn = document.querySelector('.p-producers__arrow--next');

  if (!track || !dotsContainer) return;

  var cards = track.querySelectorAll('.p-producers__card');
  var LOGICAL_COUNT = cards.length; // 本来の枚数（ドット数）
  if (LOGICAL_COUNT === 0) return;

  // 先頭6枚をクローンして末尾に追加 → 12枚で「最後の次に先頭」が続く
  for (var i = 0; i < LOGICAL_COUNT; i++) {
    track.appendChild(cards[i].cloneNode(true));
  }

  var position = 0; // 0〜6（6のとき表示はクローン先頭＝論理0、その後リセット）
  var autoTimer = null;
  var isTransitioning = false;

  function updateDots() {
    var logical = position === LOGICAL_COUNT ? 0 : position;
    dotsContainer.querySelectorAll('.p-producers__dot').forEach(function (dot, i) {
      dot.classList.toggle('p-producers__dot--active', i === logical);
    });
  }

  function applyPosition(noTransition) {
    if (noTransition) {
      track.style.transition = 'none';
      track.style.setProperty('--producers-current', String(position));
      track.offsetHeight; // reflow
      track.style.transition = '';
    } else {
      track.style.setProperty('--producers-current', String(position));
    }
    updateDots();
  }

  function onTransitionEnd() {
    if (position === LOGICAL_COUNT) {
      position = 0;
      applyPosition(true);
    }
    isTransitioning = false;
  }

  if (track) {
    track.addEventListener('transitionend', onTransitionEnd);
  }

  function goNext() {
    if (isTransitioning) return;
    isTransitioning = true;
    position = position + 1; // 5 → 6 でクローン先頭表示、transitionend で 0 にリセット
    applyPosition(false);
  }

  function goPrev() {
    if (isTransitioning) return;
    if (position === 0) {
      // 先頭のひとつ前＝論理の最後。クローン先頭に飛んでから 最後-1 へアニメ
      position = LOGICAL_COUNT;
      applyPosition(true);
      requestAnimationFrame(function () {
        requestAnimationFrame(function () {
          position = LOGICAL_COUNT - 1;
          applyPosition(false);
        });
      });
    } else {
      position = position - 1;
      applyPosition(false);
    }
  }

  function goToLogical(index) {
    var logical = ((index % LOGICAL_COUNT) + LOGICAL_COUNT) % LOGICAL_COUNT;
    position = logical;
    applyPosition(false);
    isTransitioning = false;
  }

  function startAuto() {
    stopAuto();
    autoTimer = setInterval(goNext, AUTO_INTERVAL_MS);
  }

  function stopAuto() {
    if (autoTimer) {
      clearInterval(autoTimer);
      autoTimer = null;
    }
  }

  if (prevBtn) {
    prevBtn.addEventListener('click', function () {
      goPrev();
      startAuto();
    });
  }
  if (nextBtn) {
    nextBtn.addEventListener('click', function () {
      goNext();
      startAuto();
    });
  }
  dotsContainer.querySelectorAll('.p-producers__dot').forEach(function (dot) {
    dot.addEventListener('click', function () {
      var index = parseInt(dot.getAttribute('data-index'), 10);
      if (!isNaN(index)) {
        goToLogical(index);
        startAuto();
      }
    });
  });

  applyPosition(true);
  startAuto();

  if (section) {
    section.addEventListener('mouseenter', stopAuto);
    section.addEventListener('mouseleave', startAuto);
    section.addEventListener('focusin', stopAuto);
    section.addEventListener('focusout', startAuto);
  }
})();
