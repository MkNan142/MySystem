<?php
require_once 'Model/Model.php';
class PerformanceIndicatorSetModel extends Model {
  //ST 設定連線 
  function __construct() {
    $this->init('mission_system_singal');
  }
  //ED 設定連線 

  //績效指標設定相關
  function getPerformanceIndicator($income_data) {
    $pi_name = $income_data['pi_name'];
    $pi_status = $income_data['pi_status'];
    $orderby = $income_data['orderby'];
    $Inverted = $income_data['Inverted'];
    $pageNum = $income_data['pageNum'];
    $sqlWhere = ' 1=1 ';

    if ($pi_name != '') {
      if ($sqlWhere != '') {
        $sqlWhere .= ' and ';
      }
      $sqlWhere .= " pi_name like '%" . $pi_name . "%'";
    }

    if ($sqlWhere != '') {
      $sqlWhere .= ' and ';
    }
    $sqlWhere .= " pi_status = '" . $pi_status . "'";

    //$status = $sqlWhere;
    $firstData = ($pageNum - 1) * 10;
    $sqlCount = "SELECT * FROM `performance_indicator` WHERE " . $sqlWhere . " ";
    $stmtCount = $this->cont->prepare($sqlCount);
    //return $sqlCount;
    $status[] = $stmtCount->execute();
    $rowcount = $stmtCount->rowCount();
    $sql = "SELECT * FROM `performance_indicator` WHERE " . $sqlWhere . " 
    ORDER BY ";
    if ($orderby != '') {
      $sql .= "$orderby $Inverted,";
    }
    $sql .= "pi_id $Inverted limit $firstData,10";


    $stmt = $this->cont->prepare($sql);
    $status[] = $stmt->execute();
    $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $data['sql'] = $sql;
    $data['row'] = $row;
    $data['rowcount'] = $rowcount;
    return $data;
  }
  function insPerformanceIndicator($income_data) {
    $pi_name = $income_data['pi_name'];
    $pi_unit = $income_data['pi_unit'];
    $pi_describe = $income_data['pi_describe'];
    $pi_status = $income_data['pi_status'];

    $sql = "INSERT INTO `performance_indicator`( `pi_name`, `pi_unit`, `pi_describe`,pi_status)
    VALUES (:pi_name,:pi_unit,:pi_describe,:pi_status)";
    $stmt = $this->cont->prepare($sql);
    $status = $stmt->execute(array(
      ':pi_name' => $pi_name, ':pi_unit' => $pi_unit, ':pi_describe' => $pi_describe, ':pi_status' => $pi_status
    ));

    return $status;
  }
  function updPerformanceIndicator($income_data) {
    $pi_id = $income_data['pi_id'];
    $pi_name = $income_data['pi_name'];
    $pi_unit = $income_data['pi_unit'];
    $pi_describe = $income_data['pi_describe'];
    $pi_status = $income_data['pi_status'];

    $sql = "UPDATE `performance_indicator` SET `pi_name`=:pi_name,`pi_unit`=:pi_unit,
    `pi_describe`=:pi_describe,`pi_status`=:pi_status WHERE pi_id=:pi_id";
    $stmt = $this->cont->prepare($sql);
    $status = $stmt->execute(array(
      ':pi_name' => $pi_name, ':pi_unit' => $pi_unit, ':pi_describe' => $pi_describe, ':pi_status' => $pi_status, ':pi_id' => $pi_id
    ));

    return $status;
  }
  function getPerformanceIndicatorByID($income_data) {
    $pi_id = $income_data['pi_id'];
    $sqlWhere = "pi_id = '" . $pi_id . "'";

    $sql = "SELECT * FROM `performance_indicator` WHERE " . $sqlWhere . "";
    //$row = $sql;
    $stmt = $this->cont->prepare($sql);
    $status[] = $stmt->execute();
    $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $data['row'] = $row;
    return $data;
  }
  function delPerformanceIndicatorByID($income_data) {

    $pi_id = $income_data['pi_id'];

    $sql = "UPDATE `performance_indicator` SET `pi_status`='9' WHERE pi_id=:pi_id";
    $stmt = $this->cont->prepare($sql);
    $status = $stmt->execute(array(
      ':pi_id' => $pi_id
    ));

    return $status;
  }
}
