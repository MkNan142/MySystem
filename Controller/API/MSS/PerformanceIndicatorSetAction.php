<?php

class PerformanceIndicatorSetAction implements actionPerformed {

  public function actionPerformed($event) {
    $doMissionAction = $_POST["doMissionAction"];

    require_once 'Model/MSS/PerformanceIndicatorSetModel.php';
    $PerformanceIndicatorSetModel = new PerformanceIndicatorSetModel();

    switch ($doMissionAction) {


        //績效指標設定相關
      case 'getPerformanceIndicator':
        $returnData = $PerformanceIndicatorSetModel->getPerformanceIndicator($_POST["data"]);
        break;
      case 'insPerformanceIndicator':
        $returnData = $PerformanceIndicatorSetModel->insPerformanceIndicator($_POST["data"]);
        break;
      case 'updPerformanceIndicator':
        $returnData = $PerformanceIndicatorSetModel->updPerformanceIndicator($_POST["data"]);
        break;
      case 'getPerformanceIndicatorByID':
        $returnData = $PerformanceIndicatorSetModel->getPerformanceIndicatorByID($_POST["data"]);
        break;
      case 'delPerformanceIndicatorByID':
        $returnData = $PerformanceIndicatorSetModel->delPerformanceIndicatorByID($_POST["data"]);
        break;
    }
    echo json_encode($returnData, true);
  }
}
