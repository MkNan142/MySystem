// fullCalendar 5.10.1
document.write('<script src="plugins/moment/moment.min.js"></script>');
document.write('<script src="plugins/fullcalendar/main.js"></script>');

var calendar;
var url = "index.php?subSys=MSS&actionType=API&action=MissionCalenderAction";
$(function () {


  //設定新日常目標時用的預計執行時間規格
  $('#duration').daterangepicker({
    "singleDatePicker": true,
    "timePicker": true,
    "timePicker24Hour": true,
    "autoApply": true,
    "timePickerIncrement": 1,
    locale: {
      format: 'HH:mm',
      cancelLabel: 'Clear'
    }
  }).on('show.daterangepicker', function (ev, picker) {
    picker.container.find(".calendar-table").hide();
  });
  $('#duration').val('');
  $('#ds_start_time,#ds_end_time').daterangepicker({
    "singleDatePicker": true,
    "timePicker": true,
    "timePicker24Hour": true,
    "timePickerSeconds": true,
    "startDate": null,
    "autoApply": true,
    locale: {
      format: 'YYYY-MM-DD HH:mm:ss',
      cancelLabel: 'Clear'
    }
  }, function (start, end, label) {
    //console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
  });

  /* initialize the calendar
   -----------------------------------------------------------------*/
  //Date for the calendar events (dummy data)
  var Calendar = FullCalendar.Calendar;
  var Draggable = FullCalendar.Draggable;
  var containerEl = document.getElementById('external-events');
  var calendarEl = document.getElementById('calendar');

  //將可拖移元素變成可與日曆互動的元素
  new Draggable(containerEl, {
    itemSelector: '.external-event',
    eventData: function (eventEl) {
      return {
        title: $(eventEl).data('event').title,
        backgroundColor: window.getComputedStyle(eventEl, null).getPropertyValue('background-color'),
        borderColor: window.getComputedStyle(eventEl, null).getPropertyValue('background-color'),
        textColor: window.getComputedStyle(eventEl, null).getPropertyValue('color'),
        duration: $(eventEl).data('event').duration,
        extendedProps: $(eventEl).data('event').extendedProps,
        //將可拖拉的元素先預設ID為-1 這樣在放到日曆上時可以根據getEventById('-1')來重新設定此元素在mysql的ID
        id: "-1"
      };
    }
  });

  //定義日曆初始參數與事件
  calendar = new Calendar(calendarEl, {
    headerToolbar: {
      left: 'prev,next today',
      center: 'title',
      right: 'dayGridMonth,timeGridWeek,timeGridDay'
    },
    themeSystem: 'bootstrap',
    locale: 'tw',
    events: [
    ],
    editable: true,
    droppable: true, // this allows things to be dropped onto the calendar !!!
    slotDuration: '00:30',  //日曆表上多長時間作為一格 00:30代表為30分鐘
    weekNumbers: true, //在時間表上顯示週數
    defaultTimedEventDuration: '02:00', //設定每個事件的預設執行時間
    // drop: function (info) {
    // },
    // eventAdd: function (addInfo) {
    //   console.log('eventAdd');
    //   console.log(addInfo);
    //   幫彈出視窗的顏色選擇器自訂出一種新顏色
    //   $('#modal_color_selecter').val('#' + parseInt(Math.random() * 255).toString(16) + parseInt(Math.random() * 255).toString(16) + parseInt(Math.random() * 255).toString(16));
    //   $('#modal_color_selecter').change();
    // },
    // eventChange: function (info) {
    //   console.log('eventChange');
    //   console.log(info);
    // },

    //當日歷的顯示區間改變時觸發
    datesSet: function (dateInfo) {
      var lne = calendar.getEvents().length;
      calendar.getEvents().forEach(function (v, k) {
        lne--;
        calendar.getEvents()[lne].remove();
      })
      getDailySchedule(dateInfo.start, dateInfo.end);
    },

    //當日歷接收到新事件時
    eventReceive: function (addInfo) {
      $('.loader').addClass('is-active');
      addNewEvent(addInfo);
    },

    //當調整事件的持續時間時
    eventResize: function (info) {
      // if (!confirm(info.event.title + " 結束時間將改為 " + setDateFormat(info.event.end) + "\n確定更改?")) {
      //   info.revert();
      // } else {
      //   $('.loader').addClass('is-active');
      //   setDailyScheduleNewStartEnd(info);
      // }
      $('.loader').addClass('is-active');
      setDailyScheduleNewStartEnd(info);
    },

    //當調整事件的開始與結束時間時
    eventDrop: function (info) {
      // if (!confirm(info.event.title + " 時間調整為 " + setDateFormat(info.event.start) + " ~ " + setDateFormat(info.event.end) + "\n確定更改?")) {
      //   info.revert();
      // } else {
      //   $('.loader').addClass('is-active');
      //   setDailyScheduleNewStartEnd(info);
      // }

      $('.loader').addClass('is-active');
      setDailyScheduleNewStartEnd(info);
    },
    eventClick: function (info) {
      $('#btnDailyScheduleDetial').click();
      getDailyScheduleDetial(info.event._def.publicId);
    },
    eventMouseEnter: function (info) {
      //console.log(info);
      if (info.event._def.extendedProps.status == '5') {
        $(info.el).css("background-color", info.event._def.ui.borderColor);
      }
    },
    eventMouseLeave: function (info) {
      //console.log(info);
      if (info.event._def.extendedProps.status == '5') {
        $(info.el).attr('style', 'background-Color:' + info.event._def.ui.borderColor + '4d;border-Color:' + info.event._def.ui.borderColor);
      }
    }
  });

  calendar.render();

  //取得日程樣板後 可依靠new Draggable建立一個可拖拉的div元素
  //draggableEl是元素的ID
  //eventData裡的duration可以設定預設執行所需要的時間

  //HTML樣例
  //<div id='draggableEl' data-event='{ "title": "my event", "duration": "02:00" }'>drag me</div>

  //JS樣例
  /*new Draggable(draggableEl, {
    eventData: {
      title: 'my event',
      duration: '06:00'
    }
  });*/

  getDailyScheduleTemplate();
  getShortTermGoalList();
})

//取得常用的日常目標
function getDailyScheduleTemplate() {
  var url = "index.php?subSys=MSS&actionType=API&action=MissionCalenderAction";
  $.ajax({
    type: "POST",
    url: url,
    dataType: "json",
    data: { doMissionAction: 'getDailyScheduleTemplate' }, // serializes the form's elements.
    success: function (data) {
      $('#external-events div.external-event').remove();
      $.each(data['row'], function (k, v) {
        //console.log(k + ':' + v);
        var event = $('<div />');
        var text_color = (luma(v['dst_default_color']) >= 165) ? '000' : 'fff';
        event.css({
          'background-color': '#' + v['dst_default_color'],
          'border-color': '#' + v['dst_default_color'],
          'color': '#' + text_color
        }).addClass('external-event');
        event.attr('data-event', '{"title":"' + v["dst_name"] + '","duration":"' + v["dst_default_duration"] + '","extendedProps":{"goal_relation":"' + v["dst_default_goal_relation"] + '"}}');
        event.attr('id', 'external-event-' + v['dst_id']);
        event.text(v['dst_name']);
        $('#external-events').append(event);
      });
    },
    error: function (data) {
      console.log('An error occurred.');
      console.log(data);
    }
  });
}

//取得目前已設定好的日常目標
function getDailySchedule(start, end) {
  var sch_val = new Object();
  //使用General.js裡的通用函數setDateFormat轉換日期格式
  sch_val['start'] = setDateFormat(start);
  sch_val['end'] = setDateFormat(end);

  var url = "index.php?subSys=MSS&actionType=API&action=MissionCalenderAction";
  $.ajax({
    type: "POST",
    url: url,
    dataType: "json",
    data: { data: sch_val, doMissionAction: 'getDailySchedule' }, // serializes the form's elements.
    success: function (data) {
      // console.log(data);
      $.each(data['row'], function (k, v) {
        var new_color = v['ds_color'];

        //如果目標狀態為已完成的話 則將顏色設置為半透明
        if (v['ds_status'] == '5') {
          new_color = v['ds_color'] + '4d';
        }

        //根據背景顏色的亮度決定字體顏色使用黑色或白色
        var text_color = (luma(v['ds_color']) >= 165) ? '000' : 'fff';

        var event = {
          title: v['ds_name'],
          id: v['ds_id'],
          status: v['ds_status'], //可以新增自己要的元素作為進階操作使用
          start: v['ds_start_time'],
          end: v['ds_end_time'],
          allDay: false,
          backgroundColor: '#' + new_color,
          borderColor: '#' + v['ds_color'],
          textColor: '#' + text_color
        };
        calendar.addEvent(event);
      });
    },
    error: function (data) {
      //console.log(ins_val);
      console.log('An error occurred.');
      console.log(data);
    }
  });
}

//取得建立新日常目標時所要連結的短期目標
function getShortTermGoalList() {
  var sch_val = new Object();
  var url = "index.php?subSys=MSS&actionType=API&action=MissionCalenderAction";
  sch_val['start'] = '';
  sch_val['end'] = '';
  $.ajax({
    type: "POST",
    url: url,
    dataType: "json",
    data: { data: sch_val, doMissionAction: 'getShortTermGoalList' }, // serializes the form's elements.
    success: function (data) {
      // console.log(data);
      $('#ds_goal_relation_checklist').html('');
      var tmp = '';
      tmp += '<div class="form-check col-sm-6">';
      tmp += '<input class="form-check-input" type="checkbox" name="short_term_goal_id" value="0" id="short_term_goal_checkbox_0">';
      tmp += '<label class="form-check-label" for="short_term_goal_checkbox_0">不關聯</label>';
      tmp += '</div>';
      $.each(data['row'], function (k, v) {
        tmp += '<div class="form-check col-sm-6"><input class="form-check-input" type="checkbox" name="short_term_goal_id" value="' + v['stg_id'] + '" id="short_term_goal_checkbox_' + v['stg_id'] + '"><label class="form-check-label" for="short_term_goal_checkbox_' + v['stg_id'] + '">' + v['stg_name'] + '</label></div>';
      })
      $('#ds_goal_relation_checklist').html(tmp);

      //設定"不關聯"的多選方塊被勾選時 取消其他已勾選的短期目標關聯 
      //且當"不關聯"為勾選狀態時 其他短期目標無法勾選
      $('input[name="short_term_goal_id"]').on("change", function () {
        //console.log(this);
        if ($(this).attr('id') == 'short_term_goal_checkbox_0' && $(this).prop('checked')) {
          if (confirm('確定不關聯任何短期任務嗎?')) {
            $('input[name="short_term_goal_id"]').each(function () {
              $(this).prop('checked', false);
            })
            $(this).prop('checked', true);
          } else {
            $(this).prop('checked', false);
          }
        } else {
          if ($('#short_term_goal_checkbox_0').prop('checked')) {
            $(this).prop('checked', false);
          }
        }
      })
    },
    error: function (data) {
      //console.log(ins_val);
      console.log('An error occurred.');
      console.log(data);
    }
  });
}
function setDailyScheduleNewStartEnd(info) {
  var set_val = new Object();
  //使用General.js裡的通用函數setDateFormat轉換日期格式
  set_val['start'] = setDateFormat(info.event.start);
  set_val['end'] = setDateFormat(info.event.end);
  set_val['id'] = info.event._def.publicId;

  var url = "index.php?subSys=MSS&actionType=API&action=MissionCalenderAction";
  $.ajax({
    type: "POST",
    url: url,
    dataType: "json",
    data: { data: set_val, doMissionAction: 'setDailyScheduleNewStartEnd' }, // serializes the form's elements.
    success: function (data) {
      console.log("日常目標時間變更成功");
      //console.log(data);
      $('.loader').removeClass('is-active');
    },
    error: function (data) {
      //console.log(ins_val);
      console.log('日常目標時間變更失敗.');
      info.revert();
      console.log(data);
    }
  });

}
function addNewEvent(info) {
  var add_val = new Object();
  var hex_color = '';

  //取得新日常目標的hex色碼 由於新建的日常目標都會設定為rgb碼 所以需轉換成hex
  var tmp_color = info.event._def.ui.borderColor.match(/\d+/g).map(Number);
  tmp_color.forEach(function (v) {
    //當數字小於16時 需要補0 以免hex色碼出現不足6碼的情況
    if (v < 16) {
      hex_color += '0';
    }
    hex_color += parseInt(v).toString(16);
  });

  //使用General.js裡的通用函數setDateFormat轉換日期格式  
  add_val['start'] = setDateFormat(info.event.start);
  add_val['end'] = setDateFormat(info.event.end);
  add_val['hex_color'] = hex_color;
  add_val['name'] = info.event.title;
  add_val['goal_relation'] = info.event.extendedProps.goal_relation;
  console.log(add_val);
  //return;
  var url = "index.php?subSys=MSS&actionType=API&action=MissionCalenderAction";
  $.ajax({
    type: "POST",
    url: url,
    dataType: "json",
    data: { data: add_val, doMissionAction: 'addNewEvent' }, // serializes the form's elements.
    success: function (data) {
      console.log("日常目標新增成功");
      console.log(data);
      $('.loader').removeClass('is-active');
      calendar.getEventById("-1").setProp('id', data['LAST_ID']);
      if (data['warn']) {
        alert('所關聯短期目標與新增的日常目標時間不符!');
      }
    },
    error: function (data) {
      //console.log(ins_val);
      console.log('日常目標新增失敗.');
      info.revert();
      $('.loader').removeClass('is-active');
      console.log(data);
    }
  });
}

//當點擊日常目標時取得日常目標的相關資料
function getDailyScheduleDetial(publicId) {
  $('#modal_finish_div').hide();
  //將彈出視窗目前勾選的短期目標關聯都取消勾選
  $('input[name="modal_short_term_goal_id"]').each(function () {
    $(this).prop('checked', false);
  })
  //元件沒有設計清除選取值的涵式 需要直接移除後重新綁定一次
  $('#ds_start_time,#ds_end_time').data('daterangepicker').remove();
  $('#ds_start_time,#ds_end_time').daterangepicker({
    "singleDatePicker": true,
    "timePicker": true,
    "timePicker24Hour": true,
    "timePickerSeconds": true,
    "startDate": null,
    "autoApply": true,
    locale: {
      format: 'YYYY-MM-DD HH:mm:ss',
      cancelLabel: 'Clear'
    }
  }, function (start, end, label) {
    //console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
  });

  var sch_val = new Object();
  sch_val['publicId'] = publicId;
  var url = "index.php?subSys=MSS&actionType=API&action=MissionCalenderAction";
  $.ajax({
    type: "POST",
    url: url,
    dataType: "json",
    data: { data: sch_val, doMissionAction: 'getDailyScheduleDetial' }, // serializes the form's elements.
    success: function (data) {
      //console.log(data);
      var goal_relation_list;
      $.each(data['row'], function (k, v) {
        $('#' + k).val(v);
        if (k == 'ds_goal_relation') {
          goal_relation_list = v.split(',');
        }
        if (k == 'ds_start_time' || k == 'ds_end_time') {
          $('#' + k).data('daterangepicker').setStartDate(v);
        }
        if (k == 'ds_color') {
          $('#modal_color_selecter').val('#' + v);
          $('#modal_color_selecter').change();
        }
      });
      if(data['row']['ds_status']=='5'){
        $('#modal_finish_div').show();
      }
      getModalShortTermGoalList(goal_relation_list);
    },
    error: function (data) {
      //console.log(ins_val);
      console.log('An error occurred.');
      console.log(data);
    }
  });
}
//當點擊日常目標要進行詳細修改時所需取得的短期目標清單
function getModalShortTermGoalList(goal_relation_list = '') {
  // console.log('開始的list');
  // console.log(goal_list);
  var sch_val = new Object();
  var url = "index.php?subSys=MSS&actionType=API&action=MissionCalenderAction";
  sch_val['start'] = $('#ds_start_time').val();
  sch_val['end'] = $('#ds_end_time').val();
  $.ajax({
    type: "POST",
    url: url,
    dataType: "json",
    data: { data: sch_val, doMissionAction: 'getShortTermGoalList' }, // serializes the form's elements.
    success: function (data) {
      // console.log(data);
      $('#modal_ds_goal_relation_checklist').html('');
      var tmp = '';
      tmp += '<div class="form-check col-sm-6">';
      tmp += '<input class="form-check-input" type="checkbox" name="modal_short_term_goal_id" value="0" id="modal_short_term_goal_checkbox_0">';
      tmp += '<label class="form-check-label" for="modal_short_term_goal_checkbox_0">不關聯</label>';
      tmp += '</div>';
      $.each(data['row'], function (k, v) {
        tmp += '<div class="form-check col-sm-6"><input class="form-check-input" type="checkbox" name="modal_short_term_goal_id" value="' + v['stg_id'] + '" id="modal_short_term_goal_checkbox_' + v['stg_id'] + '"><label class="form-check-label" for="modal_short_term_goal_checkbox_' + v['stg_id'] + '">' + v['stg_name'] + '</label></div>';
      })
      $('#modal_ds_goal_relation_checklist').html(tmp);

      //當勾選格建立完成時 依照當初傳入的清單做預設勾選
      if (goal_relation_list != '') {
        goal_relation_list.forEach(function (v, k) {
          //console.log(v);
          $('#modal_short_term_goal_checkbox_' + v).prop('checked', true);
        })
      }
      //設定"不關聯"的多選方塊被勾選時 取消其他已勾選的短期目標關聯 
      //且當"不關聯"為勾選狀態時 其他短期目標無法勾選
      $('input[name="modal_short_term_goal_id"]').on("change", function () {
        //console.log(this);
        if ($(this).attr('id') == 'modal_short_term_goal_checkbox_0' && $(this).prop('checked')) {
          if (confirm('確定不關聯任何短期任務嗎?')) {
            $('input[name="modal_short_term_goal_id"]').each(function () {
              $(this).prop('checked', false);
            })
            $(this).prop('checked', true);
          } else {
            $(this).prop('checked', false);
          }
        } else {
          if ($('#modal_short_term_goal_checkbox_0').prop('checked')) {
            $(this).prop('checked', false);
          }
        }
      })
      //console.log('done');
    },
    error: function (data) {
      //console.log(ins_val);
      console.log('An error occurred.');
      console.log(data);
    }
  });
}
//送出日常目標的詳細修改表單
function updDailySchedule() {
  var form_check = 1;
  $('.notnull').each(function () {
    if ($(this).val() == '') {
      form_check = 0;
    }
  })
  if (!form_check) {
    alert('有欄位尚未輸入');
    return 0;
  }
  if (!form_check) {
    return 0;
  }
  var ins_val = new Object();
  $('.form_ins_val').each(function () {
    //console.log($(this).attr('type'));
    ins_val[$(this).attr('id')] = $(this).val();
  })
  var goal_list = '';
  $('input[name="modal_short_term_goal_id"]').each(function () {
    if ($(this).prop('checked')) {
      if (goal_list != '') {
        goal_list += ',';
      }
      goal_list += $(this).val();
    }
  })
  ins_val['ds_goal_relation'] = goal_list;
  ins_val['ds_color'] = $('#modal_color_selecter').val().substr(1, 6);
  //console.log(ins_val);
  $('.loader').addClass('is-active');
  //已完成的日常目標如需修改時
  if ($('#modal_finish_div').css('display') == 'block') {
    console.log('block');
    var performance_indicator_record_list = '';
    var performance_indicator_record_value = new Object()
    $('input[name="modal_performance_indicator_record_id"]').each(function () {
      if ($(this).prop('checked')) {
        if (performance_indicator_record_list != '') {
          performance_indicator_record_list += ',';
        }
        performance_indicator_record_list += $(this).val();
        if($('#pir_value_'+$(this).val()).val()==''){
          $('#pir_value_'+$(this).val()).focus();
          alert('已勾選欄位不可空白');
          return;
        }else{
          performance_indicator_record_value[$(this).val()]=$('#pir_value_'+$(this).val()).val();
        }
        
      }
    })

    ins_val['ds_execution_start_time'] = $('#ds_execution_start_time').val();
    ins_val['ds_execution_end_time'] = $('#ds_execution_end_time').val();
    ins_val['performance_indicator_record_list'] = performance_indicator_record_list;
    ins_val['performance_indicator_record_value'] = performance_indicator_record_value;
  }
  console.log(ins_val);
  var url = "index.php?subSys=MSS&actionType=API&action=MissionCalenderAction";
  $.ajax({
    type: "POST",
    url: url,
    dataType: "json",
    data: { data: ins_val, doMissionAction: "updDailySchedule" },
    success: function (data) {
      console.log(data);
      if (data) {
        console.log('修改完成')
        $('#btn_moadl_close').click();
        calendar.getEventById($('#ds_id').val()).setProp('title', $('#ds_name').val());
        calendar.getEventById($('#ds_id').val()).setDates($('#ds_start_time').val(), $('#ds_end_time').val());
        calendar.getEventById($('#ds_id').val()).setExtendedProp('status', $('#ds_status').val());
        var bg_color = $('#modal_color_selecter').val();
        if ($('#ds_status').val() == '5') {
          bg_color += '4d';
        }
        calendar.getEventById($('#ds_id').val()).setProp('backgroundColor', bg_color);
        $('.loader').removeClass('is-active');
      }
    },
    error: function (data) {
      console.log(ins_val);
      console.log('An error occurred.');
      console.log(data);
    }
  });
}
function delEvent() {
  if (!confirm('確定刪除?')) {
    return;
  }
  $('.loader').addClass('is-active');

  var del_val = new Object();
  del_val['ds_id'] = $('#ds_id').val();

  var url = "index.php?subSys=MSS&actionType=API&action=MissionCalenderAction";
  $.ajax({
    type: "POST",
    url: url,
    dataType: "json",
    data: { data: del_val, doMissionAction: "delEvent" },
    success: function (data) {
      //console.log(data);
      if (data) {
        //console.log('刪除完成')
        $('#btn_moadl_close').click();
        calendar.getEventById($('#ds_id').val()).remove();
        $('.loader').removeClass('is-active');
      }
    },
    error: function (data) {
      console.log('刪除失敗');
      console.log(data);
      console.log(del_val);
      $('.loader').removeClass('is-active');
    }
  });
}

//重設任務表單
function reset() {
  $('#modal_finish_div').hide();
  $('#modal_edit_div input').attr('disabled', false);
  $('#modal_edit_div select').attr('disabled', false);
  $('input[name="modal_short_term_goal_id"]').attr('disabled', false);
  $('#ds_execution_start_time,#ds_execution_end_time').data('daterangepicker').remove();
}
function setTime(field_name) {
  var now_format = setDateFormat(new Date());

  $('#' + field_name).val(now_format);
}
/* + ADDING EVENTS */
var currColor = '#3c8dbc' //Red by default
// Color chooser button
$('#color-chooser > li > a').click(function (e) {
  e.preventDefault()
  // Save color
  currColor = $(this).css('color')
  //console.log(currColor);
  // Add color effect to button
  var text_color = (luma(currColor) >= 165) ? '000' : 'fff';
  $('#add-new-event').css({
    'background-color': currColor,
    'border-color': currColor,
    'color': '#' + text_color
  })
})

$('#color_selecter').on("change", function () {
  currColor = $(this).val();
  //console.log(currColor);
  // Add color effect to button
  var text_color = (luma(currColor) >= 165) ? '000' : 'fff';
  $('#add-new-event').css({
    'background-color': currColor,
    'border-color': currColor,
    'color': '#' + text_color
  })
})

$('#add-new-event').click(function (e) {
  e.preventDefault()
  // Get value and make sure it is not null
  var val = $('#new-event').val()
  if (val.length == 0) {
    alert('請填寫目標名稱');
    return;
  }

  var duration = $('#duration').val()
  if (duration == '00:00' || duration == null || duration == '') {
    alert('請填寫執行時間');
    return;
  }

  var goal_relation = '';
  $('input[name="short_term_goal_id"]').each(function () {
    if ($(this).prop('checked')) {
      if (goal_relation != '') {
        goal_relation += ',';
      }
      goal_relation += $(this).val();
      //console.log($(this).val());
    }
    $(this).prop('checked', false);
  })
  if (goal_relation == '') {
    alert('請勾選短期目標關聯項目');
    return;
  }

  var text_color = (luma(currColor) >= 165) ? '000' : 'fff';
  //console.log(luma(currColor));
  //console.log(text_color);
  // Create events
  var event = $('<div />')
  event.css({
    'background-color': currColor,
    'border-color': currColor,
    'color': '#' + text_color
  }).addClass('external-event')

  event.attr('data-event', '{"title":"' + val + '","duration":"' + duration + '","extendedProps":{"goal_relation":"' + goal_relation + '"}}');
  event.text(val);
  //console.log(event);
  $('#external-events').append(event)

  // Add draggable funtionality
  //ini_events(event)

  // Remove event from text input
  $('#new-event').val('')
})
/* - ADDING EVENTS */

$('#modal_color_selecter').on("change", function () {
  currColor = $(this).val();
  //console.log(currColor);
  // Add color effect to button
  var text_color = (luma(currColor) >= 165) ? '000' : 'fff';
  $('#modal_color_selecter_show_div').css({
    'background-color': currColor,
    'color': '#' + text_color
  })
})


$('#ds_start_time,#ds_end_time').on("change", function () {
  if ($('#ds_start_time').val() != '' && $('#ds_end_time').val() != '') {

    var goal_relation_list = new Array();
    $('input[name="modal_short_term_goal_id"]').each(function () {
      if ($(this).prop('checked')) {
        goal_relation_list.push($(this).val());
      }
    })
    getModalShortTermGoalList(goal_relation_list);
  }
})

$('#btnShowModalFinish').on("click", function () {
  $('#modal_finish_div').show();
  $('#modal_edit_div input').attr('disabled', true);
  $('#modal_edit_div select').attr('disabled', true);
  $('input[name="modal_short_term_goal_id"]').attr('disabled', true);
  $('#ds_status').val('5');
  $('#ds_execution_start_time,#ds_execution_end_time').daterangepicker({
    "singleDatePicker": true,
    "timePicker": true,
    "timePicker24Hour": true,
    "timePickerSeconds": true,
    "startDate": null,
    "autoApply": true,
    locale: {
      format: 'YYYY-MM-DD HH:mm:ss',
      cancelLabel: 'Clear'
    }
  });
  $('#ds_execution_start_time').val($('#ds_start_time').val());
  $('#ds_execution_end_time').val($('#ds_end_time').val());
  $('#ds_execution_start_time').data('daterangepicker').setStartDate($('#ds_start_time').val());
  $('#ds_execution_end_time').data('daterangepicker').setStartDate($('#ds_end_time').val());

  var sch_val = new Object();
  sch_val['ds_id'] = $('#ds_id').val();
  $.ajax({
    type: "POST",
    url: url,
    dataType: "json",
    data: { data: sch_val, doMissionAction: 'getDailySchedulePerformanceIndicator' }, // serializes the form's elements.
    success: function (data) {
      console.log(data);
      $('#modal_performance_indicator_record_checklist').html('');
      var tmp = '';
      // tmp += '<div class="form-check col-sm-6">';
      // tmp += '<input class="form-check-input" type="checkbox" name="modal_performance_indicator_record_id" value="0" id="modal_performance_indicator_record_checkbox_0">';
      // tmp += '<label class="form-check-label" for="modal_performance_indicator_record_checkbox_0">不關聯</label>';
      // tmp += '</div>';

      $.each(data['row'], function (k, v) {
        tmp += '</br>';
        tmp += '<div class="form-check col-sm-12 form-group ">';
        tmp += '<input class="form-check-input" type="checkbox" name="modal_performance_indicator_record_id" value="' + v['pi_id'] + '" id="modal_performance_indicator_record_checkbox_' + v['pi_id'] + '">';
        tmp += '<div class="input-group">';
        tmp += '<label class=" col-form-label">完成</label>';
        tmp += '<input type="text" class="form-control col-sm-3" id="pir_value_' + v['pi_id'] + '" placeholder="達成量">';
        tmp += '<div class="input-group-prepend">';
        tmp += '<label class=" col-form-label">' + v['pi_unit'] + '</label>';
        tmp += '<label class=" col-form-label">' + v['pi_describe'] + '</label>';
        tmp += '</div>';
        tmp += '</div>';
        //tmp += '<label class="form-check-label" for="modal_performance_indicator_record_checkbox_' + v['stg_id'] + '">' + v['stg_name'] + '</label>';
        tmp += '</div>';
      })
      $('#modal_performance_indicator_record_checklist').html(tmp);
      console.log(tmp);
    },
    error: function (data) {
      //console.log(ins_val);
      console.log('An error occurred.');
      console.log(data);
    }
  });

})

//取得顯眼對比色所使用 參考:https://qa.1r1g.com/sf/ask/44451571/
function luma(color) // color can be a hx string or an array of RGB values 0-255
{
  var rgb;
  //console.log(typeof color);
  if (typeof color === 'string') {
    if (color.substr(0, 1) == '#' || color.length == 6) {
      //console.log('hex');
      rgb = hexToRGBArray(color);
    } else if (color.substr(0, 3) == 'rgb') {
      // color = color.substring(0, color.length - 1);
      // color = color.substring(4, color.length);
      // rgb = color.split(',');
      rgb = color.match(/\d+/g).map(Number);
    }
  }
  //var rgb = (typeof color === 'string') ? hexToRGBArray(color) : color;
  return (0.2126 * rgb[0]) + (0.7152 * rgb[1]) + (0.0722 * rgb[2]); // SMPTE C, Rec. 709 weightings
}
function hexToRGBArray(color) {
  //console.log(color.length);
  if (color.length === 7) {
    color = color.substr(1, 6);
  }
  if (color.length === 3) {
    color = color.charAt(0) + color.charAt(0) + color.charAt(1) + color.charAt(1) + color.charAt(2) + color.charAt(2);
  } else if (color.length !== 6) {
    throw ('Invalid hex color: ' + color);
  }
  var rgb = [];
  for (var i = 0; i <= 2; i++)
    rgb[i] = parseInt(color.substr(i * 2, 2), 16);
  return rgb;
}