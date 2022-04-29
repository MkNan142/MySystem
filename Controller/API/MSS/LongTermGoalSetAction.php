<?php

class LongTermGoalSetAction implements actionPerformed {

  public function actionPerformed($event) {
    require_once 'Model/MSS/LongTermGoalSetModel.php';
    $LongTermGoalSetModel = new LongTermGoalSetModel();

    $doMissionAction = $_POST["doMissionAction"];
    switch ($doMissionAction) {

        //長期任務設定相關
      case 'insLongTermMission': //建立長期目標
        $returnData = $_POST["data"];
        $returnData = $LongTermGoalSetModel->insLongTermMission($_POST["data"]);
        break;
      case 'getLongTermMission': //查詢長期目標清單
        $returnData = $LongTermGoalSetModel->getLongTermMission($_POST["data"]);
        break;
      case 'updLongTermMission': //查詢長期目標清單
        $returnData = $LongTermGoalSetModel->updLongTermMission($_POST["data"]);
        break;
      case 'getLongTermMissionByID': //查詢單筆長期目標資料
        $returnData = $LongTermGoalSetModel->getLongTermMissionByID($_POST["data"]);
        break;
      case 'delLongTermMissionByID': //刪除單筆長期目標資料
        $returnData = $LongTermGoalSetModel->delLongTermMissionByID($_POST["data"]);
        break;

    }
    echo json_encode($returnData, true);
  }
}
