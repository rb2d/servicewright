<?php

namespace Drupal\presence_migrate\Plugin\migrate\process;

use Drupal\migrate\ProcessPluginBase;
use Drupal\migrate\MigrateExecutableInterface;
use Drupal\migrate\Row;

/**
 * Provides a 'ProcessWPLink' migrate process plugin.
 *
 * @MigrateProcessPlugin(
 *  id = "process_wplink"
 * )
 */
class ProcessWPLink extends ProcessPluginBase {

  /**
   * {@inheritdoc}
   */
  public function transform($value, MigrateExecutableInterface $migrate_executable, Row $row, $destination_property) {
    // Plugin logic goes here.
    $url = parse_url($value);
    $url['query'] = isset($url['query']) ? '?' . $url['query'] : '';
    $url = '/blog' . $url['path'] . $url['query'];
    if (substr($url, -1) == '/') {
      $url = rtrim($url, '/');
    }
    return $url;
  }

}
