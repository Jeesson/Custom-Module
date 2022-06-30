<?php
namespace Drupal\resume\Controller;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Component\Render\FormattableMarkup;

/**
 * Class ResumeFormController
 * @package Drupal\resume\Controller
 */
class ResumeFormController extends ControllerBase {

  /**
   * @return array
   */
  public function index() {

    $field_arr = ['uid', 'first_name', 'last_name', 'email', 'description', 'gender', 'dob'];
    $database = \Drupal::database();
    $query = $database->select('resume', 'r')
      ->fields('r', $field_arr)
      ->execute()->fetchAll();

    foreach ($query as $row) {
      $data[] = [
        'uid' => $row->uid,
        'first_name' => $row->first_name,
        'last_name' => $row->last_name,
        'email' => $row->email,
        'description' => $row->description,
        'gender' => $row->gender,
        'dob' => $row->dob,
      ];
    }

    $header = [
      'col0' => t('uid'),
      'col1' => t('fname'),
      'col2' => t('sname'),
      'col3' => t('email'),
      'col4' => t('description'),
      'col5' => t('gender'),
      'col6' => t('dob'),
    ];

    $rows = [
//      ['uid 1', 'fullname', ['data'=>$value,'colspan' => 2]],

      [['data' => 'trash'], ['data' => 'fullname'], ['data' => 'email'], ['data' => 'description'], ['data' => 'gender'], ['data' => 'dob']],
      [['data' => 'uid 1'], ['data' => 'fullname'], ['data' => 'email'], ['data' => 'description'], ['data' => 'gender'], ['data' => 'dob']],
      [['data' => 'uid 1'], ['data' => 'fullname'], ['data' => 'email'], ['data' => 'description'], ['data' => 'gender'], ['data' => 'dob']],
      [['data' => 'uid 1'], ['data' => 'fullname'], ['data' => 'email'], ['data' => 'description'], ['data' => 'gender'], ['data' => 'dob']],
      [['data' => 'uid 1'], ['data' => 'fullname'], ['data' => 'email'], ['data' => 'description'], ['data' => 'gender'], ['data' => 'dob']],

    ];
    return [
      '#type' => 'table',
      '#header' => $header,
      '#rows' => $data,
    ];

  }
}
