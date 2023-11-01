<?php

namespace Drupal\presence_program\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Program schedule entities.
 *
 * @ingroup presence_program
 */
interface ProgramScheduleInterface extends ContentEntityInterface, EntityChangedInterface, EntityOwnerInterface {

  // Add get/set methods for your configuration properties here.

  /**
   * Gets the Program schedule name.
   *
   * @return string
   *   Name of the Program schedule.
   */
  public function getName();

  /**
   * Sets the Program schedule name.
   *
   * @param string $name
   *   The Program schedule name.
   *
   * @return \Drupal\presence_program\Entity\ProgramScheduleInterface
   *   The called Program schedule entity.
   */
  public function setName($name);

  /**
   * Gets the Program schedule creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Program schedule.
   */
  public function getCreatedTime();

  /**
   * Sets the Program schedule creation timestamp.
   *
   * @param int $timestamp
   *   The Program schedule creation timestamp.
   *
   * @return \Drupal\presence_program\Entity\ProgramScheduleInterface
   *   The called Program schedule entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the Program schedule published status indicator.
   *
   * Unpublished Program schedule are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the Program schedule is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a Program schedule.
   *
   * @param bool $published
   *   TRUE to set this Program schedule to published, FALSE to unpublished.
   *
   * @return \Drupal\presence_program\Entity\ProgramScheduleInterface
   *   The called Program schedule entity.
   */
  public function setPublished($published);

}
