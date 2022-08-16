<?php
namespace Drupal\resume\Plugin\Field\FieldType;

use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\StringTranslation\TranslatableMarkup;
use Drupal\Core\TypedData\DataDefinition;

/**
 * Provides a field type of Resume.
 *
 * @FieldType(
 *   id = "resume_type",
 *   label = @Translation("Resume Field"),
 *   default_formatter = "resume_default",
 *   default_widget = "resume_default",
 * )
 */
class ResumeItem extends FieldItemBase {

  /**
   * {@inheritdoc}
   */
  public static function mainPropertyName() {
    return 'quantity';
  }

  /**
   * {@inheritdoc}
   */
  public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition): array {
    $properties = [];
    $properties['quantity'] = DataDefinition::create('integer')
      ->setLabel(new TranslatableMarkup('Quantity'));

    return $properties;
  }

  /**
   * {@inheritdoc}
   */
  public static function schema(FieldStorageDefinitionInterface $field_definition) {
    return [
      'columns' => [
        'quantity' => [
          'type' => 'int',
          'size' => 'tiny',
          'unsigned' => TRUE,
        ],
      ],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public static function defaultFieldSettings(): array {
    return ['size' => 'medium'] + parent::defaultFieldSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function fieldSettingsForm(array $form, FormStateInterface $form_state): array {
    $element = [];
    $element['size'] = [
      '#type' => 'select',
      '#title' => $this->t('Choose your size'),
      '#options' => [
        'small' => $this->t('Small'),
        'medium' => $this->t('Medium'),
        'large' => $this->t('Large'),
      ],
      '#description' => $this->t('Try to choose your real P size :D'),
      '#default_value' => $this->getSetting('size'),
    ];

    return $element;
  }

  /**
   * {@inheritdoc}
   */
  public function isEmpty() {
    $value = $this->get('quantity')->getValue();
    return $value === NULL || $value === '';
  }

}
