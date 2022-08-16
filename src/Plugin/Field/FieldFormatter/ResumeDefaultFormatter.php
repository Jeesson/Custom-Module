<?php
namespace Drupal\resume\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;

/**
 * @FieldFormatter(
 *   id = "resume_default",
 *   label = @Translation("Resume default"),
 *   field_types = {
 *     "resume_type"
 *   }
 * )
 */

class ResumeDefaultFormatter extends FormatterBase {

  /**
   * @inheritDoc
   */
  public function viewElements(FieldItemListInterface $items, $langcode): array {
    $elements = [];
    $values = $items->getValue();

    foreach ($values as $delta => $entity) {
      $elements[$delta] = [
        "#type" => 'markup',
        "#markup" => $entity['quantity']
      ];
    }

    return $elements;
  }
}
