<?php

namespace Drupal\bolsa\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Link;
use Drupal\Core\Url;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Drupal\user\Form;

class BolsaController extends ControllerBase {
	public function portada() {
		$login_form = 'Usuario Registrado';
		if (!\Drupal::currentUser()->id()) {
		    $form = $this->formBuilder(); 
		    $login_form = $form->getForm("Drupal\user\Form\UserLoginForm");
		}
	    return array(
	      '#theme'       => 'portada',
	      '#title'       => 'Bolsa de Trabajo',
	      '#description' => '',
	      '#comments'    => '',
	      '#login_form'  => $login_form,
	    );
  	}
}