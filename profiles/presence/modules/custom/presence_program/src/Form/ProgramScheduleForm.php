<?php

namespace Drupal\presence_program\Form;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Form controller for Program schedule edit forms.
 *
 * @ingroup presence_program
 */
class ProgramScheduleForm extends ContentEntityForm {

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    /* @var $entity \Drupal\presence_program\Entity\ProgramSchedule */
    $form = parent::buildForm($form, $form_state);

    $entity = $this->entity;

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $entity = $this->entity;

    $status = parent::save($form, $form_state);

    switch ($status) {
      case SAVED_NEW:
        drupal_set_message($this->t('Created the %label Program schedule.', [
          '%label' => $entity->label(),
        ]));
        break;

      default:
        drupal_set_message($this->t('Saved the %label Program schedule.', [
          '%label' => $entity->label(),
        ]));
    }
    $form_state->setRedirect('entity.program_schedule.canonical', ['program_schedule' => $entity->id()]);
  }

}
