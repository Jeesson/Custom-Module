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

  public function buildForm(array $form, FormStateInterface $form_state)
  {
    $form['first_name'] = array(
      '#type' => 'textfield',
      '#title' => t('Your First name:'),
      '#required' => TRUE,
    );

    $form['last_name'] = array(
      '#type' => 'textfield',
      '#title' => t('Your Last name:'),
      '#required' => TRUE,
    );

    $form['email'] = array(
      '#type' => 'email',
      '#title' => t('Email:'),
      '#required' => TRUE,
    );
    $form['description'] = array (
      '#type' => 'textarea',
      '#title' => t('Small description:'),
    );
    $form['candidate_dob'] = array (
      '#type' => 'date',
      '#title' => t('DOB'),
      '#required' => false,
    );
    $form['candidate_gender'] = array (
      '#type' => 'select',
      '#title' => ('Gender'),
      '#options' => array(
        'Male' => t('Male'),
        'Female' => t('Female'),
      ),
    );
    $form['actions']['submit'] = array(
      '#type' => 'submit',
      '#value' => $this->t('Отправить'),
      '#button_type' => 'primary',
    );
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

  public function submitForm(array &$form, FormStateInterface $form_state)
  {
    foreach ($form_state->getValues() as $key => $value) {
      $this->messenger()->addWarning($this->t($key . ': ' .$value));
    }
    $this->messenger()->addMessage($this->t("Форма успешно отправленна!"));

  }

}
