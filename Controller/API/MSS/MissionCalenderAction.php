<?php

class MissionCalenderAction implements actionPerformed {

  public function actionPerformed($event) {
    require_once 'Model/MSS/MissionCalenderModel.php';
    $MissionCalenderModel = new MissionCalenderModel();

    $doMissionAction = $_POST["doMissionAction"];
    switch ($doMissionAction) {

        //日曆相關
      case 'getDailyScheduleTemplate':
        $returnData = $MissionCalenderModel->getDailyScheduleTemplate();
        break;
      case 'getDailySchedule':
        $returnData = $MissionCalenderModel->getDailySchedule($_POST["data"]);
        break;
      case 'getShortTermGoalList':
        $returnData = $MissionCalenderModel->getShortTermGoalList($_POST["data"]);
        break;
      case 'setDailyScheduleNewStartEnd':
        $returnData = $MissionCalenderModel->setDailyScheduleNewStartEnd($_POST["data"]);
        break;
      case 'addNewEvent':
        $returnData = $MissionCalenderModel->addNewEvent($_POST["data"]);
        break;
      case 'getDailyScheduleDetial':
        $returnData = $MissionCalenderModel->getDailyScheduleDetial($_POST["data"]);
        break;
      case 'updDailySchedule':
        $returnData = $MissionCalenderModel->updDailySchedule($_POST["data"]);
        break;
      case 'delEvent':
        $returnData = $MissionCalenderModel->delEvent($_POST["data"]);
        break;
      case 'getDailySchedulePerformanceIndicator':
        $returnData = $MissionCalenderModel->getDailySchedulePerformanceIndicator($_POST["data"]);
        break;
    }
    echo json_encode($returnData, true);
  }
}
