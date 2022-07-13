<?php
namespace Drupal\resume\Controller;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Component\Render\FormattableMarkup;
use Drupal\Core\Database\Connection;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class ResumeFormController
 * @package Drupal\resume\Controller
 */
class ResumeFormController extends ControllerBase {

  protected $connection;

  /**
   * Constructs a new DblogClearLogConfirmForm.
   *
   * @param \Drupal\Core\Database\Connection $connection
   *   The database connection.
   */
  public function __construct(Connection $connection) {
    $this->connection = $connection;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('database')
    );
  }

  /**
   * @return array
   */
  public function index() {

    $field_arr = ['uid', 'first_name', 'last_name', 'email', 'description', 'gender', 'dob'];
    $database = $this->connection;
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
      'col0' => t('Uid'),
      'col1' => t('Name'),
      'col2' => t('Surname'),
      'col3' => t('Email'),
      'col4' => t('Description'),
      'col5' => t('Gender'),
      'col6' => t('DOB'),
    ];

    return [
      '#type' => 'table',
      '#header' => $header,
      '#rows' => $data,
      '#sticky' => TRUE,
    ];

  }
}
