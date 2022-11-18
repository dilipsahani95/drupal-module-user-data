<?php

/**
 * @file
 * Contains \Drupal\user_details\Form\UserInfoForm.
 */

namespace Drupal\user_details\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;
use Drupal\Core\Database\Database;
use Drupal\Core\Messenger;

/**
 * Provides the form for adding user details.
 */
class UserInfoForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'user_info_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {

    $conn = Database::getConnection();
    $record = array();
    if (isset($_GET['num'])) {
      $query = $conn->select('user_details_db', 'u')
        ->condition('id', $_GET['num'])
        ->fields('u');
      $record = $query->execute()->fetchAssoc();
    }

    $form['first_name'] = array(
      '#type' => 'textfield',
      '#title' => t('First Name:'),
      '#required' => TRUE,
      '#default_value' => (isset($record['first_name']) && $_GET['num']) ? $record['first_name'] : '',
    );
    $form['last_name'] = array(
      '#type' => 'textfield',
      '#title' => t('Last Name:'),
      '#required' => TRUE,
      '#default_value' => (isset($record['last_name']) && $_GET['num']) ? $record['last_name'] : '',
    );
    $form['dob'] = array(
      '#type' => 'date',
      '#title' => $this->t('Date of Birth:'),
      '#required' => TRUE,
      '#default_value' => (isset($record['dob']) && $_GET['num']) ? date('Y-m-d', strtotime($record['dob'])) : '',
    );
    $form['age'] = array(
      '#type' => 'textfield',
      '#title' => t('AGE'),
      '#required' => TRUE,
      '#default_value' => (isset($record['age']) && $_GET['num']) ? $record['age'] : '',
    );
    $form['mobile_no'] = array(
      '#type' => 'textfield',
      '#title' => t('Mobile Number:'),
      '#required' => TRUE,
      '#default_value' => (isset($record['mobile_no']) && $_GET['num']) ? $record['mobile_no'] : '',
    );

    $form['submit'] = array(
      '#type' => 'submit',
      '#value' => 'save',
    );
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $field = $form_state->getValues();
    $fname = $field['first_name'];
    $lname = $field['last_name'];
    $dob = $field['dob'];
    $age = $field['age'];
    $mob_number = $field['mobile_no'];

    if (isset($_GET['num'])) {
      $field = array(
        'first_name' => $fname,
        'last_name' => $lname,
        'dob' => $dob,
        'age' => $age,
        'mobile_no' => $mob_number,
      );

      $query = \Drupal::database();
      $query->update('user_details_db')
        ->fields($field)
        ->condition('id', $_GET['num'])
        ->execute();
      \Drupal::messenger()->addMessage(t("succesfully updated"));
      $form_state->setRedirect('user_details.display_table_controller');
    }

    else {
      $field = array(
        'first_name' => $fname,
        'last_name' => $lname,
        'dob' => $dob,
        'age' => $age,
        'mobile_no' => $mob_number,
      );

      $query = \Drupal::database();
      $query->insert('user_details_db')
        ->fields($field)
        ->execute();
      \Drupal::messenger()->addMessage(t("succesfully saved"));
      $form_state->setRedirect('user_details.display_table_controller');
    }
  }
}
