/*
  Making email checking delay slower.
 */
(function ($, Drupal, drupalSettings) {
  'use strict';
  Drupal.behaviors.evilargest_finishedinput = {
    attach: function (context, settings) {
      var typingTimer;
      var delay = 1100;
      $('[id^="edit-email"]').once('finished_input').on('keyup', function (e) {
        clearTimeout(typingTimer);
        if ($(this).val()) {
          var trigid = $(this);
          typingTimer = setTimeout(function () {
            trigid.triggerHandler('finishedinput');
          }, delay);
        }
      });
      /*
          Picture overlay.
       */
      $(".image_wrapper").once().on('click', function (event) {
        $(this).toggleClass("overlay");
        $(this).children().toggleClass("overlay_img");
      });
    }
  };
})(jQuery, Drupal, drupalSettings);
