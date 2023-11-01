<?php

namespace Drupal\presence_color;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\File\FileSystemInterface;

/**
 * Class PresenceColorCompileController.
 */
class PresenceColorCompiler extends ControllerBase
{

    /**
     * Function to compile colors.
     */
    public function compile($site_settings)
    {
        // Paths.
        $scss_path = 'public://theme-assets/scss/';
        $theme_directory = drupal_get_path('theme', 'limber') . '/scss/';

        // Delete files in public://theme-assets/scss/ to assure a clean scss build.
        \Drupal::service('file_system')->deleteRecursive($scss_path);

        // Prepare scss_path in the instance the folder is removed.
        \Drupal::service('file_system')->prepareDirectory($scss_path, FileSystemInterface::CREATE_DIRECTORY);

        // Copy limber scss files first (we are overwriting _basecolor.scss next).
        // @todo extend file_system service with recurse_copy function.
        recurse_copy($theme_directory, $scss_path);

        // Include scss_data for compilation.
        include_once __DIR__ . '/../includes/scss_data.inc';

        // Prepare SCSS directory.
        \Drupal::service("file_system")->prepareDirectory($scss_path, FileSystemInterface::CREATE_DIRECTORY);

        // Replace the existing _basecolor.scss file in the cloned files.
        file_put_contents($scss_path . '_basecolor.scss', $scss_data);

        // Rename limber.scss to limber-generated.scss.
        rename(($scss_path . 'limber.scss'), ($scss_path . 'limber-generated.scss'));

        // Compile SCSS.
        \Drupal::service('scss_compiler')->compileAll(TRUE, TRUE);

        // CLEAR Caches.
        // Flush asset file caches.
        // \Drupal::service('asset.css.collection_optimizer')->deleteAll();
        // \Drupal::service('asset.js.collection_optimizer')->deleteAll();
        // _drupal_flush_css_js();
        drupal_flush_all_caches(); // @TODO replace this with a contextual cache clear only. 

        // MESSAGE stuff
        \Drupal::service('messenger')->addStatus(t(' Your theme has been updated.'));


    }

}
