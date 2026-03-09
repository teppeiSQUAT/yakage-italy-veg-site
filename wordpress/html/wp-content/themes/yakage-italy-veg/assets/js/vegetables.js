/**
 * イタリア野菜とは: スマホでカードタップ時にオーバーレイを開閉
 * PC は CSS の hover のみで表示
 */
(function () {
  'use strict';

  var section = document.querySelector('.p-vegetables');
  if (!section) return;

  var grid = section.querySelector('.p-vegetables__grid');
  var cards = grid ? grid.querySelectorAll('.p-vegetables__card') : [];

  function closeAll() {
    cards.forEach(function (card) {
      card.classList.remove('is-open');
    });
  }

  function isTouchDevice() {
    return 'ontouchstart' in window || navigator.maxTouchPoints > 0;
  }

  if (grid && cards.length) {
    grid.addEventListener('click', function (e) {
      var card = e.target.closest('.p-vegetables__card');
      if (!card) return;

      // スマホ・タッチ時: タップで開閉
      if (isTouchDevice() || window.innerWidth <= 767) {
        e.preventDefault();
        var wasOpen = card.classList.contains('is-open');
        closeAll();
        if (!wasOpen) {
          card.classList.add('is-open');
        }
      }
    });
  }

  // グリッド外タップで閉じる（スマホ）
  document.addEventListener('click', function (e) {
    if (!section.contains(e.target) && isTouchDevice()) {
      closeAll();
    }
  });
})();
