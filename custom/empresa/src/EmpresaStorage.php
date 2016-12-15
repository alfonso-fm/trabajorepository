<?php

namespace Drupal\empresa;

class EmpresaStorage {

  static function getHeader(){
    return array(
      'rfc'            => t('R.F.C'),
      'Nombre'         => t('Nombre'),
      //'Descripcion'    => t('Descripción'),
      'URLPagina'      => t('Página'),
      //'Logo'           => t('Logo'),
      'MostrarEnFeria' => t('Mostrar en Feria'),
      'Habilitado'     => t('Habilitado'),
      'Actions'        => t('Acciones'),
    );
  }

  static function getAll() {
    $result = db_query('SELECT * FROM {EMPRESAS}');
	  return $result;
  }

  static function exists($rfc) {
    $result = db_query('SELECT 1 FROM {EMPRESAS} WHERE RFC = :rfc', array(':rfc' => $rfc))->fetchField();
    return (bool) $result;
  }

  static function add($RFC, $IdUsuario,$IdRamo, $IdUsuario,$RFC,
                      $Nombre,$Descripcion, $URLPagina,
                      $Logo,$Habilitado, $MostrarEnFeria) {
    db_insert('EMPRESAS')->fields(array(
      'RFC'            => $RFC,
      'IdUsuario'      => $IdUsuario,
      'IdRamo'         => $IdRamo,
      'Nombre'         => $Nombre,
      'Descripcion'    => $Descripcion,
      'URLPagina'      => $URLPagina,
      'Logo'           => $Logo,
      'Habilitado'     => $Habilitado,
      'MostrarEnFeria' => $MostrarEnFeria,
	))->execute();
  }

  static function delete($rfc) {
    echo($rfc);
    db_delete('EMPRESAS')->condition('rfc', $rfc)->execute();
  }
}