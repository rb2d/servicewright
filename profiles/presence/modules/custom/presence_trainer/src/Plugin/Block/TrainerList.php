<?php

namespace Drupal\presence_trainer\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\site_settings\SiteSettingsLoader;
use Drupal\views\Views;

/**
 * Provides a 'TrainerList' block.
 *
 * @Block(
 *  id = "trainer_list",
 *  admin_label = @Translation("Trainer list"),
 * )
 */
class TrainerList extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * Drupal\site_settings\SiteSettingsLoader definition.
   *
   * @var \Drupal\site_settings\SiteSettingsLoader
   */
  protected $siteSettingsLoader;

  /**
   * Constructs a new TrainerList object.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin_id for the plugin instance.
   * @param string $plugin_definition
   *   The plugin implementation definition.
   * @param Drupal\site_settings\SiteSettingsLoader $site_settings_loader
   *   To load the site settings value.
   */
  public function __construct(
    array $configuration,
    $plugin_id,
    $plugin_definition,
    SiteSettingsLoader $site_settings_loader
  ) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->siteSettingsLoader = $site_settings_loader;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('site_settings.loader')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $build = [];
    $displayType = $this->siteSettingsLoader->loadByFieldset('view_type')['trainers_view_mode'];
    $display = 'block_3';
    if ($displayType == 'grid') {
      $display = 'block_2';
    }
    $view = Views::getView('trainers');
    if (is_object($view)) {
      $view->setDisplay($display);
      $view->preExecute();
      $view->execute();
      $content = $view->render();
      $build[] = $content;
    }
    $build['#cache'] = ['tags' => ['block:trainer_list']];
    return $build;
  }

}
