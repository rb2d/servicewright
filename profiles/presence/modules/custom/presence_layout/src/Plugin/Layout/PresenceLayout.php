<?php

namespace Drupal\presence_layout\Plugin\Layout;

use Drupal\Core\Form\FormStateInterface;
use Drupal\xy_grid_layouts\Plugin\Layout\XyGridLayouts;

/**
 * Layout class for custom SWP layouts.
 */
class PresenceLayout extends XyGridLayouts {

  /**
   * Override XyGridLayouts configurations.
   */
  public function buildConfigurationForm(array $form, FormStateInterface $form_state) {
    $configuration = $this->getConfiguration();
    $options = [
      'medium-offset-4 medium-4' => $this->t('small'),
      'medium-offset-3 medium-6' => $this->t('medium'),
      'medium-offset-2 medium-8' => $this->t('large'),
    ];
    $form['padding'] = [
      '#type' => 'select',
      '#title' => $this->t('Padding'),
      '#default_value' => isset($configuration['padding']) ? $configuration['padding'] : '',
      '#options' => $options,
    ];
    return $form + parent::buildConfigurationForm($form, $form_state);
  }

  /**
   * Submit handler for custom form elements.
   */
  public function submitConfigurationForm(array &$form, FormStateInterface $form_state) {
    parent::submitConfigurationForm($form, $form_state);
    $this->configuration['padding'] = $form_state->getValue('padding');
  }

}
