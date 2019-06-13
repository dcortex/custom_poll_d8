<?php

namespace Drupal\custom_poll_d8\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Returns responses for Custom Poll D8 routes.
 */
class CustomPollD8Controller extends ControllerBase {

  /**
   * Builds the response.
   */
  public function thankYou() {

    $build['content'] = [
      '#type' => 'item',
      '#markup' => $this->t('Gracias por completar la información!'),
    ];

    return $build;
  }

  /**
   * Display.
   *
   * @return string
   *   Return Array Table
   */
  public function display() {
    //create table header
    $header_table = array(
      'id'=>    t('ID'),
      'name' => t('Nombre'),
      'email' => t('Email'),
      'phone' => t('Número Teléfono'),
      'question1' => t('Pregunta 1'),
      'question2' => t('Pregunta 2'),
    );

    $query = \Drupal::database()->select('custom_poll_d8_poll', 'p');
    $query->fields('p', ['id','name','email','phone','question1','question2',]);
    $results = $query->execute()->fetchAll();

    $rows = [];
    foreach($results as $data){

      $rows[] = array(
        'id'        => $data->id,
        'name'      => $data->name,
        'email'     => $data->email,
        'phone'     => $data->phone,
        'question1' => $data->question1,
        'question2' => $data->question2,
      );
    }
    //display data in site
    $form['table'] = [
      '#type' => 'table',
      '#header' => $header_table,
      '#rows' => $rows,
      '#empty' => t('No Polls found'),
    ];
    return $form;
  }
}
