<?php
require_once 'Model/Model.php';
class MidTermGoalSetModel extends Model {
  //ST 設定連線 
  function __construct() {
    $this->init('mission_system_singal');
  }
  //ED 設定連線 

  //中期任務設定相關

  function insMidTermMission($income_data) {
    $mtg_name = $income_data['mtg_name'];
    $mtg_describe = $income_data['mtg_describe'];
    $mtg_start_time = $income_data['mtg_start_time'];
    $mtg_end_time = $income_data['mtg_end_time'];
    $mtg_status = $income_data['mtg_status'];

    $sql = "INSERT INTO `mid_term_goal`(`mtg_name`, `mtg_describe`, `mtg_start_time`, `mtg_end_time`, `mtg_status`)
    VALUES (:mtg_name,:mtg_describe,:mtg_start_time,:mtg_end_time,:mtg_status)";
    $stmt = $this->cont->prepare($sql);
    $status = $stmt->execute(array(
      ':mtg_name' => $mtg_name, ':mtg_describe' => $mtg_describe, ':mtg_start_time' => $mtg_start_time, ':mtg_end_time' => $mtg_end_time,
      ':mtg_status' => $mtg_status
    ));

    return $status;
  }
  function updMidTermMission($income_data) {
    $mtg_id = $income_data['mtg_id'];
    $mtg_name = $income_data['mtg_name'];
    $mtg_start_time = $income_data['mtg_start_time'];
    $mtg_end_time = $income_data['mtg_end_time'];
    $mtg_status = $income_data['mtg_status'];
    $mtg_describe = $income_data['mtg_describe'];

    $sql = "UPDATE `mid_term_goal` SET `mtg_name`=:mtg_name,`mtg_describe`=:mtg_describe,
    `mtg_start_time`=:mtg_start_time,`mtg_end_time`=:mtg_end_time,`mtg_status`=:mtg_status WHERE mtg_id=:mtg_id";
    $stmt = $this->cont->prepare($sql);
    $status = $stmt->execute(array(
      ':mtg_name' => $mtg_name, ':mtg_describe' => $mtg_describe, ':mtg_start_time' => $mtg_start_time,
      ':mtg_status' => $mtg_status, ':mtg_end_time' => $mtg_end_time, ':mtg_id' => $mtg_id
    ));

    return $status;
  }
  function getMidTermMission($income_data) {
    //return $income_data;
    $mtg_status = $income_data['mtg_status'];
    $orderby = $income_data['orderby'];
    $Inverted = $income_data['Inverted'];
    $pageNum = $income_data['pageNum'];
    $sqlWhere = ' 1=1 ';

    if ($mtg_status != '') {
      if ($sqlWhere != '') {
        $sqlWhere .= ' and ';
      }
      $sqlWhere .= " mtg_status= '" . $mtg_status . "'";
    }

    if ($mtg_status != '9') {
      if ($sqlWhere != '') {
        $sqlWhere .= ' and ';
      }
      $sqlWhere .= " mtg_status<> '9'";
    }

    //$status = $sqlWhere;
    $firstData = ($pageNum - 1) * 10;
    $sqlCount = "SELECT * FROM `mid_term_goal` WHERE " . $sqlWhere . " ";
    $stmtCount = $this->cont->prepare($sqlCount);
    //return $sqlCount;
    $status[] = $stmtCount->execute();
    $rowcount = $stmtCount->rowCount();
    $sql = "SELECT * FROM `mid_term_goal` WHERE " . $sqlWhere . " ORDER BY $orderby $Inverted,mtg_id $Inverted limit $firstData,10";
    //$row = $sql;
    $stmt = $this->cont->prepare($sql);
    $status[] = $stmt->execute();
    $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $data['row'] = $row;
    $data['rowcount'] = $rowcount;
    return $data;
  }
  function getMidTermMissionByID($income_data) {
    $mtg_id = $income_data['mtg_id'];
    $sqlWhere = "mtg_id = '" . $mtg_id . "'";

    $sql = "SELECT * FROM `mid_term_goal` WHERE " . $sqlWhere . "";
    //$row = $sql;
    $stmt = $this->cont->prepare($sql);
    $status[] = $stmt->execute();
    $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $data['row'] = $row;
    return $data;
  }
  function delMidTermMissionByID($income_data) {
    $mtg_id = $income_data['mtg_id'];
    $sqlWhere = "mtg_id = '" . $mtg_id . "'";

    $sql = "UPDATE `mid_term_goal` SET `mtg_status`='9' WHERE " . $sqlWhere . "";
    //$row = $sql;
    $stmt = $this->cont->prepare($sql);
    $status[] = $stmt->execute();
    return $status;
  }
}
