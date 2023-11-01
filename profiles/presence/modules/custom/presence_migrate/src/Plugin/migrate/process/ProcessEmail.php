<?php

namespace Drupal\presence_migrate\Plugin\migrate\process;

use Drupal\migrate\ProcessPluginBase;
use Drupal\migrate\MigrateExecutableInterface;
use Drupal\migrate\Row;

/**
 * Perform custom value transformations.
 *
 * @MigrateProcessPlugin(
 *   id = "process_wpemail"
 * )
 *
 * To do custom value transformations use the following:
 *
 * @code
 * field_text:
 *   plugin: process_wpemail
 *   source: text
 * @endcode
 */
class ProcessEmail extends ProcessPluginBase {

  /**
   * {@inheritdoc}
   */
  public function transform($value, MigrateExecutableInterface $migrate_executable, Row $row, $destination_property) {
    // To replace email id.
    $email = explode("@", $value);
    $replace = explode(".", $email[1]);
    if ($replace[0] == "getuwired" || $replace[0] == "gymwright") {
      $value = "sitemanager@sitewright.io";
    }
    return $value;
  }

}
