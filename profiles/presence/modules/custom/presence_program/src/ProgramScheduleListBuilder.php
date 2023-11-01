<?php

namespace Drupal\presence_program;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Link;

/**
 * Defines a class to build a listing of Program schedule entities.
 *
 * @ingroup presence_program
 */
class ProgramScheduleListBuilder extends EntityListBuilder {

  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['id'] = $this->t('Program schedule ID');
    $header['name'] = $this->t('Name');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /* @var $entity \Drupal\presence_program\Entity\ProgramSchedule */
    $row['id'] = $entity->id();
    $row['name'] = Link::createFromRoute(
      $entity->label(),
      'entity.program_schedule.edit_form',
      ['program_schedule' => $entity->id()]
    );
    return $row + parent::buildRow($entity);
  }

}
