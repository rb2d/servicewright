<?php

/**
 * @file
 * Contains program_schedule.page.inc.
 *
 * Page callback for Program schedule entities.
 */

use Drupal\Core\Render\Element;

/**
 * Prepares variables for Program schedule templates.
 *
 * Default template: program_schedule.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_program_schedule(array &$variables) {
  // Fetch ProgramSchedule Entity Object.
  $program_schedule = $variables['elements']['#program_schedule'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
