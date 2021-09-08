<?php

namespace Drupal\evilargest\Controller;

class CatsController {
  public function content() {
    $element = array(
      '#markup' => 'Hello! You can add here a photo of your cat.',
    );
    return $element;
  }
}
