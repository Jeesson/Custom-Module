<?php
namespace Drupal\resume\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;

/**
 * @FieldFormatter(
 *   id = "resume_default",
 *   label = @Translation("Resume"),
 *   field_types = {
 *      "resume_type"
 *   }
 *  )
 */

class ResumeDefaultFormatter extends FormatterBase {

  /**
   * @inheritDoc
   */
  public function viewElements(FieldItemListInterface $items, $langcode): array {
//    Допустим такой массив
    $elements = ['ID', 'NAME', 'ROLE'];
    $i = 0;
    foreach ($elements as $element) {
      $elements[$i] = [
        '#type' => 'markup',
        '#markup' => '<code>' . $element . '</code>',
      ];
      $i += 1;
    }


    return $elements;
  }
}
