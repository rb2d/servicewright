<?php

namespace Drupal\presence_migrate\Plugin\migrate\process;

use Drupal\migrate\ProcessPluginBase;
use Drupal\migrate\MigrateExecutableInterface;
use Drupal\migrate\Row;

/**
 * Provides a 'ProcessWPGTC' migrate process plugin.
 *
 * @MigrateProcessPlugin(
 *  id = "process_wpgtc"
 * )
 */
class ProcessWPGTC extends ProcessPluginBase {

  /**
   * {@inheritdoc}
   */
  public function transform($value, MigrateExecutableInterface $migrate_executable, Row $row, $destination_property) {
    // Plugin logic goes here.
    preg_match('/UA-[0-9]{5,}-[0-9]{1,}/', $value, $matches);
    $tracking_id = $matches[0];
    $config = \Drupal::service('config.factory')->getEditable('google_analytics.settings');
    $config->set('account', $tracking_id);
    $config->save();
  }

}
