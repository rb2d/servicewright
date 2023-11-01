<?php

/**
 * @file
 * Install, update and uninstall functions for presence_admin_toolbar.
 */

/**
 * Update presence_admin_toolbar.settings to include avoid_custom_font.
 */
function presence_admin_toolbar_post_update_avoid_custom_font() {
  $config = \Drupal::configFactory()->getEditable('presence_admin_toolbar.settings');
  $config->set('avoid_custom_font', FALSE);
  $config->save(TRUE);
}
