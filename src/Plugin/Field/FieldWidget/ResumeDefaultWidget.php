<?php
namespace Drupal\resume\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * @FieldWidget(
 *   id = "resume_default",
 *   label = @Translation("Resume default"),
 *   field_types = {
 *      "resume_type"
 *   }
 *  )
 */

class ResumeDefaultWidget extends WidgetBase {

  /**
   * @inheritDoc
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    $element = [];

    $element['value'] = [
      '#type' => 'select',
      '#options' => [
        'Debug' => 'Debug',
        'CST' => 'Customer',
        'MNG' => 'Manager',
        'VIP' => 'Very Important Person',
      ],
      '#title' => t('Who was it is?'),
    ];
    return $element;
  }
}
