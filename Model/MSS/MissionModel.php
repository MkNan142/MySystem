<?php
require_once 'Model/Model.php';
class MissionModel extends Model {
  //ST 設定連線 
  function __construct() {
    $this->init('mission_system_singal');
  }
  //ED 設定連線 

  //設定短期任務
  function insShortTermMission($income_data) {
    $stg_name = $income_data['stg_name'];
    $stg_describe = $income_data['stg_describe'];
    $stg_start_time = $income_data['stg_start_time'];
    $stg_end_time = $income_data['stg_end_time'];
    $stg_status = $income_data['stg_status'];

    $sql = "INSERT INTO `short_term_goal`(`stg_name`, `stg_describe`, `stg_start_time`, `stg_end_time`, `stg_status`)
    VALUES (:stg_name,:stg_describe,:stg_start_time,:stg_end_time,:stg_status)";
    $stmt = $this->cont->prepare($sql);
    $status = $stmt->execute(array(
      ':stg_name' => $stg_name, ':stg_describe' => $stg_describe, ':stg_start_time' => $stg_start_time, ':stg_end_time' => $stg_end_time,
      ':stg_status' => $stg_status
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
    
    $sql = "UPDATE `short_term_goal` SET `stg_name`=:stg_name,`stg_describe`=:stg_describe,
    `stg_start_time`=:stg_start_time,`stg_end_time`=:stg_end_time,`stg_status`=:stg_status WHERE stg_id=:stg_id";
    $stmt = $this->cont->prepare($sql);
    $status = $stmt->execute(array(
      ':stg_name' => $stg_name, ':stg_describe' => $stg_describe, ':stg_start_time' => $stg_start_time,
      ':stg_status' => $stg_status, ':stg_end_time' => $stg_end_time, ':stg_id' => $stg_id
    ));

    return $status;
  }
  //取得短期目標清單
  //stg_status 任務狀態,orderby 要排序的欄位名稱,Inverted 排序方式,pageNum 要顯示的頁數
  function getShortTermMission($income_data) {
    //return $income_data;
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

  //設定中期任務

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
  //取得中期目標清單  
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

  //設定長期任務

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
  //取得長期目標清單  
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
