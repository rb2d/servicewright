<?php

namespace Drupal\presence_program\Plugin\Field\FieldFormatter;

use Drupal\Component\Utility\Html;
use Drupal\Core\Field\FieldItemInterface;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin implementation of the 'interval_field_formatter' formatter.
 *
 * @FieldFormatter(
 *   id = "interval_field_formatter",
 *   label = @Translation("Interval field formatter"),
 *   field_types = {
 *     "list_string"
 *   }
 * )
 */
class IntervalFieldFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return [
      // Implement default settings.
    ] + parent::defaultSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    return [
      // Implement settings form.
    ] + parent::settingsForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $summary = [];
    // Implement settings summary.
    return $summary;
  }

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = [];
    $count = $items->getEntity()->get('field_terms_count')->value;
    $days = [
      'Days' => t('Day'),
      'Weeks' => t('Week'),
      'Months' => t('Month'),
      'Years' => t('Year'),
    ];
    foreach ($items as $delta => $item) {
      if ($count == 1) {
        $elements[$delta] = ['#markup' => $days[$this->viewValue($item)]];
      }
      else {
        $elements[$delta] = ['#markup' => $this->viewValue($item)];
      }
    }

    return $elements;
  }

  /**
   * Generate the output appropriate for one field item.
   *
   * @param \Drupal\Core\Field\FieldItemInterface $item
   *   One field item.
   *
   * @return string
   *   The textual output generated.
   */
  protected function viewValue(FieldItemInterface $item) {
    // The text value has no text format assigned to it, so the user input
    // should equal the output, including newlines.
    return nl2br(Html::escape($item->value));
  }

}
