<?php

/**
 * @file
 * Contains pricing.page.inc.
 *
 * Page callback for Pricing entities.
 */

use Drupal\Core\Render\Element;

/**
 * Prepares variables for Pricing templates.
 *
 * Default template: pricing.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_pricing(array &$variables) {
  // Fetch Pricing Entity Object.
  $pricing = $variables['elements']['#pricing'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
