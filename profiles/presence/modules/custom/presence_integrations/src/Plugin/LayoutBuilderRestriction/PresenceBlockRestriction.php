<?php

namespace Drupal\presence_integrations\Plugin\LayoutBuilderRestriction;

use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\Core\Database\Connection;
use Drupal\layout_builder_restrictions\Plugin\LayoutBuilderRestrictionBase;
use Drupal\layout_builder_restrictions\Traits\PluginHelperTrait;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * PresenceBlockRestriction Plugin.
 *
 * @LayoutBuilderRestriction(
 *   id = "presence_block_restriction",
 *   title = @Translation("Restrict blocks as per site settings")
 * )
 */
class PresenceBlockRestriction extends LayoutBuilderRestrictionBase {

  use PluginHelperTrait;

  /**
   * Module handler service.
   *
   * @var \Drupal\Core\Extension\ModuleHandlerInterface
   */
  protected $moduleHandler;

  /**
   * Database connection service.
   *
   * @var Drupal\Core\Database\Connection
   */
  protected $database;

  /**
   * Constructs a Drupal\Component\Plugin\PluginBase object.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin_id for the plugin instance.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\Core\Extension\ModuleHandlerInterface $module_handler
   *   The module handler.
   * @param Drupal\Core\Database\Connection $connection
   *   The database connection.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, ModuleHandlerInterface $module_handler, Connection $connection) {
    $this->configuration = $configuration;
    $this->pluginId = $plugin_id;
    $this->pluginDefinition = $plugin_definition;
    $this->moduleHandler = $module_handler;
    $this->database = $connection;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('module_handler'),
      $container->get('database')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function alterBlockDefinitions(array $definitions, array $context) {
    // Respect restrictions on allowed blocks specified by the section storage.
    $site_settings = \Drupal::service('site_settings.loader');

    $integrations = [
      'field_enable_activecamp' => 'activecampaign_form',
      'field_enable_acuity_scheduling' => 'acuity_scheduler',
      'field_enable_apppalestre_cal' => 'app_palestre',
      'field_enable_infusionsoft_forms' => 'ext_is_form_block',
      'field_enable_mindbody_cal' => 'mindbody_calendar',
      'field_enable_ontraport' => 'ext_ontraport_form',
      'field_enable_triib_calendar' => 'triib_calendar',
      'field_enable_uplaunch' => 'ext_uplaunch_form',
    ];

    foreach ($integrations as $integration => $block_type) {
      $enable_block = $site_settings->loadByFieldset('integrations')['integrations'][$integration];
      if (empty($enable_block) && $enable_block != 1) {
        unset($definitions['inline_block:' . $block_type]);
      }
    }
    return $definitions;
  }

}
