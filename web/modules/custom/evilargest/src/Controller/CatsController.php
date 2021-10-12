<?php

namespace Drupal\evilargest\Controller;

use Drupal\evilargest\Form\CatsForm;

/**
 * Cats controller.
 */
class CatsController {

  /**
   * Getting form from Catsform.
   */
  public function content(): array {
    $form = \Drupal::formBuilder()->getForm(CatsForm::class);
    return [
      '#theme' => 'cats-theme',
      '#form' => $form,
    ];
  }

}
