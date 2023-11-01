<?php

namespace Drupal\presence_social;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Link;

/**
 * Defines a class to build a listing of Social link group entities.
 *
 * @ingroup presence_social
 */
class SocialLinkGroupListBuilder extends EntityListBuilder {

  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['id'] = $this->t('Social link group ID');
    $header['name'] = $this->t('Name');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /* @var \Drupal\presence_social\Entity\SocialLinkGroup $entity */
    $row['id'] = $entity->id();
    $row['name'] = Link::createFromRoute(
      $entity->label(),
      'entity.social_link_group.edit_form',
      ['social_link_group' => $entity->id()]
    );
    return $row + parent::buildRow($entity);
  }

}
