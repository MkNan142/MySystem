<?php

class Controller {

    private $Event = null;

    function __construct($Event) {
        $this->Event = $Event;

        /*$HomeModel=new HomeModel();
        $HomeModel->reflashMissionStatus();*/
    }

    function doAction() {
        require_once 'Controller/actionPerformed.php';
        $get = $this->Event->getGet();
        if (@$get['actionType'] == 'API') {
            $action = $get['action'];
            $subSystem = $get['subSys'];
            require_once 'Controller/API/' . $subSystem . '/' . $action . '.php';
        } else {
            $action='Showpage';
            require_once 'Controller/Showpage.php';
        }

        $actionListener = NULL;
        $actionListener = new $action($this->Event);

        return $actionListener->actionPerformed($this->Event);
    }
}
