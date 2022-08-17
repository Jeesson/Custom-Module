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
 *   list_class = "\Drupal\Core\Field\EntityReferenceFieldItemList",
 * )
 */
class ResumeItem extends FieldItemBase {

  /**
   * {@inheritdoc}
   */
  public static function schema(FieldStorageDefinitionInterface $field_definition) {
    return [
      // columns contains the values that the field will store
      'columns' => [
        // List the values that the field will save.
        'value' => [
          'type' => 'text',
          'size' => 'small',
          'not null' => FALSE,
        ],
        'long' => [
          'type' => 'int',
          'size' => 'small',
          'not null' => FALSE,
        ],
      ],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition): array {
    $properties = [];
    $properties['value'] = DataDefinition::create('string')->setLabel(t('Value'));
    $properties['long'] = DataDefinition::create('integer')->setLabel(t('Long'));

    return $properties;
  }


  public function isEmpty() {
    $value = $this->get('value')->getValue();
    $long = $this->get('long')->getValue();

    return
      ($value === NULL || $value === '' || $value === 0) &&
      ($long === NULL || $long === '' || $long === 0);
  }

  /**
   * {@inheritdoc}
   */
  public static function defaultFieldSettings(): array {
    return ['size' => 'large'] + parent::defaultFieldSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function fieldSettingsForm(array $form, FormStateInterface $form_state): array {

    $element = [];

    // The key of the element should be the setting name
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
}
