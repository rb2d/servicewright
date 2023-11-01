<?php

namespace Drupal\presence_migrate\Plugin\migrate\process;

use Drupal\migrate\ProcessPluginBase;
use Drupal\migrate\MigrateExecutableInterface;
use Drupal\migrate\Row;

/**
 * Provides a 'MigrateMediaItem' migrate process plugin.
 *
 * @MigrateProcessPlugin(
 *  id = "migrate_media_item"
 * )
 */
class MigrateMediaItem extends ProcessPluginBase {

  /**
   * {@inheritdoc}
   */
  public function transform($value, MigrateExecutableInterface $migrate_executable, Row $row, $destination_property) {
    // Plugin logic goes here.
    $image_data = file_get_contents($value);
    $directory = 'public://wp-theme-images/';
    file_prepare_directory($directory, FILE_CREATE_DIRECTORY);
    $file_image = file_save_data($image_data, $directory . str_replace(" ", "_", basename($value)), FILE_EXISTS_REPLACE);

    return (isset($file_image) ? $file_image->id() : NULL);
  }

}
