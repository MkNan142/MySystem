<?php
require_once 'Model/Model.php';
class LongTermGoalSetModel extends Model {
  //ST 設定連線 
  function __construct() {
    $this->init('mission_system_singal');
  }
  //ED 設定連線 


  //長期任務設定相關

  function insLongTermMission($income_data) {
    $ltg_name = $income_data['ltg_name'];
    $ltg_describe = $income_data['ltg_describe'];
    $ltg_start_time = $income_data['ltg_start_time'];
    $ltg_end_time = $income_data['ltg_end_time'];
    $ltg_status = $income_data['ltg_status'];

    $sql = "INSERT INTO `long_term_goal`(`ltg_name`, `ltg_describe`, `ltg_start_time`, `ltg_end_time`, `ltg_status`)
    VALUES (:ltg_name,:ltg_describe,:ltg_start_time,:ltg_end_time,:ltg_status)";
    $stmt = $this->cont->prepare($sql);
    $status = $stmt->execute(array(
      ':ltg_name' => $ltg_name, ':ltg_describe' => $ltg_describe, ':ltg_start_time' => $ltg_start_time, ':ltg_end_time' => $ltg_end_time,
      ':ltg_status' => $ltg_status
    ));

    return $status;
  }
  function updLongTermMission($income_data) {
    $ltg_id = $income_data['ltg_id'];
    $ltg_name = $income_data['ltg_name'];
    $ltg_start_time = $income_data['ltg_start_time'];
    $ltg_end_time = $income_data['ltg_end_time'];
    $ltg_status = $income_data['ltg_status'];
    $ltg_describe = $income_data['ltg_describe'];

    $sql = "UPDATE `long_term_goal` SET `ltg_name`=:ltg_name,`ltg_describe`=:ltg_describe,
    `ltg_start_time`=:ltg_start_time,`ltg_end_time`=:ltg_end_time,`ltg_status`=:ltg_status WHERE ltg_id=:ltg_id";
    $stmt = $this->cont->prepare($sql);
    $status = $stmt->execute(array(
      ':ltg_name' => $ltg_name, ':ltg_describe' => $ltg_describe, ':ltg_start_time' => $ltg_start_time,
      ':ltg_status' => $ltg_status, ':ltg_end_time' => $ltg_end_time, ':ltg_id' => $ltg_id
    ));

    return $status;
  }
  function getLongTermMission($income_data) {
    //return $income_data;
    $ltg_status = $income_data['ltg_status'];
    $orderby = $income_data['orderby'];
    $Inverted = $income_data['Inverted'];
    $pageNum = $income_data['pageNum'];
    $sqlWhere = ' 1=1 ';

    if ($ltg_status != '') {
      if ($sqlWhere != '') {
        $sqlWhere .= ' and ';
      }
      $sqlWhere .= " ltg_status= '" . $ltg_status . "'";
    }

    if ($ltg_status != '9') {
      if ($sqlWhere != '') {
        $sqlWhere .= ' and ';
      }
      $sqlWhere .= " ltg_status<> '9'";
    }

    $firstData = ($pageNum - 1) * 10;

    $sqlCount = "SELECT * FROM `long_term_goal` WHERE " . $sqlWhere . " ";
    $stmtCount = $this->cont->prepare($sqlCount);
    $status[] = $stmtCount->execute();
    $rowcount = $stmtCount->rowCount();

    $sql = "SELECT * FROM `long_term_goal` WHERE " . $sqlWhere . " ORDER BY $orderby $Inverted,ltg_id $Inverted limit $firstData,10";
    $stmt = $this->cont->prepare($sql);
    $status[] = $stmt->execute();
    $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $data['row'] = $row;
    $data['rowcount'] = $rowcount;
    return $data;
  }
  function getLongTermMissionByID($income_data) {
    $ltg_id = $income_data['ltg_id'];
    $sqlWhere = "ltg_id = '" . $ltg_id . "'";

    $sql = "SELECT * FROM `long_term_goal` WHERE " . $sqlWhere . "";
    //$row = $sql;
    $stmt = $this->cont->prepare($sql);
    $status[] = $stmt->execute();
    $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $data['row'] = $row;
    return $data;
  }
  function delLongTermMissionByID($income_data) {
    $ltg_id = $income_data['ltg_id'];
    $sqlWhere = "ltg_id = '" . $ltg_id . "'";

    $sql = "UPDATE `long_term_goal` SET `ltg_status`='9' WHERE " . $sqlWhere . "";
    //$row = $sql;
    $stmt = $this->cont->prepare($sql);
    $status[] = $stmt->execute();
    return $status;
  }

}
