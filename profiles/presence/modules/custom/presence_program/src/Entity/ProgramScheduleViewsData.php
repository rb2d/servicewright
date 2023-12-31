<?php

namespace Drupal\presence_program\Entity;

use Drupal\views\EntityViewsData;

/**
 * Provides Views data for Program schedule entities.
 */
class ProgramScheduleViewsData extends EntityViewsData {

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
