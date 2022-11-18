<?php

namespace Drupal\user_details\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Database\Database;
use Drupal\Core\Url;
use Drupal\Core\Link;

/**
 * Class DisplayUserTableController.
 *
 * @package Drupal\user_details\Controller
 */
class DisplayUserTableController extends ControllerBase {

  /**
   * Function for displaying table.
   */
  public function display() {
    //create table header
    $header_table = array(
      'id'=>    t('SrNo'),
      'first_name' => t('FirstName'),
      'last_name' => t('LastName'),
      'dob' => t('DOB'),
      'age' => t('Age'),
      'mobile_no' => t('MobileNumber'),
      'opt' => t('operations'),
      'opt1' => t('operations'),
    );

    //select records from table
    $query = \Drupal::database()->select('user_details_db', 'u');
    $query->fields('u', ['id','first_name','last_name','dob','age','mobile_no']);
    $query->orderBy('id', 'DESC');
    $query->range(0, 5);
    $results = $query->execute()->fetchAll();

    $rows = array();
    foreach($results as $data) {
      $delete = Url::fromUserInput('/user-details/form/delete/'. $data->id);
      $edit = Url::fromUserInput('/user-details?num='. $data->id);

      //print the data from table
      $rows[] = array(
        'id' =>$data->id,
        'first_name' => $data->first_name,
        'last_name' => $data->last_name,
        'dob' => $data->dob,
        'age' => $data->age,
        'mobile_no' => $data->mobile_no,

        Link::fromTextAndUrl('Delete', $delete)->toString(),
        Link::fromTextAndUrl('Edit', $edit)->toString(),
      );
    }

    // setting max age to 0 for caching.
    $form['#cache'] = ['max-age' => 0];

    //display data on the site
    $form['table'] = [
      '#type' => 'table',
      '#header' => $header_table,
      '#rows' => $rows,
      '#empty' => t('No users found'),
    ];
    return $form;
  }
}
