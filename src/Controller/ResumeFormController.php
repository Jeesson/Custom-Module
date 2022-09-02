<?php
namespace Drupal\resume\Controller;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Component\Render\FormattableMarkup;
use Drupal\Core\Database\Connection;
use Drupal\resume\InfoService;
use Drupal\resume\InfoServiceDecorator;
use Drupal\resume\InfoServiceDecorator2;
use Laminas\Diactoros\Response\JsonResponse;
use Symfony\Component\DependencyInjection\ContainerInterface;
/**
 * Class ResumeFormController
 * @package Drupal\resume\Controller
 */
class ResumeFormController extends ControllerBase
{

  protected Connection $connection;
  protected InfoService $infoService;
  protected InfoServiceDecorator $infoDecorator;
  protected InfoServiceDecorator2 $infoDecorator2;

  /**
   *
   * @param Connection $connection
   * The database connection.
   * @param InfoService $infoService
   * @param InfoServiceDecorator $infoDecorator
   * @param InfoServiceDecorator2 $infoDecorator2
   *
   */
  public function __construct(Connection $connection, InfoService $infoService, InfoServiceDecorator $infoDecorator, InfoServiceDecorator2 $infoDecorator2)
  {
    $this->connection = $connection;
    $this->infoService = $infoService;
    $this->infoDecorator = $infoDecorator;
    $this->infoDecorator2 = $infoDecorator2;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container)
  {
    return new static(
      $container->get('database'),
      $container->get('resume.info'),
      $container->get('resume.decorator'),
      $container->get('resume.decorator_2'),
    );
  }

  /**
   * @return array
   */
  public function index()
  {

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
    $dbData['row'] = [
      '#type' => 'container',
      '#attributes' => [
        'class' => ['container', 'row', 'g-2', 'mb-2'],
      ],
    ];

    $dbData['row'][] = [
      '#type' => 'html_tag',
      '#tag' => 'code',
      '#attributes' => [
        'class' => ['card', 'card-body']
      ],
      '#value' => json_encode($orders)
    ];

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
      [
        '#type' => 'html_tag',
        '#tag' => 'div',
        '#attributes' => [
          'class' => ['card', 'card-body mb-2']
        ],
        '#value' => $this->infoDecorator2->getRandInfo().$this->infoDecorator->getRandInfo().$this->infoService->getRandInfo(),
      ],
      [
        '#theme' => 'resume_card_example',
        '#items' => [
          [
            'title' => 'Во втором сезоне Star Wars: Visions будут эпизоды от студий из разных стран мира',
            'desc' => 'Первый сезон Star Wars: Visions был антологией короткометражек от именитых мультипликационных студий Японии. Во втором сезоне размах будет глобальным — работы будут представлены от команд из разных концов мира.',
            'img' => 'https://cdn.shazoo.ru/c1400x625/636930_hNhMEiD_ronin-in-star-wars-visions-2021.jpg',
            'id' => 4,
          ],
          [
            'title' => 'Подробности следующего сезона и новый оперативник в презентации Rainbow Six Siege',
            'desc' => 'Ubisoft провела презентацию следующего сезона Rainbow Six Siege, который получил подзаголовок Brutal Swarm. Название отсылает к новому оперативнику игры — Гриму, который может управлять роем дронов-насекомых, напоминающих пчел.',
            'img' => 'https://cdn.shazoo.ru/c1400x625/636962_CRU8B25_siege.jpg',
            'id' => 3,
          ],
          [
            'title' => 'Подробности следующего сезона и новый оперативник в презентации Rainbow Six Siege',
            'desc' => 'Ubisoft провела презентацию следующего сезона Rainbow Six Siege, который получил подзаголовок Brutal Swarm. Название отсылает к новому оперативнику игры — Гриму, который может управлять роем дронов-насекомых, напоминающих пчел.',
            'img' => 'https://cdn.shazoo.ru/c1400x625/636962_CRU8B25_siege.jpg',
            'id' => 2,
          ],
          [
            'title' => 'Во втором сезоне Star Wars: Visions будут эпизоды от студий из разных стран мира',
            'desc' => 'Первый сезон Star Wars: Visions был антологией короткометражек от именитых мультипликационных студий Японии. Во втором сезоне размах будет глобальным — работы будут представлены от команд из разных концов мира.',
            'img' => 'https://cdn.shazoo.ru/c1400x625/636930_hNhMEiD_ronin-in-star-wars-visions-2021.jpg',
            'id' => 1,
          ],
        ],
      ],
      [
        '#type' => 'table',
        '#header' => $header,
        '#rows' => $data,
        '#sticky' => TRUE,
      ],
      $dbData,
    ];

  }
}
