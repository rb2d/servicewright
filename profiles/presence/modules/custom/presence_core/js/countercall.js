(function($) {

  "use strict";

  $("#edit-field-primary-cta-0-title").maxlength({
    counterContainer: $(".form-item-field-primary-cta-0-title"),
    text: 'Character left <b>%left</b>'
  });
  $("#edit-field-secondary-cta-0-title").maxlength({
    counterContainer: $(".form-item-field-secondary-cta-0-title"),
    text: 'Character left <b>%left</b>'
  });
  $("#edit-field-site-name-0-value").maxlength({
    counterContainer: $(".form-item-field-site-name-0-value"),
    text: 'Character left <b>%left</b>'
  });

  $("[id^='edit-settings-block-form-field-hero-tagline-0-value']").maxlength({
    counterContainer: $(".field--name-field-hero-tagline"),
    text: 'Character left <b>%left</b>'
  });

  $("#edit-field-tag-line-0-value").maxlength({
    counterContainer: $(".field--name-field-tag-line"),
    text: 'Character left <b>%left</b>'
  });

}(jQuery));
