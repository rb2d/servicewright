<?php

namespace Drupal\presence_social\Entity;

use Drupal\views\EntityViewsData;

/**
 * Provides Views data for Social link group entities.
 */
class SocialLinkGroupViewsData extends EntityViewsData {

  /**
   * {@inheritdoc}
   */
  public function getViewsData() {
    $data = parent::getViewsData();

    // Additional information for Views integration, such as table joins, can be
    // put here.
    return $data;
  }

}
