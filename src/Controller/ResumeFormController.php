<?php
namespace Drupal\resume\Controller;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Component\Render\FormattableMarkup;
use Drupal\Core\Database\Connection;
use Laminas\Diactoros\Response\JsonResponse;
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

//    $field_arr = ['uid', 'first_name', 'last_name', 'email', 'description', 'gender', 'dob'];
    $field_arr = ['pid', 'first_name', 'last_name'];
    $database = $this->connection;
    $query = $database->select('resume', 'r');
    $query->addJoin('INNER','resume_customers', 'c', 'r.pid=c.person_id');
    $query->fields('r', $field_arr);
    $query->fields('c', ['person_id', 'order_date', 'customer_role']);
//    $query->orderBy('order_date');
    $orders = $query->execute()->fetchAll();

    echo('<p>'.json_encode($orders).'</p>');

    foreach ($orders as $row) {
      $data[] = [
        'pid' => $row->pid,
        'first_name' => $row->first_name,
        'last_name' => $row->last_name,
//        'email' => $row->email,
//        'description' => $row->description,
//        'gender' => $row->gender,
//        'dob' => $row->dob,
        'person_id' => $row->person_id,
        'order_date' => $row->order_date,
        'customer_role' => $row->customer_role,
      ];
    }

    $header = [
      'col0' => t('pid'),
      'col1' => t('Name'),
      'col2' => t('Surname'),
//      'col3' => t('Email'),
//      'col4' => t('Description'),
//      'col5' => t('Gender'),
//      'col6' => t('DOB'),
      'col7' => t('person_id'),
      'col8' => t('order_date'),
      'col9' => t('customer_role'),
    ];

    return [
      '#type' => 'table',
      '#header' => $header,
      '#rows' => $data,
      '#sticky' => TRUE,
    ];

  }
}
