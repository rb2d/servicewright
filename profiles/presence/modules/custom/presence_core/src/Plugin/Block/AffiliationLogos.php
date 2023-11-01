<?php

namespace Drupal\presence_core\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'AffiliationLogos' block.
 *
 * @Block(
 *  id = "affiliation_logos",
 *  admin_label = @Translation("Affiliation logos"),
 * )
 */
class AffiliationLogos extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $build = [];
    $ids = \Drupal::entityQuery('site_setting_entity')->condition('type', 'affiliation_logos')->execute();
    $id = key($ids);
    $entity_type = 'site_setting_entity';
    $view_mode = 'full';
    if (!empty($id)) {
      $view_builder = \Drupal::entityTypeManager()->getViewBuilder($entity_type);
      $storage = \Drupal::entityManager()->getStorage($entity_type);
      $node = $storage->load($id);
      $build = $view_builder->view($node, $view_mode);
    }
    $build['#cache'] = ['tags' => ['block:affiliation_logos_global']];
    return $build;
  }

}
