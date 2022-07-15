<?php
/**
 * @file
 * Contains \Drupal\resume\Form\ResumeForm.
 */
namespace Drupal\resume\Form;
// Use for Ajax.
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\HtmlCommand;

use Drupal\Core\Database\Connection;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ResumeForm extends FormBase {

  protected $connection;

  /**
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
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'resume_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {

    $form['first_name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Your First name:'),
      '#required' => TRUE,
    ];

    $form['last_name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Your Last name:'),
      '#required' => TRUE,
    ];

    $form['email'] = [
      '#type' => 'email',
      '#title' => $this->t('Email:'),
      '#required' => TRUE,
    ];

    $form['description'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Small description:'),
      '#default_value' => $this->t('Lorem ipsum dolor sit amet, consectetur adipiscing elit aliquam.'),
    ];

    $form['candidate_dob'] = [
      '#type' => 'date',
      '#title' => $this->t('DOB'),
      '#default_value' => date('Y-m-d'),
      '#required' => FALSE,
    ];

    $form['candidate_gender'] = [
      '#type' => 'select',
      '#title' => ('Gender'),
      '#options' => [
        'Male' => $this->t('Male'),
        'Female' => $this->t('Female'),
      ],
    ];

    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Отправить'),
      '#button_type' => 'primary',
//      '#ajax' => [
//        'callback' => '::setMessage',
//      ],
    ];

    // Placeholder to put the result of Ajax call, setMessage().
//    $form['message'] = [
//      '#type' => 'markup',
//      '#markup' => '<div class="result_message"></div>',
//    ];

    // Asset library.
    $form['#attached']['library'][] = 'resume/resume-asset';

    return $form;
  }

//  public function setMessage(array $form, FormStateInterface $form_state) {
//
//    $response = new AjaxResponse();
//    $response->addCommand(
//      new HtmlCommand(
//        '.result_message',
//        '<div class="my_message">Submitted title is ' . $form_state->getValue('first_name') . '</div>')
//    );
//    return $response;
//  }

  public function validateForm(array &$form, FormStateInterface $form_state) {

    $email_regex = "/[a-zA-Z0-9_\-.+]+@[a-zA-Z0-9-]+.[a-zA-Z]+/";

    if (strlen($form_state->getValue('first_name')) < 3) {
      $form_state->setErrorByName('first_name', $this->t('first_name is too short.'));
    } elseif (strlen($form_state->getValue('last_name')) < 3) {
      $form_state->setErrorByName('last_name', $this->t('last_name is too short.'));
    }

    if (preg_match("/^[a-zA-Z]+$/", $form_state->getValue('first_name') ) == 0) {
      // string only contain the a to z , A to Z
      $form_state->setErrorByName('first_name', $this->t('First name only contain the "a to z" and "A to Z" char.'));
    }
    if (preg_match("/^[a-zA-Z]+$/", $form_state->getValue('last_name') ) == 0) {
      $form_state->setErrorByName('last_name', $this->t('Last name only contain the "a to z" and "A to Z" char.'));
    }

    if (preg_match($email_regex, $form_state->getValue('email')) == 0) {
//      $this->messenger()->addMessage(filter_var($form_state->getValue('email'), FILTER_VALIDATE_EMAIL));
//      $this->messenger()->addMessage(preg_match($email_regex, $form_state->getValue('email')));
      $form_state->setErrorByName('email', $this->t('Email error'));
    }

  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    $messenger = $this->messenger();
    foreach ($form_state->getValues() as $key => $value) {
      $messenger->addWarning($key . ': ' .$value);
    }
    $messenger->addMessage($this->t("Форма прошла валидацию 🖤"));

    $field = $form_state->getValues();
    $uid = random_int(0,999);
    $first_name = $field['first_name'];
    $last_name = $field['last_name'];
    $email = $field['email'];
    $description = $field['description'];
    $gender = $field['candidate_gender'];
    $age = $field['candidate_dob'];
    $field_arr = [
      'uid' => $uid,
      'first_name' => $first_name,
      'last_name' => $last_name,
      'email' => $email,
      'description' => $description,
      'gender' => $gender,
      'dob' => $age,
    ];

//    if (\Drupal::currentUser()->hasPermission('access resume-form')) {
      $query = $this->connection;
      $query->insert('resume')
        ->fields($field_arr)
        ->execute();
      $messenger->addMessage($this->t("Данные успешно сохранены да 🖤"));
//    } else $messenger->addError('Неавторизованным челиксам доступ закрыт, ты как сюда попал? 🤬');

  }
}
