<?php
require_once 'Model/Model.php';
class ShortTermGoalSetModel extends Model {
  //ST 設定連線 
  function __construct() {
    $this->init('mission_system_singal');
  }
  //ED 設定連線 

  //短期任務設定相關
  function insShortTermMission($income_data) {
    $stg_name = $income_data['stg_name'];
    $stg_describe = $income_data['stg_describe'];
    $stg_start_time = $income_data['stg_start_time'];
    $stg_end_time = $income_data['stg_end_time'];
    $stg_status = $income_data['stg_status'];
    $stg_performance_relation=$income_data['stg_performance_relation'];

    $sql = "INSERT INTO `short_term_goal`(`stg_name`, `stg_describe`, `stg_start_time`, `stg_end_time`, `stg_status`,`stg_performance_relation`)
    VALUES (:stg_name,:stg_describe,:stg_start_time,:stg_end_time,:stg_status,:stg_performance_relation)";
    $stmt = $this->cont->prepare($sql);
    $status = $stmt->execute(array(
      ':stg_name' => $stg_name, ':stg_describe' => $stg_describe, ':stg_start_time' => $stg_start_time, ':stg_end_time' => $stg_end_time,
      ':stg_status' => $stg_status,':stg_performance_relation' => $stg_performance_relation
    ));

    return $status;
  }
  function updShortTermMission($income_data) {
    $stg_id = $income_data['stg_id'];
    $stg_name = $income_data['stg_name'];
    $stg_start_time = $income_data['stg_start_time'];
    $stg_end_time = $income_data['stg_end_time'];
    $stg_status = $income_data['stg_status'];
    $stg_describe = $income_data['stg_describe'];
    $stg_performance_relation=$income_data['stg_performance_relation'];

    $sql = "UPDATE `short_term_goal` SET `stg_name`=:stg_name,`stg_describe`=:stg_describe,
    `stg_start_time`=:stg_start_time,`stg_end_time`=:stg_end_time,`stg_status`=:stg_status,`stg_performance_relation`=:stg_performance_relation WHERE stg_id=:stg_id";
    $stmt = $this->cont->prepare($sql);
    $status = $stmt->execute(array(
      ':stg_name' => $stg_name, ':stg_describe' => $stg_describe, ':stg_start_time' => $stg_start_time,
      ':stg_status' => $stg_status, ':stg_end_time' => $stg_end_time, ':stg_performance_relation' => $stg_performance_relation, ':stg_id' => $stg_id
    ));

    return $status;
  }
  //取得短期目標清單
  //stg_status 任務狀態,orderby 要排序的欄位名稱,Inverted 排序方式,pageNum 要顯示的頁數
  function getShortTermMission($income_data) {
    $stg_status = $income_data['stg_status'];
    $orderby = $income_data['orderby'];
    $Inverted = $income_data['Inverted'];
    $pageNum = $income_data['pageNum'];
    $sqlWhere = ' 1=1 ';

    if ($stg_status != '') {
      if ($sqlWhere != '') {
        $sqlWhere .= ' and ';
      }
      $sqlWhere .= " stg_status= '" . $stg_status . "'";
    }

    if ($stg_status != '9') {
      if ($sqlWhere != '') {
        $sqlWhere .= ' and ';
      }
      $sqlWhere .= " stg_status<> '9'";
    }

    //$status = $sqlWhere;
    $firstData = ($pageNum - 1) * 10;
    $sqlCount = "SELECT * FROM `short_term_goal` WHERE " . $sqlWhere . " ";
    $stmtCount = $this->cont->prepare($sqlCount);
    //return $sqlCount;
    $status[] = $stmtCount->execute();
    $rowcount = $stmtCount->rowCount();
    $sql = "SELECT * FROM `short_term_goal` WHERE " . $sqlWhere . " ORDER BY $orderby $Inverted,stg_id $Inverted limit $firstData,10";
    //$row = $sql;
    $stmt = $this->cont->prepare($sql);
    $status[] = $stmt->execute();
    $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $data['row'] = $row;
    $data['rowcount'] = $rowcount;
    return $data;
  }
  function getShortTermMissionByID($income_data) {
    $stg_id = $income_data['stg_id'];
    $sqlWhere = "stg_id = '" . $stg_id . "'";

    $sql = "SELECT * FROM `short_term_goal` WHERE " . $sqlWhere . "";
    //$row = $sql;
    $stmt = $this->cont->prepare($sql);
    $status[] = $stmt->execute();
    $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $data['row'] = $row;
    return $data;
  }
  function delShortTermMissionByID($income_data) {
    $stg_id = $income_data['stg_id'];
    $sqlWhere = "stg_id = '" . $stg_id . "'";

    $sql = "UPDATE `short_term_goal` SET `stg_status`='9' WHERE " . $sqlWhere . "";
    //$row = $sql;
    $stmt = $this->cont->prepare($sql);
    $status[] = $stmt->execute();
    return $status;
  }
  function getPerformanceIndicatorList($income_data) {
    $pi_name = $income_data['pi_name'];
    $onckecked = $income_data['onckecked'];

    if ($pi_name == '') {
      $where = " pi_status='0'or pi_status='1' ";
    } else {
      $pi_name = str_replace(' ', '%', $pi_name);
      $where = " pi_name like '%" . $pi_name . "%' ";
    }
    if ($onckecked != '') {
      $where .= " or pi_id in ( " . $onckecked . " )";
    }

    $sql = "SELECT * 
            FROM `performance_indicator` 
            WHERE ".$where." ORDER BY pi_status,pi_id ";
    $stmt = $this->cont->prepare($sql);
    $status[] = $stmt->execute();
    $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $data['row'] = $row;
    $data['sql'] = $sql;
    return $data;
  }
}
