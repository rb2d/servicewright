<?php

/**
 * @file
 * Enables modules and site configuration for a presence site installation.
 */

use Drupal\Core\Form\FormStateInterface;

/**
 * Implements hook_form_FORM_ID_alter() for install_configure_form().
 *
 * Allows the profile to alter the site configuration form.
 */
function presence_form_install_configure_form_alter(&$form, FormStateInterface $form_state) {
  $form['#submit'][] = 'presence_form_install_configure_submit';
}

/**
 * Submission handler to sync the contact.form.feedback recipient.
 */
function presence_form_install_configure_submit($form, FormStateInterface $form_state) {
  $site_mail = $form_state->getValue('site_mail');
  // ContactForm::load('feedback')->setRecipients([$site_mail])->trustData()->save();
}

/**
 * Implements hook_install_tasks().
 */
function presence_install_tasks(&$install_state) {
  $tasks = [
    'presence_post_install_task' => [
      'display_name' => t('Post installation tasks.'),
      'display' => TRUE,
    ],
  ];
  return $tasks;
}

/**
 * Performs final installation steps and displays a 'finished' page.
 *
 * @param array $install_state
 *   An array of information about the current installation state.
 *
 * @see install_finished()
 */
function presence_post_install_task(array &$install_state) {
  \Drupal::service('module_installer')->install(['presence_demo_content']);
  \Drupal::service('module_installer')->uninstall(['update']);
}
