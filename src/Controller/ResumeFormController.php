<?php
namespace Drupal\resume\Controller;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Component\Render\FormattableMarkup;
use Drupal\Core\Database\Connection;
use Drupal\resume\InfoService;
use Drupal\resume\TotallyNews;
use Laminas\Diactoros\Response\JsonResponse;
use Symfony\Component\DependencyInjection\ContainerInterface;
/**
 * Class ResumeFormController
 * @package Drupal\resume\Controller
 */
class ResumeFormController extends ControllerBase {

  protected Connection $connection;
  protected InfoService $infoService;
  protected TotallyNews $totallyNews;
  /**
   *
   * @param Connection $connection
   * The database connection.
   * @param InfoService $infoService
   * @param TotallyNews $totallyNews
   *
   */
  public function __construct(Connection $connection, InfoService $infoService, TotallyNews $totallyNews) {
    $this->connection = $connection;
    $this->infoService = $infoService;
    $this->totallyNews = $totallyNews;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('database'),
      $container->get('resume.info'),
      $container->get('resume.news'),
    );
  }

  /**
   * @return array
   */
  public function index() {

    $field_arr = ['pid', 'first_name', 'last_name', 'email', 'description', 'gender', 'dob'];
//    $field_arr = ['pid', 'first_name', 'last_name'];
    $database = $this->connection;
    $query = $database->select('resume', 'r');
    $query->addJoin('INNER','resume_orders', 'c', 'r.pid=c.personid');
    $query->fields('r', $field_arr);
    $query->fields('c', ['orderid', 'order_date', 'role']);
    $query->orderBy('order_date');
    $orders = $query->execute()->fetchAll();

//    Database data
    echo ('<p>'.json_encode($orders).'</p><br>');


//    echo ('<p>'.$this->infoService->getRandInfo().'</p>');
    echo ('<p>'.$this->totallyNews->getRandInfo().'</p>');
    echo ('<p>'.$this->totallyNews->getAllInfo().'</p>');
    echo ('<p>'.$this->totallyNews->getSomeInfo(1).'</p>');


    foreach ($orders as $row) {
      $data[] = [
        'pid' => [
          'data' => $row->pid,
          'class' => 'data',
        ],
        'first_name' => $row->first_name,
        'last_name' => $row->last_name,
        'email' => $row->email,
        'description' => $row->description,
        'gender' => $row->gender,
        'dob' => $row->dob,
        'person_id' => $row->pid,
        'order_date' => $row->order_date,
        'customer_role' => $row->role,
      ];
    }

    $header = [
      'col0' => [
        'data' => $this->t('PID'),
        'class' => 'header',
      ],
      'col1' => [
        'data' => $this->t('Name'),
        'class' => 'header',
      ],
      'col2' => [
        'data' => $this->t('Surname'),
        'class' => 'header',
      ],
      'col3' => [
        'data' => $this->t('Email'),
        'class' => 'header',
      ],
      'col4' => [
        'data' => $this->t('Description'),
        'class' => 'header',
      ],
      'col5' => [
        'data' => $this->t('Gender'),
        'class' => 'header',
      ],
      'col6' => [
        'data' => $this->t('DOB'),
        'class' => 'header',
      ],
      'col7' => [
        'data' => $this->t('Person ID'),
        'class' => 'header',
      ],
      'col8' => [
        'data' => $this->t('Order date'),
        'class' => 'header',
      ],
      'col9' => [
        'data' => $this->t('Customer role'),
        'class' => 'header',
      ],
    ];

    return [
      '#type' => 'table',
      '#header' => $header,
      '#rows' => $data,
      '#sticky' => TRUE,
    ];

  }
}
