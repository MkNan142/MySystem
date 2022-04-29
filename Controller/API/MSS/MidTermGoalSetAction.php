<?php

class MidTermGoalSetAction implements actionPerformed {

  public function actionPerformed($event) {
    require_once 'Model/MSS/MidTermGoalSetModel.php';
    $MidTermGoalSetModel = new MidTermGoalSetModel();

    $doMissionAction = $_POST["doMissionAction"];
    switch ($doMissionAction) {

        //中期任務設定相關
        case 'insMidTermMission': //建立中期目標
          $returnData = $_POST["data"];
          $returnData = $MidTermGoalSetModel->insMidTermMission($_POST["data"]);
          break;
        case 'getMidTermMission': //查詢中期目標清單
          $returnData = $MidTermGoalSetModel->getMidTermMission($_POST["data"]);
          break;
        case 'updMidTermMission': //查詢中期目標清單
          $returnData = $MidTermGoalSetModel->updMidTermMission($_POST["data"]);
          break;
        case 'getMidTermMissionByID': //查詢單筆中期目標資料
          $returnData = $MidTermGoalSetModel->getMidTermMissionByID($_POST["data"]);
          break;
        case 'delMidTermMissionByID': //刪除單筆中期目標資料
          $returnData = $MidTermGoalSetModel->delMidTermMissionByID($_POST["data"]);
          break;
    }
    echo json_encode($returnData, true);
  }
}
