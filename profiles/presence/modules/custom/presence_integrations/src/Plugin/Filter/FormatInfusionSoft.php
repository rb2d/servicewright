<?php

namespace Drupal\presence_integrations\Plugin\Filter;

use Drupal\filter\FilterProcessResult;
use Drupal\filter\Plugin\FilterBase;
use Drupal\Component\Utility\Html;

/**
 * Provides a filter to restrict images to site.
 *
 * @Filter(
 *   id = "ext_fmt_infusionsoft",
 *   title = @Translation("Format InfusionSoft Buttons"),
 *   description = @Translation("Format InfusionSoft Buttons."),
 *   type = Drupal\filter\Plugin\FilterInterface::TYPE_TRANSFORM_IRREVERSIBLE,
 *   weight = 20
 * )
 */
class FormatInfusionSoft extends FilterBase {

  /**
   * {@inheritdoc}
   */
  public function process($text, $langcode) {

    $html_dom = Html::load($text);
    foreach ($html_dom->getElementsByTagName('button') as $tag) {
      $tag->setAttribute('class', ($tag->hasAttribute('class') ? $tag->getAttribute('class') . ' ' : '') . 'button primary');
    }
    $text = Html::serialize($html_dom);

    return new FilterProcessResult($text);
  }

  /**
   * {@inheritdoc}
   */
  public function tips($long = FALSE) {
    return $this->t('InfusionSoft "un-styled" form code requires refactor for display mode.');
  }

}
