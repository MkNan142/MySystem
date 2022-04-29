<?php
session_start();
//顯示錯誤報告
error_reporting (E_ALL);
require_once './Event.php';
$Event=new Event($_GET, $_POST);

require_once 'Controller/Controller.php';
$Controller=new Controller($Event);
$Controller->doAction();
?>