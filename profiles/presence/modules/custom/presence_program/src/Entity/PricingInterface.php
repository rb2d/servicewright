<?php

namespace Drupal\presence_program\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Pricing entities.
 *
 * @ingroup presence_program
 */
interface PricingInterface extends ContentEntityInterface, EntityChangedInterface, EntityOwnerInterface {

  // Add get/set methods for your configuration properties here.

  /**
   * Gets the Pricing name.
   *
   * @return string
   *   Name of the Pricing.
   */
  public function getName();

  /**
   * Sets the Pricing name.
   *
   * @param string $name
   *   The Pricing name.
   *
   * @return \Drupal\presence_program\Entity\PricingInterface
   *   The called Pricing entity.
   */
  public function setName($name);

  /**
   * Gets the Pricing creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Pricing.
   */
  public function getCreatedTime();

  /**
   * Sets the Pricing creation timestamp.
   *
   * @param int $timestamp
   *   The Pricing creation timestamp.
   *
   * @return \Drupal\presence_program\Entity\PricingInterface
   *   The called Pricing entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the Pricing published status indicator.
   *
   * Unpublished Pricing are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the Pricing is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a Pricing.
   *
   * @param bool $published
   *   TRUE to set this Pricing to published, FALSE to set it to unpublished.
   *
   * @return \Drupal\presence_program\Entity\PricingInterface
   *   The called Pricing entity.
   */
  public function setPublished($published);

}
