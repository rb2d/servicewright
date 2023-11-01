<?php

namespace Drupal\presence_program;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Pricing entity.
 *
 * @see \Drupal\presence_program\Entity\Pricing.
 */
class PricingAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\presence_program\Entity\PricingInterface $entity */
    switch ($operation) {
      case 'view':
        if (!$entity->isPublished()) {
          return AccessResult::allowedIfHasPermission($account, 'view unpublished pricing entities');
        }
        return AccessResult::allowedIfHasPermission($account, 'view published pricing entities');

      case 'update':
        return AccessResult::allowedIfHasPermission($account, 'edit pricing entities');

      case 'delete':
        return AccessResult::allowedIfHasPermission($account, 'delete pricing entities');
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add pricing entities');
  }

}
