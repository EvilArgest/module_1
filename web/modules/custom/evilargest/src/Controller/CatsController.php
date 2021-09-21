<?php

namespace Drupal\evilargest\Controller;

class CatsController {
  public function content() {
    $form = \Drupal::formBuilder() -> getForm('Drupal\evilargest\Form\CatsForm');
    return [
      '#theme' => 'cats-theme',
      '#form' => $form,
    ];
  }
}
