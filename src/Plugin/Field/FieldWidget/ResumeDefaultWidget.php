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
    $value = isset($items[$delta]->quantity) ? $items[$delta]->quantity : '';
    $element += [
      '#type' => 'number',
      '#default_value' => $value,
      '#min' => 1,
      '#weight' => 10,
    ];

    return ['quantity' => $element];
  }
}
