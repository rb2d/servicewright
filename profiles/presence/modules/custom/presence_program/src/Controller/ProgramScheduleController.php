<?php

namespace Drupal\presence_program\Controller;

use Drupal\Component\Utility\Xss;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Url;
use Drupal\presence_program\Entity\ProgramScheduleInterface;

/**
 * Class ProgramScheduleController.
 *
 *  Returns responses for Program schedule routes.
 */
class ProgramScheduleController extends ControllerBase implements ContainerInjectionInterface {

  /**
   * Displays a Program schedule  revision.
   *
   * @param int $program_schedule_revision
   *   The Program schedule  revision ID.
   *
   * @return array
   *   An array suitable for drupal_render().
   */
  public function revisionShow($program_schedule_revision) {
    $program_schedule = $this->entityManager()->getStorage('program_schedule')->loadRevision($program_schedule_revision);
    $view_builder = $this->entityManager()->getViewBuilder('program_schedule');

    return $view_builder->view($program_schedule);
  }

  /**
   * Page title callback for a Program schedule  revision.
   *
   * @param int $program_schedule_revision
   *   The Program schedule  revision ID.
   *
   * @return string
   *   The page title.
   */
  public function revisionPageTitle($program_schedule_revision) {
    $program_schedule = $this->entityManager()->getStorage('program_schedule')->loadRevision($program_schedule_revision);
    return $this->t('Revision of %title from %date', ['%title' => $program_schedule->label(), '%date' => format_date($program_schedule->getRevisionCreationTime())]);
  }

  /**
   * Generates an overview table of older revisions of a Program schedule .
   *
   * @param \Drupal\presence_program\Entity\ProgramScheduleInterface $program_schedule
   *   A Program schedule  object.
   *
   * @return array
   *   An array as expected by drupal_render().
   */
  public function revisionOverview(ProgramScheduleInterface $program_schedule) {
    $account = $this->currentUser();
    $langcode = $program_schedule->language()->getId();
    $langname = $program_schedule->language()->getName();
    $languages = $program_schedule->getTranslationLanguages();
    $has_translations = (count($languages) > 1);
    $program_schedule_storage = $this->entityManager()->getStorage('program_schedule');

    $build['#title'] = $has_translations ? $this->t('@langname revisions for %title', ['@langname' => $langname, '%title' => $program_schedule->label()]) : $this->t('Revisions for %title', ['%title' => $program_schedule->label()]);
    $header = [$this->t('Revision'), $this->t('Operations')];

    $revert_permission = (($account->hasPermission("revert all program schedule revisions") || $account->hasPermission('administer program schedule entities')));
    $delete_permission = (($account->hasPermission("delete all program schedule revisions") || $account->hasPermission('administer program schedule entities')));

    $rows = [];

    $vids = $program_schedule_storage->revisionIds($program_schedule);

    $latest_revision = TRUE;

    foreach (array_reverse($vids) as $vid) {
      /** @var \Drupal\presence_program\ProgramScheduleInterface $revision */
      $revision = $program_schedule_storage->loadRevision($vid);
      // Only show revisions that are affected by the language that is being
      // displayed.
      if ($revision->hasTranslation($langcode) && $revision->getTranslation($langcode)->isRevisionTranslationAffected()) {
        $username = [
          '#theme' => 'username',
          '#account' => $revision->getRevisionUser(),
        ];

        // Use revision link to link to revisions that are not active.
        $date = \Drupal::service('date.formatter')->format($revision->getRevisionCreationTime(), 'short');
        if ($vid != $program_schedule->getRevisionId()) {
          $link = $this->l($date, new Url('entity.program_schedule.revision', ['program_schedule' => $program_schedule->id(), 'program_schedule_revision' => $vid]));
        }
        else {
          $link = $program_schedule->link($date);
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
              Url::fromRoute('entity.program_schedule.translation_revert', [
                'program_schedule' => $program_schedule->id(),
                'program_schedule_revision' => $vid,
                'langcode' => $langcode,
              ]) :
              Url::fromRoute('entity.program_schedule.revision_revert', ['program_schedule' => $program_schedule->id(), 'program_schedule_revision' => $vid]),
            ];
          }

          if ($delete_permission) {
            $links['delete'] = [
              'title' => $this->t('Delete'),
              'url' => Url::fromRoute('entity.program_schedule.revision_delete', ['program_schedule' => $program_schedule->id(), 'program_schedule_revision' => $vid]),
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

    $build['program_schedule_revisions_table'] = [
      '#theme' => 'table',
      '#rows' => $rows,
      '#header' => $header,
    ];

    return $build;
  }

}
