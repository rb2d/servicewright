<?php

namespace Drupal\presence_program\Controller;

use Drupal\Component\Utility\Xss;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Url;
use Drupal\presence_program\Entity\PricingInterface;

/**
 * Class PricingController.
 *
 *  Returns responses for Pricing routes.
 */
class PricingController extends ControllerBase implements ContainerInjectionInterface {

  /**
   * Displays a Pricing  revision.
   *
   * @param int $pricing_revision
   *   The Pricing  revision ID.
   *
   * @return array
   *   An array suitable for drupal_render().
   */
  public function revisionShow($pricing_revision) {
    $pricing = $this->entityManager()->getStorage('pricing')->loadRevision($pricing_revision);
    $view_builder = $this->entityManager()->getViewBuilder('pricing');

    return $view_builder->view($pricing);
  }

  /**
   * Page title callback for a Pricing  revision.
   *
   * @param int $pricing_revision
   *   The Pricing  revision ID.
   *
   * @return string
   *   The page title.
   */
  public function revisionPageTitle($pricing_revision) {
    $pricing = $this->entityManager()->getStorage('pricing')->loadRevision($pricing_revision);
    return $this->t('Revision of %title from %date', ['%title' => $pricing->label(), '%date' => format_date($pricing->getRevisionCreationTime())]);
  }

  /**
   * Generates an overview table of older revisions of a Pricing .
   *
   * @param \Drupal\presence_program\Entity\PricingInterface $pricing
   *   A Pricing  object.
   *
   * @return array
   *   An array as expected by drupal_render().
   */
  public function revisionOverview(PricingInterface $pricing) {
    $account = $this->currentUser();
    $langcode = $pricing->language()->getId();
    $langname = $pricing->language()->getName();
    $languages = $pricing->getTranslationLanguages();
    $has_translations = (count($languages) > 1);
    $pricing_storage = $this->entityManager()->getStorage('pricing');

    $build['#title'] = $has_translations ? $this->t('@langname revisions for %title', ['@langname' => $langname, '%title' => $pricing->label()]) : $this->t('Revisions for %title', ['%title' => $pricing->label()]);
    $header = [$this->t('Revision'), $this->t('Operations')];

    $revert_permission = (($account->hasPermission("revert all pricing revisions") || $account->hasPermission('administer pricing entities')));
    $delete_permission = (($account->hasPermission("delete all pricing revisions") || $account->hasPermission('administer pricing entities')));

    $rows = [];

    $vids = $pricing_storage->revisionIds($pricing);

    $latest_revision = TRUE;

    foreach (array_reverse($vids) as $vid) {
      /** @var \Drupal\presence_program\PricingInterface $revision */
      $revision = $pricing_storage->loadRevision($vid);
      // Only show revisions that are affected by the language that is being
      // displayed.
      if ($revision->hasTranslation($langcode) && $revision->getTranslation($langcode)->isRevisionTranslationAffected()) {
        $username = [
          '#theme' => 'username',
          '#account' => $revision->getRevisionUser(),
        ];

        // Use revision link to link to revisions that are not active.
        $date = \Drupal::service('date.formatter')->format($revision->getRevisionCreationTime(), 'short');
        if ($vid != $pricing->getRevisionId()) {
          $link = $this->l($date, new Url('entity.pricing.revision', ['pricing' => $pricing->id(), 'pricing_revision' => $vid]));
        }
        else {
          $link = $pricing->link($date);
        }

        $row = [];
        $column = [
          'data' => [
            '#type' => 'inline_template',
            '#template' => '{% trans %}{{ date }} by {{ username }}{% endtrans %}{% if message %}<p class="revision-log">{{ message }}</p>{% endif %}',
            '#context' => [
              'date' => $link,
              'username' => \Drupal::service('renderer')->renderPlain($username),
              'message' => ['#markup' => $revision->getRevisionLogMessage(), '#allowed_tags' => Xss::getHtmlTagList()],
            ],
          ],
        ];
        $row[] = $column;

        if ($latest_revision) {
          $row[] = [
            'data' => [
              '#prefix' => '<em>',
              '#markup' => $this->t('Current revision'),
              '#suffix' => '</em>',
            ],
          ];
          foreach ($row as &$current) {
            $current['class'] = ['revision-current'];
          }
          $latest_revision = FALSE;
        }
        else {
          $links = [];
          if ($revert_permission) {
            $links['revert'] = [
              'title' => $this->t('Revert'),
              'url' => $has_translations ?
              Url::fromRoute('entity.pricing.translation_revert', [
                'pricing' => $pricing->id(),
                'pricing_revision' => $vid,
                'langcode' => $langcode,
              ]) :
              Url::fromRoute('entity.pricing.revision_revert', ['pricing' => $pricing->id(), 'pricing_revision' => $vid]),
            ];
          }

          if ($delete_permission) {
            $links['delete'] = [
              'title' => $this->t('Delete'),
              'url' => Url::fromRoute('entity.pricing.revision_delete', ['pricing' => $pricing->id(), 'pricing_revision' => $vid]),
            ];
          }

          $row[] = [
            'data' => [
              '#type' => 'operations',
              '#links' => $links,
            ],
          ];
        }

        $rows[] = $row;
      }
    }

    $build['pricing_revisions_table'] = [
      '#theme' => 'table',
      '#rows' => $rows,
      '#header' => $header,
    ];

    return $build;
  }

}
