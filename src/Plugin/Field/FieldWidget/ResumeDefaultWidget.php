<?php
namespace Drupal\resume\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * @FieldWidget(
 *   id = "resume_default",
 *   label = @Translation("Resume default widget"),
 *   field_types = {
 *     "resume_type"
 *   }
 * )
 */

class ResumeDefaultWidget extends WidgetBase {

  /**
   * @inheritDoc
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {

    $value = isset($items->value) ? $items[$delta]->value : NULL;
    $long = isset($items->long) ? $items[$delta]->long : 150;

    $element['value'] = [
      '#type' => 'select',
      '#empty_option' => 'кто???',
      '#empty_value' => '',
      '#options' => [
        'DBG' => 'Debug',
        'CST' => 'Customer',
        'MNG' => 'Manager',
        'VIP' => 'Very Important Person',
      ],
      '#title' => $this->t('Who was that?'),
      '#default_value' => $value,
    ];
    $element['long'] = [
      '#type' => 'number',
      '#size' => 4,
      '#min' => 120,
      '#max' => 220,
      '#step' => 5,
      '#title' => $this->t('How long are you been here?'),
      '#default_value' => $long,
    ];
//    This value should be of the correct primitive type.
    return [
      'value' => $element['value'],
      'long' => $element['long'],
    ];
  }
}
