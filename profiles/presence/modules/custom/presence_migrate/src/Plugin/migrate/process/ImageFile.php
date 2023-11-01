<?php

namespace Drupal\presence_migrate\Plugin\migrate\process;

use Drupal\file\Entity\File;
use Drupal\migrate\ProcessPluginBase;
use Drupal\migrate\MigrateExecutableInterface;
use Drupal\migrate\Row;
use Drupal\media\Entity\Media;

/**
 * Provides a 'ImageFile' migrate process plugin.
 *
 * @MigrateProcessPlugin(
 *  id = "image_file"
 * )
 */
class ImageFile extends ProcessPluginBase {

  /**
   * {@inheritdoc}
   */
  public function transform($value, MigrateExecutableInterface $migrate_executable, Row $row, $destination_property) {
    // Plugin logic goes here.
    if ($value != 'NULL' && !empty($value)) {
      $file = File::load($value);
      $media_image = Media::create([
        'bundle' => 'image',
        'name' => $file->getFilename(),
        'field_media_image' => [
          'target_id' => $file->id(),
        ],
      ]);
      $media_image->save();
    }
    return (isset($media_image) ? $media_image->id() : NULL);
  }

}
