<?php

namespace Drupal\presence_migrate\Plugin\migrate\process;

use Drupal\migrate\ProcessPluginBase;
use Drupal\migrate\MigrateExecutableInterface;
use Drupal\migrate\MigrateSkipProcessException;
use Drupal\migrate\Row;
use Drupal\taxonomy\Entity\Term;

/**
 * Check if term exists and create new if doesn't.
 *
 * @MigrateProcessPlugin(
 *   id = "existing_term"
 * )
 */
class ExistingTerm extends ProcessPluginBase {

  /**
   * {@inheritdoc}
   */
  public function transform($term_name, MigrateExecutableInterface $migrate_executable, Row $row, $destination_property) {
    $vocabulary = $this->configuration['vocabulary'];
    $entity_type = $this->configuration['entity_type'];
    if (empty($term_name)) {
      throw new MigrateSkipProcessException();
    }

    if ($tid = $this->getTidByName($term_name, $vocabulary)) {
      $term = Term::load($tid);
    }
    elseif ($entity_type == 'node') {
      $term = Term::create([
        'name' => $term_name,
        'vid'  => $vocabulary,
      ])->save();
      if ($tid = $this->getTidByName($term_name, $vocabulary)) {
        $term = Term::load($tid);
      }
    }
    if ($entity_type == 'node') {
      return [
        'target_id' => is_object($term) ? $term->id() : 0,
      ];
    }
    elseif ($entity_type == 'taxonomy') {
      return is_object($term) ? 0 : $term_name;
    }
    return 0;
  }

  /**
   * Load term by name.
   */
  protected function getTidByName($name = NULL, $vocabulary = NULL) {
    $properties = [];
    if (!empty($name)) {
      $properties['name'] = $name;
    }
    if (!empty($vocabulary)) {
      $properties['vid'] = $vocabulary;
    }
    $terms = \Drupal::entityManager()->getStorage('taxonomy_term')->loadByProperties($properties);
    $term = reset($terms);
    return !empty($term) ? $term->id() : 0;
  }

}
