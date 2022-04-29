<?php

class ShortTermGoalSetAction implements actionPerformed {

  public function actionPerformed($event) {
    require_once 'Model/MSS/ShortTermGoalSetModel.php';
    $ShortTermGoalSetModel = new ShortTermGoalSetModel();

    $doMissionAction = $_POST["doMissionAction"];
    switch ($doMissionAction) {

        //短期任務設定相關
      case 'insShortTermMission': //建立短期目標
        $returnData = $_POST["data"];
        $returnData = $ShortTermGoalSetModel->insShortTermMission($_POST["data"]);
        break;
      case 'getShortTermMission': //查詢短期目標清單
        $returnData = $ShortTermGoalSetModel->getShortTermMission($_POST["data"]);
        break;
      case 'updShortTermMission': //查詢短期目標清單
        $returnData = $ShortTermGoalSetModel->updShortTermMission($_POST["data"]);
        break;
      case 'getShortTermMissionByID': //查詢單筆短期目標資料
        $returnData = $ShortTermGoalSetModel->getShortTermMissionByID($_POST["data"]);
        break;
      case 'delShortTermMissionByID': //刪除單筆短期目標資料
        $returnData = $ShortTermGoalSetModel->delShortTermMissionByID($_POST["data"]);
        break;
      case 'getPerformanceIndicatorList':
        $returnData = $ShortTermGoalSetModel->getPerformanceIndicatorList($_POST["data"]);
        break;
    }
    echo json_encode($returnData, true);
  }
}
