<?php

namespace Drupal\presence_sitebuilder\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'HeaderCtaButtons' block.
 *
 * @Block(
 *  id = "header_cta_buttons",
 *  admin_label = @Translation("Header cta buttons"),
 * )
 */
class HeaderCtaButtons extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $build = [];
    $nids = \Drupal::entityQuery('site_setting_entity')->condition('type', 'call_to_actions')->execute();
    $nid = key($nids);
    $entity_type = 'site_setting_entity';
    $view_mode = 'full';
    if (!empty($nid)) {
      $view_builder = \Drupal::entityTypeManager()->getViewBuilder($entity_type);
      $storage = \Drupal::entityManager()->getStorage($entity_type);
      $node = $storage->load($nid);
      $build = $view_builder->view($node, $view_mode);
    }
    $build['#cache'] = ['tags' => ['block:cta_global']];
    return $build;
  }

}
