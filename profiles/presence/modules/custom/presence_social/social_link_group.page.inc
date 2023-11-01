<?php

/**
 * @file
 * Contains social_link_group.page.inc.
 *
 * Page callback for Social link group entities.
 */

use Drupal\Core\Render\Element;

/**
 * Prepares variables for Social link group templates.
 *
 * Default template: social_link_group.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_social_link_group(array &$variables) {
  // Fetch SocialLinkGroup Entity Object.
  $social_link_group = $variables['elements']['#social_link_group'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
