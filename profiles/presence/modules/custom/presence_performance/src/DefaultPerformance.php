<?php

namespace Drupal\presence_performance;

use Drupal\Core\Config\FileStorage;

/**
 * Class to import fonts configured in site-settings.
 */
class DefaultPerformance {

  /**
   * Funtion to load configured font and import.
   */
  public function import() {
    self::importDefualt();
    return TRUE;
  }

  /**
   * Funtion to import a given font.
   */
  public function importDefualt() {
    $config_path = drupal_get_path('module', 'presence_performance') . '/config/default';
    $source = new FileStorage($config_path);
    $config_storage = \Drupal::service('config.storage');
    $config_storage->write('system.performance', $source->read('system.performance'));
    drupal_flush_all_caches();
  }

}
