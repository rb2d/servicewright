<?php

namespace Drupal\presence_color;

/**
 * Class RemoveAssests.
 */
class RemoveAssests {

  /**
   * Function to RemoveAssests.
   */
  public function delete() {
    file_unmanaged_delete_recursive('public://scss_compiler/');
    file_unmanaged_delete_recursive('public://theme-assets/');

    drupal_flush_all_caches();
  }
}
