<?php

namespace Drupal\presence_menu\Plugin\ConfigIgnore;

use Drupal\Core\Plugin\PluginBase;
use Drupal\config_ignore_keys\Plugin\ConfigurationIgnorePluginInterface;

/**
 * Class FooterMenuLabelIgnore.
 *
 * @ConfigurationIgnorePlugin(
 *   id = "contact_form_ignore",
 *   description = "Ignoring the receipients of the contact form configuration",
 * )
 */
class FooterMenuLabelIgnore extends PluginBase implements ConfigurationIgnorePluginInterface {

  /**
   * {@inheritdoc}
   */
  public function getConfigurations() {
    return [
      'contact.form.contact_form' => [
        'recipients',
      ],
    ];
  }

}
