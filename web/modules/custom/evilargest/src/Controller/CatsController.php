<?php

namespace Drupal\evilargest\Controller;

class CatsController {
  public function content()
  {
    return [
      '#theme' => 'cats-theme',
    ];
  }
}
