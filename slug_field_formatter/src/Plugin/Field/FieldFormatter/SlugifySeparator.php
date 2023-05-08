<?php

namespace Drupal\slug_field_formatter\Plugin\Field\FieldFormatter;

use Cocur\Slugify\Slugify;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin implementation of the 'slugify_separator' formatter.
 *
 * @FieldFormatter(
 *   id = "slugify_separator",
 *   label = @Translation("Slugify Separator"),
 *   field_types = {
 *     "text"
 *   }
 * )
 */
class SlugifySeparator extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = [];

    $slugify = new Slugify();
    $separator = $this->getSetting('separator');
    foreach ($items as $delta => $item) {
      $value = $item->value;
      $slug = $slugify->slugify($value, $separator);
      $elements[$delta] = [
        '#markup' => $slug,
      ];
    }
    return $elements;
  }

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return ['separator' => '-',] + parent::defaultSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    $form = parent::settingsForm($form, $form_state);

    $form['separator'] = [
      '#title' => $this->t('Separator'),
      '#type' => 'textfield',
      '#default_value' => $this->getSetting('separator'),
      '#description' => $this->t('Specify the separator character for the slug.'),
    ];
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $separator = $this->getSetting('separator');
    return [$this->t('Separator: @separator', ['@separator' => $separator])];
  }
}
