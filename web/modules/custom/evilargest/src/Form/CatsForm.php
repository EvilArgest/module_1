<?php

namespace Drupal\evilargest\Form;

use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\file\Entity\File;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Ajax\HtmlCommand;

/**
 * Form for adding cats.
 */
class CatsForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container): CatsForm {
    $instance = parent::create($container);
    $instance->messenger = $container->get('messenger');
    $instance->database = $container->get('database');
    return $instance;
  }

  /**
   * Drupal\Core\Database defenition.
   *
   * @var \Drupal\Core\Database\Connection
   */
  public $database;

  /**
   * {@inheritdoc}
   */
  public function getFormId(): string {
    return 'cats_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state): array {
    $form['#prefix'] = '<div id="wrapper">';
    $form['#suffix'] = '</div>';
    $form['#attached'] = ['library' => ['evilargest/evilagest_library']];
    $form['adding_cat'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Your cat’s name:'),
      '#required' => TRUE,
      '#placeholder' => $this->t('The name must be in range from 2 to 32 symbols...'),
    ];
    $form['email'] = [
      '#type' => 'email',
      '#title' => $this->t('Your email:'),
      '#placeholder' => $this->t('Only English letters, - and _'),
      '#required' => TRUE,
      '#ajax' => [
        'disable-refocus' => TRUE,
        'callback' => '::validateEmailAjax',
        'event' => 'finishedinput',
        'progress' => [
          'type' => 'none',
          'message' => t('Verifying email..'),
        ],
      ],
    ];
    $form['message'] = [
      '#type' => 'markup',
      '#markup' => '<div id ="email_error">&nbsp;</div>',
    ];
    $form['cat_photo'] = [
      '#title' => t('Your cat’s image:'),
      '#description' => $this->t('Cat photo'),
      '#type' => 'managed_file',
      '#size' => 40,
      '#attributes' => [
        'class' => ['.clear_class'],
      ],
      '#required' => TRUE,
      '#upload_location' => 'public://img',
      '#upload_validators' => [
        'file_validate_extensions' => ['png jpg jpeg'],
        'file_validate_size' => [2097152],
      ],
    ];
    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Add cat'),
      '#button_type' => 'primary',
      '#ajax' => [
        'callback' => '::setMessage',
        'wrapper' => 'wrapper',
        'progress' => [
          'type' => 'none',
        ],
      ],
    ];
    return $form;
  }

  /**
   * Dynamic email validation.
   */
  public function validateEmailAjax(array &$form, FormStateInterface $form_state): AjaxResponse {
    $response = new AjaxResponse();
    $regularexp = '/[-_@A-Za-z.]/';
    $line = $form_state->getValue('email');
    $linelength = strlen($line);
    for ($i = 0; $i < $linelength; $i++) {
      if (!preg_match($regularexp, $line[$i])) {
        $response->addCommand(
          new HtmlCommand(
            '#email_error',
            $this->t('You can use only _ - and English letters')
          )
        );
        break;
      }
      $response->addCommand(
        new HtmlCommand(
          '#email_error',
          '&nbsp;',
        )
      );
    }
    return $response;
  }

  /**
   * {@inheritdoc}
   *
   * @throws \Drupal\Core\Entity\EntityStorageException
   * @throws \Exception
   */
  public function submitForm(array &$form, FormStateInterface $form_state): void {
    $file_data = $form_state->getValue(['cat_photo']);
    $file = File::load($file_data[0]);
    if ($file !== NULL) {
      $file->setPermanent();
      $file->save();
      $this->database
        ->insert('evilargest')
        ->fields([
          'name' => $form_state->getValue(['adding_cat']),
          'email' => $form_state->getValue('email'),
          'image' => $form_state->getValue(['cat_photo'])[0],
          'date' => time(),
        ])
        ->execute();
    }
    $this->messenger->addStatus($this->t('Hurray! You added your cat!'));
  }

  /**
   * Form validation.
   */
  public function validateForm(array &$form, FormStateInterface $form_state): void {
    if ((mb_strlen($form_state->getValue('adding_cat')) < 2)) {
      $form_state->setErrorByName(
        'adding_cat',
        $this->t('Your name is less than 2 symbols.'));
    }
    if ((mb_strlen($form_state->getValue('adding_cat')) > 32)) {
      $form_state->setErrorByName(
        'adding_cat',
        $this->t('Your name is longer than 32 symbols.')
      );
    }
    $regularexp = '/[-_@A-Za-z.]/';
    $line = $form_state->getValue('email');
    $linelength = strlen($line);
    for ($i = 0; $i < $linelength; $i++) {
      if (!preg_match($regularexp, $line[$i])) {
        $form_state->setErrorByName('email', 'Your email is not valid');
      }
    }
  }

  /**
   * Submit Ajax.
   */
  public function setMessage(array &$form, FormStateInterface $form_state) : array {
    return $form;
  }

}
