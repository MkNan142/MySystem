<?php

abstract class Model {

  protected $cont = null;

  public function __construct() {
    $this->init();
  }

  public function init($DB='esunrate') {
  	$db_host = '127.0.0.1';
	  $db_user = 'root';
    $db_name = $DB;
    $db_password = '';
    $dsn = "mysql:host=$db_host;dbname=$db_name;charset=utf8";
    try {
      $this->cont = new PDO($dsn, $db_user, $db_password);
      $this->cont->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $this->cont->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
    } catch (Exception $exc) {
      echo $exc->getTraceAsString();
    }
  }

}
