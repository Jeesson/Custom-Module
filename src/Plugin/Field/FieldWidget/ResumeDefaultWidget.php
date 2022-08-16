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
//    $widget = parent::formElement($items, $delta, $element, $form, $form_state);
    $widget['quantity'] = array(
      '#title' => $this->t('Quantity'),
      '#type' => 'number',
      '#default_value' => isset($items[$delta]) ? $items[$delta]->quantity : 1,
      '#min' => 1,
      '#weight' => 10,
    );

    return $widget;
  }
}
