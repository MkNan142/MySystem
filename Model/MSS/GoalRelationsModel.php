<?php
require_once 'Model/Model.php';
class GoalRelationsModel extends Model {
  //ST 設定連線 
  function __construct() {
    $this->init('mission_system_singal');
  }
  //ED 設定連線 

  //任務關聯設定相關
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

    $sqlCount = "SELECT T1.ltg_id as goal_id,T1.ltg_name as goal_name,ltg_start_time as goal_start_time,ltg_end_time as goal_end_time, ltg_status as goal_status,goal_type
                  FROM(
                    SELECT *,'1' as goal_type FROM `long_term_goal` 
                    UNION ALL
                    SELECT *,'2' as goal_type FROM `mid_term_goal` 
                    UNION ALL
                    SELECT `stg_id`, `stg_name`, `stg_describe`, `stg_start_time`, `stg_end_time`, `stg_status`, `stg_create_time`,'3' as goal_type FROM `short_term_goal`) as T1
                  WHERE " . $sqlWhere . " ";

    /*$sqlCount = "SELECT T1.ltg_id as goal_id,T1.ltg_name as goal_name,ltg_start_time as goal_start_time,ltg_end_time as goal_end_time, ltg_status as goal_status,goal_type
                   FROM(
                    SELECT *,'1' as goal_type 
                      FROM `long_term_goal` S1 
                        LEFT JOIN goal_relation S2 on S1.ltg_id=S2.gr_main_goal and S2.gr_relation_type='1' 
                      WHERE S2.gr_id is Null
                    UNION ALL
                    SELECT *,'2' as goal_type 
                      FROM `mid_term_goal` S1 
                        LEFT JOIN goal_relation S2 on (S1.mtg_id=S2.gr_main_goal and S2.gr_relation_type='2') OR (S1.mtg_id=S2.gr_sub_goal and S2.gr_relation_type='1') 
                      WHERE S2.gr_id is Null
                    UNION ALL
                    SELECT *,'3' as goal_type 
                      FROM `short_term_goal` S1 
                        LEFT JOIN goal_relation S2 on (S1.stg_id=S2.gr_main_goal and S2.gr_relation_type='3') OR (S1.stg_id=S2.gr_sub_goal and S2.gr_relation_type='2') 
                      WHERE S2.gr_id is Null ) as T1
                    WHERE " . $sqlWhere . " ";*/
    $stmtCount = $this->cont->prepare($sqlCount);
    $status[] = $stmtCount->execute();
    $rowcount = $stmtCount->rowCount();

    $sql = "SELECT T1.ltg_id as goal_id,T1.ltg_name as goal_name,ltg_start_time as goal_start_time,ltg_end_time as goal_end_time, ltg_status as goal_status,goal_type
            FROM(
              SELECT *,'1' as goal_type FROM `long_term_goal` 
              UNION ALL
              SELECT *,'2' as goal_type FROM `mid_term_goal` 
              UNION ALL
              SELECT `stg_id`, `stg_name`, `stg_describe`, `stg_start_time`, `stg_end_time`, `stg_status`, `stg_create_time`,'3' as goal_type FROM `short_term_goal` ) as T1
            WHERE " . $sqlWhere . " 
            ORDER BY $orderby $Inverted,ltg_id $Inverted 
            limit $firstData,10";
    /*$sql = "SELECT T1.ltg_id as goal_id,T1.ltg_name as goal_name,ltg_start_time as goal_start_time,ltg_end_time as goal_end_time, ltg_status as goal_status,goal_type
            FROM(
              SELECT *,'1' as goal_type 
                FROM `long_term_goal` S1 
                  LEFT JOIN goal_relation S2 on S1.ltg_id=S2.gr_main_goal and S2.gr_relation_type='1' 
                WHERE S2.gr_id is Null
              UNION ALL
              SELECT *,'2' as goal_type 
                FROM `mid_term_goal` S1 
                  LEFT JOIN goal_relation S2 on (S1.mtg_id=S2.gr_main_goal and S2.gr_relation_type='2') OR (S1.mtg_id=S2.gr_sub_goal and S2.gr_relation_type='1') 
                WHERE S2.gr_id is Null
              UNION ALL
              SELECT *,'3' as goal_type 
                FROM `short_term_goal` S1 
                  LEFT JOIN goal_relation S2 on (S1.stg_id=S2.gr_main_goal and S2.gr_relation_type='3') OR (S1.stg_id=S2.gr_sub_goal and S2.gr_relation_type='2') 
                WHERE S2.gr_id is Null ) as T1
            WHERE " . $sqlWhere . " 
            ORDER BY $orderby $Inverted,ltg_id $Inverted 
            limit $firstData,10";*/
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
      $sql_upper_goal = "SELECT T1.* ,T0.gr_id
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
      $sql_lower_goal = "SELECT T1.* ,T0.gr_id
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

  function delGoalRelationsByID($income_data) {
    $gr_id = $income_data['gr_id'];
    $sqlWhere = "gr_id = '" . $gr_id . "'";

    $sql = "DELETE FROM `goal_relation` WHERE " . $sqlWhere . "";
    //$row = $sql;
    $stmt = $this->cont->prepare($sql);
    $status[] = $stmt->execute();
    return $status;
  }
  function addGoalRelations($income_data) {
    $gr_main_goal = $income_data['gr_main_goal'];
    $gr_sub_goal = $income_data['gr_sub_goal'];
    $gr_relation_type = $income_data['gr_relation_type'];

    $sql = "INSERT INTO `goal_relation`(`gr_main_goal`, `gr_sub_goal`, `gr_relation_type`)
    VALUES (:gr_main_goal,:gr_sub_goal,:gr_relation_type)";
    $stmt = $this->cont->prepare($sql);
    $status[] = $stmt->execute(array(
      ':gr_main_goal' => $gr_main_goal, ':gr_sub_goal' => $gr_sub_goal, ':gr_relation_type' => $gr_relation_type
    ));

    return $status;
  }

  function showRelationExpandableTable($income_data) {
    //return $income_data;
    $goal_type = $income_data['goal_type'];
    $goal_id = $income_data['goal_id'];
    $sqlWhere = ' 1=1 ';
    if ($goal_type == '0' && $goal_id == '0') {
      $sql = "SELECT * 
              FROM `long_term_goal` T0 
                LEFT JOIN goal_relation T1 ON T0.ltg_id=T1.gr_main_goal AND T1.gr_relation_type=1
                LEFT JOIN mid_term_goal T2 ON T1.gr_sub_goal=T2.mtg_id
                LEFT JOIN goal_relation T3 ON T2.mtg_id=T3.gr_main_goal AND T3.gr_relation_type=2
                LEFT JOIN short_term_goal T4 ON T3.gr_sub_goal=T4.stg_id ";
    } else {
      switch ($goal_type) {
        case '1':
          $sql = "SELECT * 
              FROM `long_term_goal` T0 
                LEFT JOIN goal_relation T1 ON T0.ltg_id=T1.gr_main_goal AND T1.gr_relation_type=1
                LEFT JOIN mid_term_goal T2 ON T1.gr_sub_goal=T2.mtg_id
                LEFT JOIN goal_relation T3 ON T2.mtg_id=T3.gr_main_goal AND T3.gr_relation_type=2
                LEFT JOIN short_term_goal T4 ON T3.gr_sub_goal=T4.stg_id 
              WHERE T0.ltg_id='" . $goal_id . "' ";
          break;
        case '2':
          $sql = "SELECT * 
              FROM `mid_term_goal` T0 
                LEFT JOIN goal_relation T1 ON T0.mtg_id=T1.gr_sub_goal AND T1.gr_relation_type=1
                LEFT JOIN long_term_goal T2 ON T1.gr_main_goal=T2.ltg_id
                LEFT JOIN goal_relation T3 ON T0.mtg_id=T3.gr_main_goal AND T3.gr_relation_type=2
                LEFT JOIN short_term_goal T4 ON T3.gr_sub_goal=T4.stg_id 
              WHERE T0.mtg_id='" . $goal_id . "' ";
          break;
        case '3':
          $sql = "SELECT * 
              FROM `short_term_goal` T0 
                LEFT JOIN goal_relation T1 ON T0.stg_id=T1.gr_sub_goal AND T1.gr_relation_type=2
                LEFT JOIN mid_term_goal T2 ON T1.gr_main_goal=T2.mtg_id
                LEFT JOIN goal_relation T3 ON T2.mtg_id=T3.gr_sub_goal AND T3.gr_relation_type=1
                LEFT JOIN long_term_goal T4 ON T3.gr_main_goal=T4.ltg_id 
              WHERE T0.stg_id='" . $goal_id . "' ";
          break;
      }
    }
    $sql .= " Order by ltg_id,mtg_id,stg_id ";

    $stmt = $this->cont->prepare($sql);
    $status[] = $stmt->execute();
    $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $data['row'] = $row;
    return $data;
  }
}
