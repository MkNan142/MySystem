<?php
require_once 'Model/Model.php';
class MissionCalenderModel extends Model {
  //ST 設定連線 
  function __construct() {
    $this->init('mission_system_singal');
  }
  //ED 設定連線 

  //日曆相關功能
  function getDailyScheduleTemplate() {
    $sql = "SELECT * FROM `daily_schedule_template` ORDER BY dst_order_number,dst_id ";
    $stmt = $this->cont->prepare($sql);
    $status[] = $stmt->execute();
    $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $data['row'] = $row;
    return $data;
  }

  function getDailySchedule($income_data) {
    $start_time = $income_data['start'];
    $end_time = $income_data['end'];

    $sql = "SELECT * 
            FROM `daily_schedule`
            WHERE ds_start_time between :start_time and :end_time
                  or
                  ds_end_time between :start_time and :end_time
                  or
                  :start_time between ds_start_time and ds_end_time
                  ";
    $stmt = $this->cont->prepare($sql);
    $status[] = $stmt->execute(array(
      ':start_time' => $start_time,
      ':end_time' => $end_time
    ));
    $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $data['row'] = $row;
    return $data;
  }
  function getShortTermGoalList($income_data) {
    $start = $income_data['start'];
    $end = $income_data['end'];
    if ($start != '' && $end != '') {
      $sql = "SELECT *, date_add(now(), interval -7 day) as '-7',date_add(now(), interval 7 day) as '+7'
            FROM `short_term_goal` 
            WHERE '" . $start . "' BETWEEN stg_start_time AND stg_end_time
                  OR
                  '" . $end . "' BETWEEN stg_start_time AND stg_end_time
                  OR
                  stg_start_time BETWEEN '" . $start . "' AND '" . $end . "' ";
    } else {
      $sql = "SELECT *, date_add(now(), interval -7 day) as '-7',date_add(now(), interval 7 day) as '+7'
            FROM `short_term_goal` 
            WHERE stg_start_time BETWEEN date_add(now(), interval -7 day) AND date_add(now(), interval 7 day) 
                  OR 
                  stg_end_time BETWEEN date_add(now(), interval -7 day) AND date_add(now(), interval 7 day) 
                  OR 
                  now() BETWEEN stg_start_time AND stg_end_time";
    }
    $stmt = $this->cont->prepare($sql);
    $status[] = $stmt->execute();
    $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $data['row'] = $row;
    return $data;
  }
  function setDailyScheduleNewStartEnd($income_data) {
    $ds_start_time = $income_data['start'];
    $ds_end_time = $income_data['end'];
    $ds_id = $income_data['id'];

    $sql = "UPDATE `daily_schedule` SET `ds_start_time`=:ds_start_time,`ds_end_time`=:ds_end_time WHERE ds_id=:ds_id";
    $stmt = $this->cont->prepare($sql);
    $status = $stmt->execute(array(
      ':ds_start_time' => $ds_start_time,
      ':ds_end_time' => $ds_end_time,
      ':ds_id' => $ds_id
    ));

    return $status;
  }
  function addNewEvent($income_data) {

    $ds_name = $income_data['name'];
    $ds_start_time = $income_data['start'];
    $ds_end_time = $income_data['end'];
    $ds_goal_relation = $income_data['goal_relation'];
    $ds_color = $income_data['hex_color'];

    $sql_goal_relation_check = "SELECT * FROM `short_term_goal` 
                                WHERE stg_id in (" . $ds_goal_relation . ") 
                                and '" . $ds_start_time . "' not between stg_start_time and stg_end_time
                                and '" . $ds_end_time . "' not between stg_start_time and stg_end_time
                                and stg_start_time not between '" . $ds_start_time . "' and '" . $ds_end_time . "'";
    $stmt = $this->cont->prepare($sql_goal_relation_check);
    $status[] = $stmt->execute();
    $rowCount = $stmt->rowCount();
    if ($rowCount > 0) {
      $data['warn'] = true;
    } else {
      $data['warn'] = false;
    }

    $sql = "INSERT INTO `daily_schedule`(`ds_name`, `ds_start_time`, `ds_end_time`, `ds_status`, `ds_goal_relation`, `ds_color`) 
            VALUES (:ds_name, :ds_start_time, :ds_end_time, :ds_status, :ds_goal_relation, :ds_color)";
    $stmt = $this->cont->prepare($sql);
    $status[] = $stmt->execute(array(
      ':ds_name' => $ds_name,
      ':ds_start_time' => $ds_start_time,
      ':ds_end_time' => $ds_end_time,
      ':ds_status' => '1',
      ':ds_goal_relation' => $ds_goal_relation,
      ':ds_color' => $ds_color
    ));
    $data['LAST_ID'] = $this->cont->lastInsertId();


    return $data;
  }
  function getDailyScheduleDetial($income_data) {
    $ds_id = $income_data['publicId'];
    $sql = "SELECT * 
            FROM `daily_schedule`
            WHERE ds_id=:ds_id";
    $stmt = $this->cont->prepare($sql);
    $status[] = $stmt->execute(array(
      ':ds_id' => $ds_id
    ));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $data['row'] = $row;
    return $data;
  }
  function updDailySchedule($income_data) {

    $edit_field_arr = array(
      'ds_name', 'ds_start_time', 'ds_end_time', 'ds_goal_relation', 'ds_status', 'ds_color'
    );
    $ds_id = $income_data['ds_id'];
    $ds_name = $income_data['ds_name'];
    $ds_start_time = $income_data['ds_start_time'];
    $ds_end_time = $income_data['ds_end_time'];
    $ds_goal_relation = $income_data['ds_goal_relation'];
    $ds_status = $income_data['ds_status'];
    $ds_color = $income_data['ds_color'];
    $ds_execution_start_time = null;
    $ds_execution_end_time = null;
    if ($ds_status == '5') {
      $ds_execution_start_time = $income_data['ds_execution_start_time'];
      $ds_execution_end_time = $income_data['ds_execution_end_time'];
      $performance_indicator_record_list = explode(',', $income_data['performance_indicator_record_list']);
      $performance_indicator_record_value = $income_data['performance_indicator_record_value'];
    }
    $this->cont->beginTransaction();
    try {
      $sql = "UPDATE `daily_schedule` 
            SET `ds_name`=:ds_name,
                `ds_start_time`=:ds_start_time,
                `ds_end_time`=:ds_end_time,
                `ds_goal_relation`=:ds_goal_relation,
                `ds_status`=:ds_status,
                `ds_color`=:ds_color,
                `ds_execution_start_time`=:ds_execution_start_time,
                `ds_execution_end_time`=:ds_execution_end_time
            WHERE ds_id=:ds_id";
      $stmt = $this->cont->prepare($sql);
      $status[] = $stmt->execute(array(
        ':ds_name' => $ds_name,
        ':ds_start_time' => $ds_start_time,
        ':ds_end_time' => $ds_end_time,
        ':ds_goal_relation' => $ds_goal_relation,
        ':ds_status' => $ds_status,
        ':ds_color' => $ds_color,
        ':ds_execution_start_time' => $ds_execution_start_time,
        ':ds_execution_end_time' => $ds_execution_end_time,
        ':ds_id' => $ds_id
      ));
      if ($ds_status == '5') {
        foreach ($performance_indicator_record_list as $k => $v) {
          $sql_ins = "INSERT INTO `performance_indicator_record`(`pir_ds_id`, `pir_pi_id`, `pir_value`) VALUES (:pir_ds_id, :pir_pi_id, :pir_value) ";
          $stmt_ins = $this->cont->prepare($sql_ins);
          $status[] = $stmt_ins->execute(array(
            ':pir_ds_id' => $ds_id,
            ':pir_pi_id' => $v,
            ':pir_value' => $performance_indicator_record_value[$v]
          ));
        }
      }
      $this->cont->commit();
    } catch (PDOException $e) {
      $this->cont->rollback();
      exit;
    }
    return $status;
  }
  function delEvent($income_data) {
    $ds_id = $income_data['ds_id'];
    $sql = "DELETE FROM `daily_schedule`
            WHERE ds_id=:ds_id";
    $stmt = $this->cont->prepare($sql);
    $status = $stmt->execute(array(
      ':ds_id' => $ds_id
    ));
    return $status;
  }
  function getDailySchedulePerformanceIndicator($income_data) {
    $ds_id = $income_data['ds_id'];

    $sql_ds_goal_relation = "SELECT T2.ds_goal_relation 
                              FROM `daily_schedule` T2
                              WHERE T2.ds_id=:ds_id";
    $stmt_ds_goal_relation = $this->cont->prepare($sql_ds_goal_relation);
    $status[] = $stmt_ds_goal_relation->execute(array(
      ':ds_id' => $ds_id
    ));
    $row_ds_goal_relation = $stmt_ds_goal_relation->fetch(PDO::FETCH_ASSOC);

    $sql_stg_id = "SELECT T1.stg_id 
                    FROM `short_term_goal` T1
                    WHERE T1.stg_id IN (" . $row_ds_goal_relation['ds_goal_relation'] . ")";
    $stmt_stg_id = $this->cont->prepare($sql_stg_id);
    $status[] = $stmt_stg_id->execute();
    $row_stg_id = $stmt_stg_id->fetchAll(PDO::FETCH_ASSOC);
    $stg_id_string = '';
    foreach ($row_stg_id as $k => $v) {
      if ($stg_id_string != '') {
        $stg_id_string .= ',';
      }
      $stg_id_string .= $v['stg_id'];
    }

    $sql_performance_indicator = "SELECT * 
                                  FROM `performance_indicator` T0
                                  WHERE T0.pi_id IN (" . $stg_id_string . ")";
    $stmt_performance_indicator = $this->cont->prepare($sql_performance_indicator);
    $status[] = $stmt_performance_indicator->execute();
    $row_performance_indicator = $stmt_performance_indicator->fetchAll(PDO::FETCH_ASSOC);

    $data['row'] = $row_performance_indicator;
    return $data;
  }
}
