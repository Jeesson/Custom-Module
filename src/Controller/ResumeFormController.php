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

//    echo ('<p>'.$this->infoService->getRandInfo().'</p>');
    echo('<p>' . $this->infoDecorator2->getRandInfo() . '</p>');
    echo('<p>' . $this->infoDecorator->getRandInfo() . '</p>');

//    Database data
    $dbData['row'] = [
      '#type' => 'container',
      '#attributes' => [
        'class' => ['container', 'row', 'g-0', 'gap-2'],
      ],
    ];

    $dbData['row'][] = [
      '#type' => 'html_tag',
      '#tag' => 'code',
      '#attributes' => [
        'class' => ['card', 'card-body', 'mb-2']
      ],
      '#value' => json_encode($orders)
    ];

    $dbData['#attached']['library'][] = 'resume/resume-asset';

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
        '#type' => 'table',
        '#header' => $header,
        '#rows' => $data,
        '#sticky' => TRUE,
      ],
      $dbData,
      $this->element(),
    ];

  }

  public function element(): array {
    $element = [];

    $element['row'] = [
      '#type' => 'container',
      '#attributes' => [
        'class' => ['container', 'row', 'g-0', 'gap-2'],
      ],
    ];

    $element['row']['card_1'] = [
      '#type' => 'container',
      '#attributes' => [
        'class' => ['card', 'w-50', 'col'],
      ],
    ];

    $element['row']['card_1']['image'] = [
      '#type' => 'html_tag',
      '#tag' => 'image',
      '#attributes' => [
        'src' => 'https://cdn.shazoo.ru/c1400x625/636930_hNhMEiD_ronin-in-star-wars-visions-2021.jpg',
        'width' => 500,
        'class' => 'card-img-top'
      ],
    ];

    $element['row']['card_1']['content'] = [
      '#type' => 'container',
      '#attributes' => [
        'class' => ['card-body'],
      ],
    ];

    $element['row']['card_1']['content']['title'] = [
      '#type' => 'html_tag',
      '#tag' => 'h2',
      '#attributes' => [
        'class' => ['card-title', 'm-0', 'mb-2'],
      ],
      '#value' => 'Во втором сезоне Star Wars: Visions будут эпизоды от студий из разных стран мира',
    ];

    $element['row']['card_1']['content'][] = [
      '#type' => 'html_tag',
      '#tag' => 'p',
      '#value' => 'Первый сезон Star Wars: Visions был антологией короткометражек от именитых мультипликационных студий Японии. Во втором сезоне размах будет глобальным — работы будут представлены от команд из разных концов мира.',
      '#attributes' => [
        'class' => ['card-text', 'm-0', 'mb-1'],
      ],
    ];

    $element['row']['card_1']['content']['quote'] = [
      '#type' => 'html_tag',
      '#tag' => 'blockquote',
      '#value' => 'Мы хотели сделать из Visions своего рода суббренд, который позволил бы различным авторам реализовывать их уникальное видение. Поэтому второй сезон станет глобальным туром по некоторым из самых интересных анимационных студий со всего мира.',
      '#attributes' => [
        'class' => ['card-text', 'm-0', 'my-2'],
      ],
    ];

    $element['row']['card_1']['content'][] = [
      '#type' => 'html_tag',
      '#tag' => 'p',
      '#value' => 'Второй сезон Star Wars: Visions выйдет весной следующего года. Первый сезон получился спорным из-за разношерстности эпизодов. Некоторые эпизоды пришлись по душе фанатам, в то время как другие получили крайне низкие оценки. Хотя критики остались довольны.',
      '#attributes' => [
        'class' => ['card-text', 'm-0'],
      ],
    ];

    $element['row']['card_2'] = $element['row']['card_1'];
    $element['row']['card_2']['image']['#attributes']['src'] = 'https://cdn.shazoo.ru/c1400x625/636962_CRU8B25_siege.jpg';
    $element['row']['card_2']['content']['title']['#value'] = 'Подробности следующего сезона и новый оперативник в презентации Rainbow Six Siege';
    $element['row']['card_2']['content'][0]['#value'] = 'Ubisoft провела презентацию следующего сезона Rainbow Six Siege, который получил подзаголовок Brutal Swarm. Название отсылает к новому оперативнику игры — Гриму, который может управлять роем дронов-насекомых, напоминающих пчел.';
    $element['row']['card_2']['content'][1]['#value'] = 'Грим обладает также взрывчаткой-клейморой и тремя видами оружия: дробовиком и двумя штурмовыми винтовками. Также в игре появится граната с электромагнитным импульсом и новая карта — Стадион. Также разработчики улучшили кастомизацию оружия, систему бана карт и сделали множество других апдейтов. Название отсылает к новому оперативнику игры — Гриму, который может управлять роем дронов-насекомых, напоминающих пчел.';
    unset ($element['row']['card_2']['content']['quote']);

    $element['#attached']['library'][] = 'resume/resume-asset';

    return $element;
  }

}
