<?php

namespace Drupal\presence_migrate\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class WPExportUploadForm.
 */
class WPExportUploadForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'wp_export_upload';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['upload_config_file'] = [
      '#type' => 'managed_file',
      '#title' => $this->t('Upload Exported WP Config file'),
      '#upload_location' => 'private://exports/',
      '#upload_validators' => [
        'file_validate_extensions' => ['json'],
      ],
    ];
    $form['upload_xml_file'] = [
      '#type' => 'managed_file',
      '#title' => $this->t('Upload Exported WP XML file'),
      '#upload_location' => 'private://exports/',
      '#upload_validators' => [
        'file_validate_extensions' => ['xml'],
      ],
    ];
    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
    ];
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Display result.
    if (!empty($form_state->getValue('upload_xml_file'))) {
      $xml_file = \Drupal::entityTypeManager()->getStorage('file')
        ->load($form_state->getValue('upload_xml_file')[0]);
      $xml_data = file_get_contents($xml_file->getFileUri());
      $xml = simplexml_load_string($xml_data, "SimpleXMLElement", LIBXML_NOCDATA);
      $json = json_encode($xml);
      $array = json_decode($json, TRUE);
      $domain = $array['channel']['link'];
      $file_image = file_save_data($xml_data, 'private://exports/Blogs-Gym.xml', FILE_EXISTS_REPLACE);

      $config_factory = \Drupal::configFactory();
      $config_factory->getEditable('migrate_plus.migration.mwp_gymwright_theme_assets')->set('source.constants.site_url', $domain . '/wp-content/themes/crossfit/images')->save();
    }

    if (!empty($form_state->getValue('upload_config_file'))) {
      $file = \Drupal::entityTypeManager()->getStorage('file')
        ->load($form_state->getValue('upload_config_file')[0]);
      $json_data = file_get_contents($file->getFileUri());
      $json_data = json_decode($json_data, TRUE);
      $json_data['domain'] = $domain;
      $json_data = json_encode(['data' => [$json_data]]);
      $file_image = file_save_data($json_data, 'private://exports/wp_config_export.json', FILE_EXISTS_REPLACE);
    }

  }

}
