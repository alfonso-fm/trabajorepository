<?php

namespace Drupal\empresa;

use Drupal\Core\Form\ConfirmFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Form\TermInterface;
use Drupal\Core\Url;

class DeleteForm extends ConfirmFormBase {

  protected $rfc;

  function getFormID() {
    return 'TypeOne_delete';
  }

  function getQuestion() {
    return t('¿Estas seguro de borrar la empresa %rfc?', array('%rfc' => $this->rfc));
  }

  function getConfirmText() {
    return t('Delete');
  }

  function getCancelUrl() {
    return new Url('empresa_list');
  }

  function buildForm(array $form, FormStateInterface $form_state, $rfc = NULL) {
    $this->rfc= $rfc;
    return parent::buildForm($form, $form_state);
  }

  function submitForm(array &$form, FormStateInterface $form_state) {
    EmpresaStorage::delete($this->rfc);
    \Drupal::logger('empresa')->notice('Deleted empresa Submission with rfc %rfc.', array('%rfc' => $this->rfc));
    drupal_set_message(t('Empresa submission %rfc has been deleted.', array('%rfc' => $this->rfc)));
    $form_state->setRedirectUrl(Url::fromRoute('empresa_list'));
  }
}