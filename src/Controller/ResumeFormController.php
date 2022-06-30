<?php

namespace Drupal\resume\Controller;
use Drupal\Core\Controller\ControllerBase;

class ResumeFormController extends ControllerBase {

  /**
   * @return array
   */
  public function index() {

    $header = [
      'col1' => t('COL1'),
      'col2' => t('COL2'),
    ];
    $rows = [
      ['test col 1', 'test'],
      ['test col 1', 'test'],
      ['test col 1', 'test'],
    ];
    return [
      '#type' => 'table',
      '#header' => $header,
      '#rows' => $rows,
    ];

  }

}
