<?php

namespace Drupal\presence_migrate\Plugin\migrate\process;

use Drupal\migrate\ProcessPluginBase;
use Drupal\migrate\MigrateExecutableInterface;
use Drupal\migrate\Row;

/**
 * Provides a 'ProcessPricing' migrate process plugin.
 *
 * @MigrateProcessPlugin(
 *  id = "process_wp_pricing"
 * )
 */
class ProcessPricing extends ProcessPluginBase {

  /**
   * {@inheritdoc}
   */
  public function transform($value, MigrateExecutableInterface $migrate_executable, Row $row, $destination_property) {
    // Plugin logic goes here.
    if (!empty($value)) {
      return 'individual';
    }
  }

}
