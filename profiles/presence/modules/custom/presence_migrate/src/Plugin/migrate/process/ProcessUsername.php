<?php

namespace Drupal\presence_migrate\Plugin\migrate\process;

use Drupal\migrate\ProcessPluginBase;
use Drupal\migrate\MigrateExecutableInterface;
use Drupal\migrate\Row;

/**
 * Perform custom value transformations.
 *
 * @MigrateProcessPlugin(
 *   id = "process_wp_username"
 * )
 *
 * To do custom value transformations use the following:
 *
 * @code
 * field_text:
 *   plugin: process_wp_username
 *   source: text
 * @endcode
 */
class ProcessUsername extends ProcessPluginBase {

  /**
   * {@inheritdoc}
   */
  public function transform($value, MigrateExecutableInterface $migrate_executable, Row $row, $destination_property) {
    // To replace email id.
    $username_array = [
      "gwadmin",
      "bbl site manager",
      "guw-whitelabel",
      "guw-cftemp",
      "alaphzz",
      "wordpress@gymwright.com",
    ];
    if (in_array(strtolower($value), $username_array)) {
      $value = "sitemanager";
    }
    return $value;
  }

}
