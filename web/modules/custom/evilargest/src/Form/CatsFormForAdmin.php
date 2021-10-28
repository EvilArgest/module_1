<?php

namespace Drupal\evilargest\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;
use Drupal\file\Entity\File;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Form for adding cats.
 */
class CatsFormForAdmin extends FormBase {

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container): CatsFormForAdmin {
    $instance = parent::create($container);
    $instance->messenger = $container->get('messenger');
    $instance->database = $container->get('database');
    return $instance;
  }

  /**
   * Cats ids storaging.
   *
   * @var null
   */
  public $id;

  /**
   * Drupal\Core\Database defenition.
   *
   * @var \Drupal\Core\Database\Connection|object|null
   */
  public $database;

  /**
   * {@inheritdoc}
   */
  public function getFormId(): string {
    return 'cats_form_admin';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state, $id = NULL) {
    $this->id = $id;
    $data = $this->database->select('evilargest', 'evil')
      ->fields('evil', ['id', 'name', 'email', 'image', 'date'])
      ->orderBy('id', 'DESC')
      ->execute()->fetchAll();
    $cats = [];
    foreach ($data as $cat) {
      $cat->image = [
        '#theme' => 'image_style',
        '#style_name' => 'thumbnail',
        '#uri' => File::load($cat->image)->getFileUri(),
        '#attributes' => [
          'class' => 'cat_table_image',
          'alt' => 'cat photo',
        ],
      ];
      $admin_delete_url = Url::fromRoute('cats.deleteCat.admin', ['id' => $cat->id]);
      $admin_edit_url = Url::fromRoute('cats.editCat.admin', ['id' => $cat->id]);
      $delete_link = [
        '#title' => 'Delete',
        '#type' => 'link',
        '#url' => $admin_delete_url,
        '#attributes' => [
          'class' => ['use-ajax'],
          'data-dialog-type' => 'modal',
        ],
        '#attached' => [
          'library' => ['core/drupal.dialog.ajax'],
        ],
      ];
      $edit_link = [
        '#title' => 'Edit',
        '#type' => 'link',
        '#url' => $admin_edit_url,
        '#attributes' => [
          'class' => ['use-ajax'],
          'data-dialog-type' => 'modal',
        ],
        '#attached' => [
          'library' => ['core/drupal.dialog.ajax'],
        ],
      ];
      $cats[$cat->id] = [
        ['data' => $cat->image],
        $cat->id,
        $cat->name,
        $cat->email,
        date('d-m-Y H:i:s', $cat->date),
        [
          'data' => $delete_link,
        ],
        [
          'data' => $edit_link,
        ],
      ];
    }
    $header = ['Image', 'Id', 'Name', 'Email', 'Time created', 'Delete', 'Edit'];
    $form['table'] = [
      '#type' => 'tableselect',
      '#header' => $header,
      '#options' => $cats,
      '#empty' => $this->t('Nothing there.'),
    ];
    $form['delete cats'] = [
      '#type' => 'submit',
      '#value' => $this->t('Delete'),
      '#button_type' => 'submit',
      '#attributes' => ['onclick' => 'if(!confirm("Are you sure?")){return false;}'],
    ];
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state):void {
    $values = $form_state->getValue('table');
    $delete = array_filter($values);
    if (empty($delete)) {
      $this->messenger()->addError($this->t("Choose something to delete."));
    }
    else {
      $this->database->delete('evilargest')
        ->condition('id', $delete, 'IN')
        ->execute();
      $this->messenger()->addStatus($this->t("Cats are deleted."));
    }
  }

}
