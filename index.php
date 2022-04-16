<?php
session_start();
require_once './Event.php';
$Event=new Event($_GET, $_POST);

require_once 'Controller/Controller.php';
$Controller=new Controller($Event);
$Controller->doAction();
?>