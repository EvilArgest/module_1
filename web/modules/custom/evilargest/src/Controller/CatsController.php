<?php

namespace Drupal\evilargest\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\evilargest\Form\CatsForm;
use Drupal\file\Entity\File;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Cats controller.
 */
class CatsController extends ControllerBase {

  /**
   * Drupal\Core\Database defenition.
   *
   * @var \Drupal\Core\Database\Connection
   */
  private $database;

  /**
   * Drupal\Core\Form\FormBuilder definition.
   *
   * @var \Drupal\Core\Form\FormBuilder
   */
  protected $formBuilder;

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container): CatsController {
    $instance = parent::create($container);
    $instance->formBuilder = $container->get('form_builder');
    $instance->database = $container->get('database');
    return $instance;
  }

  /**
   * Getting form from Catsform.
   */
  public function content(): array {
    $form = $this->formBuilder()->getForm(CatsForm::class);
    $cats[] = $this->outputingCats();
    return [
      '#theme' => 'cats-theme',
      '#form' => $form,
      '#cats' => $cats,
    ];
  }

  /**
   * Outputing table with cats on the page.
   */
  public function outputingCats(): array {
    $table_result = $this->database->select('evilargest', 'eviltable')
      ->fields('eviltable', ['id', 'name', 'email', 'image', 'date'])
      ->orderBy('id', 'DESC')
      ->execute();
    $cats = [];
    foreach ($table_result as $cat) {
      $cat->image = [
        '#theme' => 'image_style',
        '#style_name' => 'medium',
        '#uri' => File::load($cat->image)->getFileUri(),
        '#attributes' => [
          'class' => 'cat_table_image',
          'alt' => 'cat photo',
        ],
      ];
      $render_cat = [
        '#theme' => "cat-table-block",
        '#name' => $cat->name,
        '#email' => $cat->email,
        '#image' => $cat->image,
        '#date' => date('d-m-Y H:i:s', $cat->date),
      ];
      $cats[] = $render_cat;
    }
    return $cats;
  }

}
