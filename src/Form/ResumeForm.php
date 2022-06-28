<?php
/**
 * @file
 * Contains \Drupal\resume\Form\ResumeForm.
 */
namespace Drupal\resume\Form;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
class ResumeForm extends FormBase {
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
    ];

    $form['candidate_dob'] = [
      '#type' => 'date',
      '#title' => $this->t('DOB'),
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
    ];
    return $form;
  }

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
    $messenger->addMessage($this->t("Форма успешно отправленна!"));

    $field = $form_state->getValues();
    $first_name = $field['first_name'];
    $last_name = $field['last_name'];
    $email = $field['email'];
    $description = $field['description'];
    $gender = $field['candidate_gender'];
    $age = $field['candidate_dob'];
    $field_arr = [
      'first_name' => $first_name,
      'last_name' => $last_name,
      'email' => $email,
      'description' => $description,
      'gender' => $gender,
      'dob' => $age,
    ];
    $query = \Drupal::database();
    $query->insert('resume')
      ->fields($field_arr)
      ->execute();
    $messenger->addMessage($this->t("Data successfully saved"));
  }
}
