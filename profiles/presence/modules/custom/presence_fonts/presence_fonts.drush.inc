<?php

/**
 * @file
 * Contains the code to generate the custom drush commands.
 */

use Drupal\presence_fonts\ImportFonts;

/**
 * Implements hook_drush_command().
 */
function presence_fonts_drush_command() {
  $items = [];
  $items['import-presence-fonts'] = [
    'description' => 'Import the fonts configured in site settings',
    'drupal dependencies' => ['presence_fonts'],
    'aliases' => ['ipf'],
  ];
  return $items;
}

/**
 * Call back function drush_presence_fonts_import_presence_fonts()
 */
function drush_presence_fonts_import_presence_fonts() {
  $font = ImportFonts::import();
  drush_print("The font " . $font . " has been imported.");
}
