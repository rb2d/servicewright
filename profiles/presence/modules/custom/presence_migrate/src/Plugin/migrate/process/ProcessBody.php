<?php

namespace Drupal\presence_migrate\Plugin\migrate\process;

use Drupal\migrate\ProcessPluginBase;
use Drupal\migrate\MigrateExecutableInterface;
use Drupal\migrate\Row;
use Drupal\media\Entity\Media;
use Drupal\Component\Utility\Html;

/**
 * Provides a 'ProcessBody' migrate process plugin.
 *
 * @MigrateProcessPlugin(
 *  id = "process_body"
 * )
 */
class ProcessBody extends ProcessPluginBase {

  /**
   * {@inheritdoc}
   */
  public function transform($value, MigrateExecutableInterface $migrate_executable, Row $row, $destination_property) {
    // Plugin logic goes here.
    $fullText = nl2br(html_entity_decode($value));
    $timestamp = strtotime($row->getSourceProperty('post_date'));
    $year = date('Y', $timestamp);
    $month = date('m', $timestamp);
    $directory = 'public://blog/media/' . $year . '/' . $month . '/';
    file_prepare_directory($directory, FILE_CREATE_DIRECTORY);
    preg_match_all('/<img(.*?)src=("|\'|)(.*?)("|\'| )(.*?)>/s', $fullText, $inline_images);
    preg_match_all("/\[caption.*\](.*?)\[\/caption\]/", $fullText, $captions);

    foreach ($captions[0] as $key => $caption) {
      preg_match('/<img(.*?)src=("|\'|)(.*?)("|\'| )(.*?)>/s', $caption, $caption_image);
      $pos = array_search($caption_image[3], $inline_images[3]);
      $media_image = $this->insertMedia($directory, $caption_image[3]);
      // Remove from array.
      $image_caption = trim(strip_tags($captions[1][$key]));
      unset($inline_images[3][$pos]);
      $fullText = $this->htmlReplaceCaption($fullText, $caption, $media_image->uuid(), $image_caption);
    }

    $inline_image_url = [];
    foreach ($inline_images[3] as $inline_image) {
      $media_image = $this->insertMedia($directory, $inline_image);
      $fullText = $this->htmlReplaceImagesByText($fullText, $inline_image, $media_image->uuid());
    }
    return $fullText;
  }

  /**
   * Regex replace images.
   */
  protected function htmlReplaceImagesByText($html, $img_src, $id) {
    $html_dom = Html::load($html);
    $imageTags = $html_dom->getElementsByTagName('img');
    foreach ($imageTags as $tag) {
      $imagepath = urldecode($tag->getAttribute('src'));
      if ($img_src == $imagepath) {
        $media = $html_dom->createElement('drupal-media');
        $media->setAttribute('data-align', 'center');
        $media->setAttribute('data-entity-type', 'media');
        $media->setAttribute('data-entity-uuid', $id);
        $anchor = $tag->parentNode;
        if (get_class($anchor) == 'DOMElement' && $anchor->tagName == 'a') {
          $anchor->parentNode->replaceChild($media, $anchor);
        }
        else {
          $tag->parentNode->replaceChild($media, $tag);
        }
      }
    }

    return Html::serialize($html_dom);
  }

  /**
   * Regex replace images.
   */
  protected function htmlReplaceCaption($html, $caption, $id, $image_caption) {
    // Escape special characters in $img_src so they work as
    // literals in the main regular expression.
    $replace = '<drupal-media data-align="center" data-caption="' . $image_caption . '" data-entity-type="media" data-entity-uuid="' . $id . '"></drupal-media>';
    return str_replace($caption, $replace, $html);
  }

  /**
   * Insert images.
   */
  protected function insertMedia($directory, $inline_image) {
    $image_data = file_get_contents($inline_image);
    $file_image = file_save_data($image_data, $directory . str_replace(" ", "_", basename($inline_image)), FILE_EXISTS_REPLACE);
    $fid = $file_image->id();
    $name = $file_image->filename;

    $media_image = Media::create([
      'bundle' => 'image',
      'name' => $name,
      'field_media_image' => [
        'target_id' => $fid,
      ],
    ]);
    $media_image->save();

    return $media_image;
  }

}
