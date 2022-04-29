<?php

class GoalRelationsAction implements actionPerformed {

  public function actionPerformed($event) {
    require_once 'Model/MSS/GoalRelationsModel.php';
    $GoalRelationsModel = new GoalRelationsModel();

    $doMissionAction = $_POST["doMissionAction"];
    switch ($doMissionAction) {

        //任務關聯設定相關
      case 'getUnconnectedGoal': //取得還沒有關聯的短中長期目標清單
        $returnData = $GoalRelationsModel->getUnconnectedGoal($_POST["data"]);
        break;
      case 'getRelationDetailByID':
        $returnData = $GoalRelationsModel->getRelationDetailByID($_POST["data"]);
        break;
      case 'getUnconnectedRelationListByID':
        $returnData = $GoalRelationsModel->getUnconnectedRelationListByID($_POST["data"]);
        break;
      case 'delGoalRelationsByID':
        $returnData = $GoalRelationsModel->delGoalRelationsByID($_POST["data"]);
        break;
      case 'addGoalRelations':
        $returnData = $GoalRelationsModel->addGoalRelations($_POST["data"]);
        break;
      case 'showRelationExpandableTable':
        $returnData = $GoalRelationsModel->showRelationExpandableTable($_POST["data"]);
        break;
    }
    echo json_encode($returnData, true);
  }
}
