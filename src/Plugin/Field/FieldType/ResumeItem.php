<?php
namespace Drupal\resume\Plugin\Field\FieldType;

use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\TypedData\DataDefinition;

/**
 * Provides a field type of Resume.
 *
 * @FieldType(
 *   id = "resume_type",
 *   label = @Translation("Resume field"),
 *   default_formatter = "Resume_default",
 *   default_widget = "Resume_default",
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
        // List the values that the field will save. This
        // field will only save a single value, 'value'
        'value' => [
          'type' => 'text',
          'size' => 'tiny',
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

    return $properties;
  }


  public function isEmpty(): bool {
    $value = $this->get('value')->getValue();
    return $value === NULL || $value === '';
  }

  /**
   * {@inheritdoc}
   */
  public static function defaultFieldSettings(): array {
    return [
        // Declare a single setting, 'size', with a default
        // value of 'large'
        'size' => 'large',
      ] + parent::defaultFieldSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function fieldSettingsForm(array $form, FormStateInterface $form_state): array {

    $element = [];
    // The key of the element should be the setting name
    $element['size'] = [
      '#title' => $this->t('Size'),
      '#type' => 'select',
      '#options' => [
        'small' => $this->t('Small'),
        'medium' => $this->t('Medium'),
        'large' => $this->t('Large'),
      ],
      '#default_value' => $this->getSetting('size'),
    ];

    return $element;
  }

}
