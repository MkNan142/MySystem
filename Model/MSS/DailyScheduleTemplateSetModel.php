<?php
require_once 'Model/Model.php';
class DailyScheduleTemplateSetModel extends Model {
  //ST 設定連線 
  function __construct() {
    $this->init('mission_system_singal');
  }
  //ED 設定連線 

  function getDailyScheduleTemplate($income_data) {
    $orderby = $income_data['orderby'];
    $Inverted = $income_data['Inverted'];
    $pageNum = $income_data['pageNum'];
    $sqlWhere = ' 1=1 ';

    //$status = $sqlWhere;
    $firstData = ($pageNum - 1) * 10;
    $sqlCount = "SELECT * FROM `daily_schedule_template` WHERE " . $sqlWhere . " ";
    $stmtCount = $this->cont->prepare($sqlCount);
    //return $sqlCount;
    $status[] = $stmtCount->execute();
    $rowcount = $stmtCount->rowCount();
    $sql = "SELECT * FROM `daily_schedule_template` WHERE " . $sqlWhere . " 
    ORDER BY dst_order_number $Inverted limit $firstData,10";


    $stmt = $this->cont->prepare($sql);
    $status[] = $stmt->execute();
    $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $data['sql'] = $sql;
    $data['row'] = $row;
    $data['rowcount'] = $rowcount;
    return $data;
  }

  // `dst_id`, `dst_name`, `dst_default_goal_relation`, `dst_default_duration`, `dst_default_color`, `dst_order_number`
  function insDailyScheduleTemplate($income_data) {
    $dst_name = $income_data['dst_name'];
    $dst_default_goal_relation = $income_data['dst_default_goal_relation'];
    $dst_default_duration = $income_data['dst_default_duration'];
    $dst_default_color = $income_data['dst_default_color'];
    $dst_order_number = $income_data['dst_order_number'];
    if ($dst_order_number == '') {
      $dst_order_number = null;
    }


    $sql = "INSERT INTO `daily_schedule_template`( `dst_name`, `dst_default_goal_relation`, `dst_default_duration`,dst_default_color,dst_order_number)
    VALUES (:dst_name,:dst_default_goal_relation,:dst_default_duration,:dst_default_color,:dst_order_number)";
    $stmt = $this->cont->prepare($sql);
    $status[] = $stmt->execute(array(
      ':dst_name' => $dst_name,
      ':dst_default_goal_relation' => $dst_default_goal_relation,
      ':dst_default_duration' => $dst_default_duration,
      ':dst_default_color' => $dst_default_color,
      ':dst_order_number' => $dst_order_number
    ));
    if ($dst_order_number == null) {
      $LAST_ID = $this->cont->lastInsertId();

      $sql_upd = "UPDATE `daily_schedule_template` SET `dst_order_number`=:dst_order_number WHERE dst_id=:dst_order_number";
      $stmt_upd = $this->cont->prepare($sql_upd);
      $status[] = $stmt_upd->execute(array(
        ':dst_order_number' => $LAST_ID
      ));
    }

    return $status;
  }
  function updDailyScheduleTemplate($income_data) {
    $dst_id = $income_data['dst_id'];
    $dst_name = $income_data['dst_name'];
    $dst_default_goal_relation = $income_data['dst_default_goal_relation'];
    $dst_default_duration = $income_data['dst_default_duration'];
    $dst_default_color = $income_data['dst_default_color'];
    $dst_order_number = $income_data['dst_order_number'];
    if ($dst_order_number == '') {
      $dst_order_number = $dst_id;
    }

    $sql = "UPDATE `daily_schedule_template` SET `dst_name`=:dst_name,`dst_default_goal_relation`=:dst_default_goal_relation,
    `dst_default_duration`=:dst_default_duration,`dst_default_color`=:dst_default_color,dst_order_number=:dst_order_number WHERE dst_id=:dst_id";
    $stmt = $this->cont->prepare($sql);
    $status = $stmt->execute(array(
      ':dst_name' => $dst_name,
      ':dst_default_goal_relation' => $dst_default_goal_relation,
      ':dst_default_duration' => $dst_default_duration,
      ':dst_default_color' => $dst_default_color,
      ':dst_order_number' => $dst_order_number,
      ':dst_id' => $dst_id
    ));

    return $status;
  }
  function getDailyScheduleTemplateByID($income_data) {
    $dst_id = $income_data['dst_id'];
    $sqlWhere = "dst_id = '" . $dst_id . "'";

    $sql = "SELECT * FROM `daily_schedule_template` WHERE " . $sqlWhere . "";
    //$row = $sql;
    $stmt = $this->cont->prepare($sql);
    $status[] = $stmt->execute();
    $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $data['row'] = $row;
    return $data;
  }
  function delDailyScheduleTemplateByID($income_data) {
    $dst_id = $income_data['dst_id'];
    $sql = "DELETE FROM `daily_schedule_template`
            WHERE dst_id=:dst_id";
    $stmt = $this->cont->prepare($sql);
    $status = $stmt->execute(array(
      ':dst_id' => $dst_id
    ));
    return $status;
  }
}
