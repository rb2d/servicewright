/**
 * @file
 */

(function ($, Drupal, drupalSettings) {

  'use strict';

  Drupal.behaviors.getProvider = {
    attach: function (context, settings) {
        var providers_2d = [
          ['instagram', 'insta.me'],
          ['facebook', 'fb.com'],
          ['twitter'],
          ['youtube', 'youtu.be'],
        ];
        jQuery('[id^="field-social-links-values"] .field--name-field-social-url input[type=url]').change(function (event) {
            var url = jQuery(this).val();
            for (var i = 0; i < providers_2d.length; i++) {
              var providers = providers_2d[i];
              providers.forEach(function (provider) {
                if (url.includes(provider)) {
                    $(event.currentTarget).closest("tr td").find('input[type=radio][value=' + providers[0] + ']').prop("checked",true);
                }
              });
            }
        });
    }
  };

})(jQuery, Drupal, drupalSettings);
