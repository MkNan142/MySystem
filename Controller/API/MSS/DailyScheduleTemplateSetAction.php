<?php

class DailyScheduleTemplateSetAction implements actionPerformed {

  public function actionPerformed($event) {
    $doMissionAction = $_POST["doMissionAction"];

    require_once 'Model/MSS/DailyScheduleTemplateSetModel.php';
    $DailyScheduleTemplateSetModel = new DailyScheduleTemplateSetModel();

    switch ($doMissionAction) {

        //常用的日常目標設定相關
      case 'getDailyScheduleTemplate2':
        $returnData = $DailyScheduleTemplateSetModel->getDailyScheduleTemplate($_POST["data"]);
        break;
      case 'insDailyScheduleTemplate':
        $returnData = $DailyScheduleTemplateSetModel->insDailyScheduleTemplate($_POST["data"]);
        break;
      case 'updDailyScheduleTemplate':
        $returnData = $DailyScheduleTemplateSetModel->updDailyScheduleTemplate($_POST["data"]);
        break;
      case 'getDailyScheduleTemplateByID':
        $returnData = $DailyScheduleTemplateSetModel->getDailyScheduleTemplateByID($_POST["data"]);
        break;
      case 'delDailyScheduleTemplateByID':
        $returnData = $DailyScheduleTemplateSetModel->delDailyScheduleTemplateByID($_POST["data"]);
        break;
    }
    echo json_encode($returnData, true);
  }
}
