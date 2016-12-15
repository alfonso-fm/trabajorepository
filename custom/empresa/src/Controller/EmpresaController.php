<?php

namespace Drupal\empresa\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Link;
use Drupal\Core\Url;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Drupal\empresa\EmpresaStorage;

class EmpresaController extends ControllerBase {
  public function description() {
    // Make our links. First the simple page.
    $page_example_simple_link = Link::createFromRoute($this->t('simple page'), 'empresa_simple')->toString();
    // Now the arguments page.
    $arguments_url = Url::fromRoute('page_example_arguments', array('first' => '23', 'second' => '56'));
    $page_example_arguments_link = Link::fromTextAndUrl($this->t('arguments page'), $arguments_url)->toString();

    // Assemble the markup.
    $build = array(
      '#markup' => $this->t('<p>The Page example module provides two pages, "simple" and "arguments".</p><p>The @simple_link just returns a renderable array for display.</p><p>The @arguments_link takes two arguments and displays them, as in @arguments_url</p>',
        array(
          '@simple_link' => $page_example_simple_link,
          '@arguments_link' => $page_example_arguments_link,
          '@arguments_url' => $arguments_url->toString(),
        )
      ),
    );

    return $build;
  }
  public function simple() {
    return array(
      '#markup' => '<p>' . $this->t('Simple page: The quick brown fox jumps over the lazy dog.') . '</p>',
    );
  }

  public function arguments($first, $second) {
    if (!is_numeric($first) || !is_numeric($second)) {
      throw new AccessDeniedHttpException();
    }

    $list[] = $this->t("First number was @number.", array('@number' => $first));
    $list[] = $this->t("Second number was @number.", array('@number' => $second));
    $list[] = $this->t('The total was @number.', array('@number' => $first + $second));

    $render_array['page_example_arguments'] = array(
      '#theme' => 'item_list',
      '#items' => $list,
      '#title' => $this->t('Argument Information'),
    );
    return $render_array;
  }
  function content() {
    $url = Url::fromRoute('empresa_add');
    $internal_link = \Drupal::l(t('New message'), $url);
    $add_link = '<p>' . $internal_link . '</p>';
    // Table header
    $header = EmpresaStorage::GetHeader(); 
    
    $rows = array();
    
    foreach(EmpresaStorage::getAll() as $rfc=>$content) {
      $rows[] = 
        array(
          'data' => array(
              $content->RFC, 
              $content->Nombre, 
              //$content->Descripcion,
              \Drupal::l($content->URLPagina, Url::fromUri($content->URLPagina)),
              //$content->Logo, 
              $content->MostrarEnFeria, 
              $content->Habilitado, 
              \Drupal::l('Borrar', Url::fromRoute('empresa_delete', array('rfc' => $content->RFC, 'name' => $content->Nombre)))));
    }

    $table = array(
      '#type' => 'table',
      '#header' => $header,
      '#rows' => $rows,
      '#attributes' => array(
        'id' => 'EMPRESAS',
      ),
    );
    
    return array(
      '#markup' => $add_link. drupal_render($table),
    );
  }
  
  function feria() { 
    $header = EmpresaStorage::GetHeader(); 
    $html = '<div class="container-fluid">';
    $i = 0;
    foreach(EmpresaStorage::getAll() as $content) {
      if ($i==0){ $html = $html.'<div class="row">'; }
      $html = $html. 
      '<div class="col-md-4"><img alt="" class="aligncenter rounded" src="'.$content->Logo.'" />
        <h5 class="tighten-height">'.$content->Nombre.'</h5>
        <p><em>Carreras: '.$content->Comment.'</em></p>
        <p>'.$content->Descripcion.
        '<a class="btn custom-btn btn-small btn-very-subtle" href="'.$content->URLPagina.' " target="_blank" title="">Sitio Web</a></p>
      </div>';
      $i++;
      if ($i==3){ 
        $html = $html.'</div>'; 
        $i = 0; 
      }
    }
    $html = $html.'</div>';
    
    return array(
      '#markup' => $html,
    );
  }

  function content2() { 
    $header = EmpresaStorage::GetHeader(); 
 
    $form['contacts'] = array(
      '#type' => 'table',
      '#title' => 'Sample Table',
      '#header' => $header,
    );

    $i = 0;
    foreach(EmpresaStorage::getAll() as $row) {
      $form['contacts'][$i]['rfc']            = array('#type' => 'textfield', '#size' => 13, '#maxlength' => 13, '#value' => $row->RFC,);
      $form['contacts'][$i]['Nombre']         = array('#type' => 'textfield', '#size' => 13, '#maxlength' => 13, '#value' => $row->Nombre,);
      $form['contacts'][$i]['Descripcion']    = array('#type' => 'textfield', '#size' => 13, '#maxlength' => 13, '#value' => $row->Descripcion,);
      $form['contacts'][$i]['URLPagina']      = array('#type' => 'textfield', '#size' => 13, '#maxlength' => 13, '#value' => $row->URLPagina,);
      $form['contacts'][$i]['Logo']           = array('#type' => 'textfield', '#size' => 13, '#maxlength' => 13, '#value' => $row->Logo,);
      $form['contacts'][$i]['Habilitado']     = array('#type' => 'checkbox' ,'#value' => $row->Habilitado,);
      $form['contacts'][$i]['MostrarEnFeria'] = array('#type' => 'checkbox' ,'#value' => $row->MostrarEnFeria,);
      $i++;
    }

    return array(
      '#markup' => drupal_render($form),
    );
  }
  public function content3() {
    return array(
      '#theme'       => 'empresa',
      '#title'       => 'Feria del Empleo 2017 Facultad de Ingeniería',
      '#description' => 'Estas son las empresas y organizaciones que participan como expositores en la Feria del Empleo de la Facultad de Ingeniería.',
      '#comments'    => 'Inauguración: Lunes 10 de abril 12:00 horas. Lunes 10 y Martes 14 de abril horario feria: 10:00 a 17:00 horas',
      '#rows'        => EmpresaStorage::getAll(),
    );
  }
}