<?php

namespace Drupal\empresa;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class AddForm extends FormBase  {

  function getFormID() {
    return 'empresa_add';
  }

  //:buildForm(array $form, Drupal\Core\Form\FormStateInterface $form_state) 
  function buildForm(array $form, FormStateInterface $form_state) {
    $form['RFC']            = array('#type' => 'textfield', '#title' => t('RFC'),);
    $form['IdUsuario']      = array('#type' => 'textfield', '#title' => t('IdUsuario'),);
    $form['IdRamo']         = array('#type' => 'textfield', '#title' => t('IdRamo'),);
    $form['Nombre']         = array('#type' => 'textfield', '#title' => t('Nombre'),);
    $form['Descripcion']    = array('#type' => 'textfield', '#title' => t('Descripcion'),);
    $form['URLPagina']      = array('#type' => 'textfield', '#title' => t('URLPagina'),);
    $form['Logo']           = array('#type' => 'textfield', '#title' => t('Logo'),);
    $form['Habilitado']     = array('#type' => 'checkbox' , '#title' => t('Habilitado'),);
    $form['MostrarEnFeria'] = array('#type' => 'checkbox' , '#title' => t('MostrarEnFeria'),);

    $form['actions'] = array('#type' => 'actions');
    $form['actions']['submit'] = array(
      '#type' => 'submit',
      '#value' => t('Add'),
    );
    return $form;
  }

  function validateForm(array &$form, FormStateInterface $form_state) {
    /*Nothing to validate on this form*/
  }

  function submitForm(array &$form, FormStateInterface $form_state) {
    $RFC            = $form_state['values']['RFC'];
    $IdUsuario      = $form_state['values']['IdUsuario'];
    $IdRamo         = $form_state['values']['IdRamo'];
    $Nombre         = $form_state['values']['Nombre'];
    $Descripcion    = $form_state['values']['Descripcion'];
    $URLPagina      = $form_state['values']['URLPagina'];
    $Logo           = $form_state['values']['Logo'];
    $Habilitado     = $form_state['values']['Habilitado'];
    $MostrarEnFeria = $form_state['values']['MostrarEnFeria'];
    TypeOneStorage::add(check_plain($name), check_plain($message));
    watchdog('TypeOne', 'TypeOne message from %rfc has been submitted.', array('%rfc' => $RFC));
    drupal_set_message(t('Your message has been submitted'));
    $form_state['redirect'] = 'admin/content/TypeOne';
    return;
  }
}