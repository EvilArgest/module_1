<?php

namespace Drupal\evilargest\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Ajax\AjaxResponse;

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
    return $instance;
  }

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
    $form['adding_cat'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Your cat’s name:'),
      '#placeholder' => $this->t('The name must be in range from 2 to 32 symbols...'),
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
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state): void {
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
  }

  /**
   * Submit Ajax.
   */
  public function setMessage(array &$form, FormStateInterface $form_state) : array {
    return $form;
  }

}
