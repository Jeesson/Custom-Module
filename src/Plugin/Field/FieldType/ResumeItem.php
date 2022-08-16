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
  public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition): array {
//    $properties = parent::propertyDefinitions($field_definition);
    $quantity_definition = DataDefinition::create('integer')
      ->setLabel(new TranslatableMarkup('Quantity'))
      ->setRequired(TRUE);
    $properties['quantity'] = $quantity_definition;
    return $properties;
  }

  /**
   * {@inheritdoc}
   */
  public static function schema(FieldStorageDefinitionInterface $field_definition) {
//    $schema = parent::schema($field_definition);
    $schema['columns']['quantity'] = array(
      'type' => 'int',
      'size' => 'tiny',
      'unsigned' => TRUE,
    );

    return $schema;
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
