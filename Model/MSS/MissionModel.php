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


  //取得未關聯過的短中長期目標清單  
  function getUnconnectedGoal($income_data) {
    //return $income_data;
    $goal_type = $income_data['goal_type'];
    $orderby = $income_data['orderby'];
    $Inverted = $income_data['Inverted'];
    $pageNum = $income_data['pageNum'];
    $sqlWhere = ' 1=1 ';

    if ($goal_type != '') {
      if ($sqlWhere != '') {
        $sqlWhere .= ' and ';
      }
      $sqlWhere .= " goal_type= '" . $goal_type . "'";
    }

    $firstData = ($pageNum - 1) * 10;

    $sqlCount = "SELECT A.ltg_id as goal_id,A.ltg_name as goal_name,ltg_start_time as goal_start_time,ltg_end_time as goal_end_time, ltg_status as goal_status,goal_type
                  FROM(
                    SELECT *,'1' as goal_type FROM `long_term_goal` 
                    UNION ALL
                    SELECT *,'2' as goal_type FROM `mid_term_goal` 
                    UNION ALL
                    SELECT *,'3' as goal_type FROM `short_term_goal` ) as A 
                  WHERE " . $sqlWhere . " ";
    $stmtCount = $this->cont->prepare($sqlCount);
    $status[] = $stmtCount->execute();
    $rowcount = $stmtCount->rowCount();

    $sql = "SELECT A.ltg_id as goal_id,A.ltg_name as goal_name,ltg_start_time as goal_start_time,ltg_end_time as goal_end_time, ltg_status as goal_status,goal_type
            FROM(
              SELECT *,'1' as goal_type FROM `long_term_goal` 
              UNION ALL
              SELECT *,'2' as goal_type FROM `mid_term_goal` 
              UNION ALL
              SELECT *,'3' as goal_type FROM `short_term_goal` ) as A 
            WHERE " . $sqlWhere . " 
            ORDER BY $orderby $Inverted,ltg_id $Inverted 
            limit $firstData,10";
    $stmt = $this->cont->prepare($sql);
    $status[] = $stmt->execute();
    $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $data['row'] = $row;
    $data['rowcount'] = $rowcount;
    return $data;
  }
  //取得目標的詳細內容與關連清單
  function getRelationDetailByID($income_data) {
    $goal_type = $income_data['goal_type'];
    $goal_id = $income_data['goal_id'];
    switch ($goal_type) {
      case '1':
        $main_table_name = 'long_term_goal';
        $main_table_abbr = 'ltg';
        $upper_relation_type = '';
        $lower_relation_type = '1';
        $lower_table_name = 'mid_term_goal';
        $lower_table_abbr = 'mtg';
        break;
      case '2':
        $main_table_name = 'mid_term_goal';
        $main_table_abbr = 'mtg';
        $upper_relation_type = '1';
        $upper_table_name = 'long_term_goal';
        $upper_table_abbr = 'ltg';
        $lower_relation_type = '2';
        $lower_table_name = 'short_term_goal';
        $lower_table_abbr = 'stg';
        break;
      case '3':
        $main_table_name = 'short_term_goal';
        $main_table_abbr = 'stg';
        $upper_relation_type = '2';
        $upper_table_name = 'mid_term_goal';
        $upper_table_abbr = 'mtg';
        $lower_relation_type = '';
        break;
    }
    $sqlWhere_main_goal = $main_table_abbr . "_id = '" . $goal_id . "'";
    //查詢目標的詳細資料
    $sql_main_goal = "SELECT * FROM " . $main_table_name . " WHERE " . $sqlWhere_main_goal . "";
    $stmt_main_goal = $this->cont->prepare($sql_main_goal);
    $status[] = $stmt_main_goal->execute();
    $row_main_goal = $stmt_main_goal->fetchAll(PDO::FETCH_ASSOC);
    $data['sql_main_goal'] = $sql_main_goal;
    $data['row_main_goal'] = $row_main_goal;

    //查詢上層關聯的目標
    if ($upper_relation_type != '') {
      $sqlWhere_upper_goal = " gr_relation_type ='" . $upper_relation_type . "' and gr_sub_goal ='" . $goal_id . "' ";
      $sql_upper_goal = "SELECT T1.* 
                          FROM goal_relation T0 left join " . $upper_table_name . " T1 on T0.gr_main_goal =T1." . $upper_table_abbr . "_id and T0.gr_relation_type=" . $upper_relation_type . "
                          WHERE " . $sqlWhere_upper_goal . "";
      $stmt_upper_goal = $this->cont->prepare($sql_upper_goal);
      $status[] = $stmt_upper_goal->execute();
      $row_upper_goal = $stmt_upper_goal->fetchAll(PDO::FETCH_ASSOC);
      $data['sql_upper_goal'] = $sql_upper_goal;
      $data['row_upper_goal'] = $row_upper_goal;
    }
    //查詢下層關聯的目標
    if ($lower_relation_type != '') {
      $sqlWhere_lower_goal = " gr_relation_type ='" . $lower_relation_type . "' and gr_main_goal ='" . $goal_id . "' ";
      $sql_lower_goal = "SELECT T1.* 
                          FROM goal_relation T0 left join " . $lower_table_name . " T1 on T0.gr_sub_goal =T1." . $lower_table_abbr . "_id and T0.gr_relation_type=" . $lower_relation_type . "
                          WHERE " . $sqlWhere_lower_goal . "";
      $stmt_lower_goal = $this->cont->prepare($sql_lower_goal);
      $status[] = $stmt_lower_goal->execute();
      $row_lower_goal = $stmt_lower_goal->fetchAll(PDO::FETCH_ASSOC);
      $data['sql_lower_goal'] = $sql_lower_goal;
      $data['row_lower_goal'] = $row_lower_goal;
    }

    return $data;
  }

  function getUnconnectedRelationListByID($income_data) {
    //return $income_data;
    $add_level = $income_data['add_level'];
    $goal_id = $income_data['goal_id'];
    $goal_type = $income_data['goal_type'];
    // $orderby = $income_data['orderby'];
    // $Inverted = $income_data['Inverted'];
    //$pageNum = $income_data['pageNum'];
    $sqlWhere = ' 1=1 ';

    switch ($goal_type) {
      case '1':
        $upper_relation_type = '';
        $lower_relation_type = '1';
        $upper_table_name = '';
        $upper_table_abbr = '';
        $lower_table_name = 'mid_term_goal';
        $lower_table_abbr = 'mtg';
        break;
      case '2':
        $upper_relation_type = '1';
        $lower_relation_type = '2';
        $upper_table_name = 'long_term_goal';
        $upper_table_abbr = 'ltg';
        $lower_table_name = 'short_term_goal';
        $lower_table_abbr = 'stg';
        break;
      case '3':
        $upper_relation_type = '2';
        $lower_relation_type = '';
        $upper_table_name = 'mid_term_goal';
        $upper_table_abbr = 'mtg';
        $lower_table_name = '';
        $lower_table_abbr = '';
        break;
      case '4':
        $upper_relation_type = '';
        $lower_relation_type = '';
        $upper_table_name = 'short_term_goal';
        $upper_table_abbr = 'stg';
        $lower_table_name = '';
        $lower_table_abbr = '';
        break;
    }
    switch ($add_level) {
      case 'lower':
        $gr_table_name = $lower_table_name;
        $gr_table_abbr = $lower_table_abbr;
        $gr_relation_type = $lower_relation_type;
        $gr_unconnect_goal = 'gr_sub_goal';
        $gr_main_goal = 'gr_main_goal';


        break;
      case 'upper':
        $gr_table_name = $upper_table_name;
        $gr_table_abbr = $upper_table_abbr;
        $gr_relation_type = $upper_relation_type;
        $gr_unconnect_goal = 'gr_main_goal';
        $gr_main_goal = 'gr_main_goal';
        break;
    }

    $sqlWhere .= " goal_type= '" . $goal_type . "'";
    if ($gr_relation_type != '') {
      $sql = "SELECT *
            FROM  " . $gr_table_name . "  
            WHERE " . $gr_table_abbr . "_id NOT IN (SELECT " . $gr_unconnect_goal . " FROM goal_relation WHERE gr_relation_type=" . $gr_relation_type . " and " . $gr_main_goal . "=" . $goal_id . ")
            ";
      $stmt = $this->cont->prepare($sql);
      $status[] = $stmt->execute();
      $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
      $row = [];
    }
    //$data['sql'] = $sql;
    $data['row'] = $row;
    return $data;
  }
}
