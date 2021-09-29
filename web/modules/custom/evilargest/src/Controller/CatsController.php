<?php

namespace Drupal\evilargest\Controller;

/**
 * Cats controller.
 */
class CatsController {

  /**
   * Getting form from Catsform.
   */
  public function content() {
    $form = \Drupal::formBuilder()->getForm('Drupal\evilargest\Form\CatsForm');
    return [
      '#theme' => 'cats-theme',
      '#form' => $form,
    ];
  }

}
