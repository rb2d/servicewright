/**
 * @file
 */

(function ($, Drupal, drupalSettings) {

  'use strict';

  Drupal.behaviors.intercomSettings = {
    attach: function (context, settings) {

  window.intercomSettings = {
    app_id: "cfdcpr8p",
    name:  settings.intercom.name,// Full name
    email: settings.intercom.email, // Email address
    created_at: settings.intercom.created // Signup date as a Unix timestamp.
  };

    }
  };

})(jQuery, Drupal, drupalSettings);
