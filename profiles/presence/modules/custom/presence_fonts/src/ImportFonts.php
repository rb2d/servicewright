<?php

namespace Drupal\presence_fonts;

use Drupal\Core\Config\FileStorage;
use Drupal\fontyourface\Entity\FontDisplay;

/**
 * Class to import fonts configured in site-settings.
 */
class ImportFonts {

  /**
   * Funtion to load configured font and import.
   */
  public function import() {
    $site_settings = \Drupal::service('site_settings.loader');
    $font = $site_settings->loadByFieldset('font_pairing')['font_pairing'];
    if (isset($font)) {
      self::importFont($font);
    }
    return $font;
  }

  /**
   * Funtion to import a given font.
   */
  public function importFont($font) {
    $config_path = drupal_get_path('module', 'presence_fonts') . '/config/fonts/' . $font;
    $source = new FileStorage($config_path);
    $config_storage = \Drupal::service('config.storage');
    $configs = [
      'fontyourface.font_display.body',
      'fontyourface.font_display.headers',
      'fontyourface.settings',
    ];
    foreach ($configs as $config) {
      $config_storage->write($config, $source->read($config));
    }
    $font_display_body = FontDisplay::load('body');
    $font_display_header = FontDisplay::load('headers');
    fontyourface_save_and_generate_font_display_css($font_display_body);
    fontyourface_save_and_generate_font_display_css($font_display_header);
    drupal_flush_all_caches();
  }

}
