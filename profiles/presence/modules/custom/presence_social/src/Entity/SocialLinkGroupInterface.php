<?php

namespace Drupal\presence_social\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\Core\Entity\EntityPublishedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Social link group entities.
 *
 * @ingroup presence_social
 */
interface SocialLinkGroupInterface extends ContentEntityInterface, EntityChangedInterface, EntityPublishedInterface, EntityOwnerInterface {

  /**
   * Add get/set methods for your configuration properties here.
   */

  /**
   * Gets the Social link group name.
   *
   * @return string
   *   Name of the Social link group.
   */
  public function getName();

  /**
   * Sets the Social link group name.
   *
   * @param string $name
   *   The Social link group name.
   *
   * @return \Drupal\presence_social\Entity\SocialLinkGroupInterface
   *   The called Social link group entity.
   */
  public function setName($name);

  /**
   * Gets the Social link group creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Social link group.
   */
  public function getCreatedTime();

  /**
   * Sets the Social link group creation timestamp.
   *
   * @param int $timestamp
   *   The Social link group creation timestamp.
   *
   * @return \Drupal\presence_social\Entity\SocialLinkGroupInterface
   *   The called Social link group entity.
   */
  public function setCreatedTime($timestamp);

}
