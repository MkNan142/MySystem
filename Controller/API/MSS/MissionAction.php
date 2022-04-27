<?php

class MissionAction implements actionPerformed {

  public function actionPerformed($event) {
    require_once 'Model/MSS/MissionModel.php';
    $MissionModel = new MissionModel();

    $doMissionAction = $_POST["doMissionAction"];
    switch ($doMissionAction) {

        //短期相關
      case 'insShortTermMission': //建立短期目標
        $returnData = $_POST["data"];
        $returnData = $MissionModel->insShortTermMission($_POST["data"]);
        break;
      case 'getShortTermMission': //查詢短期目標清單
        $returnData = $MissionModel->getShortTermMission($_POST["data"]);
        break;
      case 'updShortTermMission': //查詢短期目標清單
        $returnData = $MissionModel->updShortTermMission($_POST["data"]);
        break;
      case 'getShortTermMissionByID': //查詢單筆短期目標資料
        $returnData = $MissionModel->getShortTermMissionByID($_POST["data"]);
        break;
      case 'delShortTermMissionByID': //刪除單筆短期目標資料
        $returnData = $MissionModel->delShortTermMissionByID($_POST["data"]);
        break;

        //中期相關
      case 'insMidTermMission': //建立中期目標
        $returnData = $_POST["data"];
        $returnData = $MissionModel->insMidTermMission($_POST["data"]);
        break;
      case 'getMidTermMission': //查詢中期目標清單
        $returnData = $MissionModel->getMidTermMission($_POST["data"]);
        break;
      case 'updMidTermMission': //查詢中期目標清單
        $returnData = $MissionModel->updMidTermMission($_POST["data"]);
        break;
      case 'getMidTermMissionByID': //查詢單筆中期目標資料
        $returnData = $MissionModel->getMidTermMissionByID($_POST["data"]);
        break;
      case 'delMidTermMissionByID': //刪除單筆中期目標資料
        $returnData = $MissionModel->delMidTermMissionByID($_POST["data"]);
        break;

        //長期相關
      case 'insLongTermMission': //建立長期目標
        $returnData = $_POST["data"];
        $returnData = $MissionModel->insLongTermMission($_POST["data"]);
        break;
      case 'getLongTermMission': //查詢長期目標清單
        $returnData = $MissionModel->getLongTermMission($_POST["data"]);
        break;
      case 'updLongTermMission': //查詢長期目標清單
        $returnData = $MissionModel->updLongTermMission($_POST["data"]);
        break;
      case 'getLongTermMissionByID': //查詢單筆長期目標資料
        $returnData = $MissionModel->getLongTermMissionByID($_POST["data"]);
        break;
      case 'delLongTermMissionByID': //刪除單筆長期目標資料
        $returnData = $MissionModel->delLongTermMissionByID($_POST["data"]);
        break;

        //任務關聯相關
      case 'getUnconnectedGoal': //取得還沒有關聯的短中長期目標清單
        $returnData = $MissionModel->getUnconnectedGoal($_POST["data"]);
        break;
      case 'getRelationDetailByID':
        $returnData = $MissionModel->getRelationDetailByID($_POST["data"]);
        break;
      case 'getUnconnectedRelationListByID':
        $returnData = $MissionModel->getUnconnectedRelationListByID($_POST["data"]);
        break;
      case 'delGoalRelationsByID':
        $returnData = $MissionModel->delGoalRelationsByID($_POST["data"]);
        break;
      case 'addGoalRelations':
        $returnData = $MissionModel->addGoalRelations($_POST["data"]);
        break;
      case 'showRelationExpandableTable':
        $returnData = $MissionModel->showRelationExpandableTable($_POST["data"]);
        break;

        //日曆相關
      case 'getDailyScheduleTemplate':
        $returnData = $MissionModel->getDailyScheduleTemplate();
        break;
      case 'getDailySchedule':
        $returnData = $MissionModel->getDailySchedule($_POST["data"]);
        break;
      case 'getShortTermGoalList':
        $returnData = $MissionModel->getShortTermGoalList($_POST["data"]);
        break;
      case 'setDailyScheduleNewStartEnd':
        $returnData = $MissionModel->setDailyScheduleNewStartEnd($_POST["data"]);
        break;
      case 'addNewEvent':
        $returnData = $MissionModel->addNewEvent($_POST["data"]);
        break;
      case 'getDailyScheduleDetial':
        $returnData = $MissionModel->getDailyScheduleDetial($_POST["data"]);
        break;
      case 'updDailySchedule':
        $returnData = $MissionModel->updDailySchedule($_POST["data"]);
        break;
      case 'delEvent':
        $returnData = $MissionModel->delEvent($_POST["data"]);
        break;
    }
    echo json_encode($returnData, true);
  }
}
