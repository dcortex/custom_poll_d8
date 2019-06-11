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
  public function build() {

    $build['content'] = [
      '#type' => 'item',
      '#markup' => $this->t('It works!'),
    ];

    return $build;
  }

}
