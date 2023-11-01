<?php
/**
 * @file
 * Defines scss_data to be written in files.
 *
 * @see \Drupal\presence_color\PresenceColorCompiler
 */

// Generated _basecolor.scss data.
$scss_data = '
// Managed Color Variables (MCV) - Generated ' . date("D M j G:i:s T Y") . '
$primary: ' . $site_settings['field_color_primary']['color'] . ';
$secondary: ' . $site_settings['field_color_secondary']['color'] . ';
$tertiary: ' . $site_settings['field_color_tertiary']['color'] . ';
$black: ' . $site_settings['field_color_black']['color'] . ';
$white: ' . $site_settings['field_color_white']['color'] . ';

// Limber added classes.
.primary-color{
  color: $primary;
}
.secondary-color{
  color: $secondary;
}
.tertiary-color{
  color: $tertiary;
}

.white-color{
  color: $white;
}
.black-color{
  color: $black;
}
';