<?php

namespace Drupal\presence_program;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Program schedule entity.
 *
 * @see \Drupal\presence_program\Entity\ProgramSchedule.
 */
class ProgramScheduleAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\presence_program\Entity\ProgramScheduleInterface $entity */
    switch ($operation) {
      case 'view':
        if (!$entity->isPublished()) {
          return AccessResult::allowedIfHasPermission($account, 'view unpublished program schedule entities');
        }
        return AccessResult::allowedIfHasPermission($account, 'view published program schedule entities');

      case 'update':
        return AccessResult::allowedIfHasPermission($account, 'edit program schedule entities');

      case 'delete':
        return AccessResult::allowedIfHasPermission($account, 'delete program schedule entities');
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add program schedule entities');
  }

}
