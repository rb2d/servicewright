<?php

namespace Drupal\presence_migrate\Plugin\migrate\process;

use Drupal\migrate\ProcessPluginBase;
use Drupal\migrate\MigrateExecutableInterface;
use Drupal\migrate\Row;

/**
 * Perform custom value transformations.
 *
 * @MigrateProcessPlugin(
 *   id = "wp_files_attachments"
 * )
 *
 * To do custom value transformations use the following:
 *
 * @code
 * field_text:
 *   plugin: wp_files_attachments
 *   source: text
 * @endcode
 */
class ProcessAttachments extends ProcessPluginBase {

  /**
   * {@inheritdoc}
   */
  public function transform($value, MigrateExecutableInterface $migrate_executable, Row $row, $destination_property) {
    // To replace email id.
    $check = ['jpg', 'jpeg', 'png', 'gif', 'pdf', 'wav', 'mp3', 'mp4'];
    $extension = end(explode(".", $value));
    if (in_array($extension, $check)) {
      return $value;
    }
  }

}
