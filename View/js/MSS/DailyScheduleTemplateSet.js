var now_format = '';

$(function () {
  //取得任務清單
  $('#dst_default_duration').daterangepicker({
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
  getRecord(1);
})

//取得任務清單
function getRecord(pageNum) {
  var sch_val = new Object();
  // sch_val['pi_name'] = $('#sch_pi_name').val();
  // sch_val['pi_status'] = $('#sch_pi_status').val();

  sch_val['orderby'] = '';//預設排序欄位為空白
  sch_val['Inverted'] = 'asc';//預設排序為asc
  $.each($('.ms_daily_schedule_table'), function (k, v) {
    if (!$(this).hasClass('sorting')) {
      if ($(this).hasClass('sorting_asc')) {
        sch_val['orderby'] = $(this).attr('id').replace("ms_daily_schedule_table_", "");
        sch_val['Inverted'] = 'asc';
      } else if ($(this).hasClass('sorting_desc')) {
        sch_val['orderby'] = $(this).attr('id').replace("ms_daily_schedule_table_", "");
        sch_val['Inverted'] = 'desc';
      }
    }
  })
  sch_val['pageNum'] = pageNum;
  console.log(sch_val);
  var url = "index.php?subSys=MSS&actionType=API&action=DailyScheduleTemplateSetAction";
  $.ajax({
    type: "POST",
    url: url,
    dataType: "json",
    data: { data: sch_val, doMissionAction: 'getDailyScheduleTemplate2' },
    success: function (data) {
      console.log(data);
      var count_data = 0;
      var ms_daily_schedule_table_body_html = '';
      var table_field = new Array();
      $.each($('.ms_daily_schedule_table'), function (k, v) {
        table_field[k] = $(this).attr('id').replace("ms_daily_schedule_table_", "");
      })
      $.each(data['row'], function (k, v) {

        if (count_data % 2 == 0) {
          ms_daily_schedule_table_body_html += '<tr role="row" class="odd">';
        } else {
          ms_daily_schedule_table_body_html += '<tr role="row" class="even">';
        }
        var show_data = '';
        $.each(table_field, function (k1, v1) {
          if (v1 == 'edit') {
            show_data = '<div class="btn-group">';
            show_data += '<button type="button" class="btn btn-default" onclick="editDailySchedule(' + v['dst_id'] + ')"><i class="far fa-edit"></i></button>';
            show_data += '<button type="button" class="btn btn-default" onclick="delDailySchedule(' + v['dst_id'] + ')"><i class="far fa-trash-alt"></i></button>';
            show_data += '</div>';
          } else {
            show_data = v[v1];
          }
          ms_daily_schedule_table_body_html += '<td>' + show_data + '</td>';
        })

        count_data++;
      })
      //console.log(ms_daily_schedule_table_body_html);
      //console.log(data['rowcount']);
      $('#ms_daily_schedule_table_body').html(ms_daily_schedule_table_body_html);
      var max_page = Math.ceil(data['rowcount'] / 10);
      console.log(max_page);
      //設定頁尾頁數連結

      var pagination_html = '';
      var isNowPage = '';
      //如果總頁數不超過五頁 直接列出
      if (max_page < 6) {
        if (max_page < 1) {
          pagination_html += ' <li class="page-item" onclick="getRecord(1)" >';
          pagination_html += ' <a href="#" class="page-link">1</a></li>';
        }
        for (var i = 1; i <= max_page; i++) {
          pagination_html += ' <li class="page-item ';
          if (i == pageNum) {
            pagination_html += ' active ';
          } else {
            pagination_html += '" onclick="getRecord(' + i + ')';
          }
          pagination_html += ' "><a href="#" class="page-link">' + i + '</a></li>';
        }
      } else {
        //如果超過五頁 判斷現在頁數是不是第三頁以後 是的話需要做省略
        if (pageNum > 3) {
          pagination_html += '<li class="page-item "  onclick="getRecord(1)"><a href="#" class="page-link">1</a></li>';
          pagination_html += '<li class="page-item ">...</li> ';
        }
        //此部分是中間頁數判斷 如果現在頁面跟第一頁不超過兩頁 那就需要減少顯示的頁數
        if (pageNum < 3) {
          for (var i = 0; i < pageNum + 2; i++) {
            isNowPage = '';
            if (pageNum == parseInt(i + 1)) {
              isNowPage = ' active ';
            }
            pagination_html += '<li class="page-item ' + isNowPage + '" ><a href="#" onclick="getRecord(' + parseInt(i + 1) + ')" class="page-link">' + parseInt(i + 1) + '</a></li>'
          }
          //此部分為最大頁數判斷 如果現在頁數大於2(pageNum < 3的else) 且離尾頁還有2頁以上 那代表可以正常顯示五頁
        } else if (pageNum < max_page - 2) {
          var hrefPageNum = 0;
          for (var i = 0; i < 5; i++) {
            hrefPageNum = parseInt(pageNum + i) - 2;

            isNowPage = '';
            if (pageNum == hrefPageNum) {
              isNowPage = ' active ';
            }
            //console.log(hrefPageNum);
            pagination_html += '<li class="page-item' + isNowPage + ' " onclick="getRecord(' + hrefPageNum + ')"><a href="#" class="page-link">' + hrefPageNum + '</a></li>';
            //console.log(pagination_html);
          }
          //如果現在頁數離尾頁沒有超過兩頁 代表顯示頁數需要減少
        } else if (pageNum + 2 >= max_page) {
          var hrefPageNum = 0;
          for (var i = 0; i < 3 + (max_page - pageNum); i++) {
            hrefPageNum = parseInt(pageNum + i) - 2;
            //console.log(hrefPageNum);
            isNowPage = '';
            if (pageNum == hrefPageNum) {
              isNowPage = ' active ';
            }
            pagination_html += '<li class="page-item' + isNowPage + ' " onclick="getRecord(' + hrefPageNum + ')"><a href="#" class="page-link">' + hrefPageNum + '</a></li>'
          }
          //console.log(pagination_html);
        }
        if (pageNum + 2 < max_page) {
          pagination_html += '<li class="page-item ">...</li> ';
          pagination_html += '<li class="page-item "  onclick="getRecord(' + max_page + ')" ><a href="#" class="page-link">' + max_page + '</a></li>';
        }

      }
      $('#ms_daily_schedule_table_info').html('Showing ' + parseInt((pageNum - 1) * 10 + 1) + ' to ' + pageNum * 10 + ' of ' + data['rowcount'] + ' entries');
      $('.pagination').html(pagination_html);
    },
    error: function (data) {
      //console.log(ins_val);
      console.log('An error occurred.');
      console.log(data);
    }
  });
}

//取得可進行連結的短期目標
function getShortTermGoalList(goal_relation_list = '') {
  var sch_val = new Object();
  var url = "index.php?subSys=MSS&actionType=API&action=MissionAction";
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
      tmp += '<div class="form-check col-sm-3">';
      tmp += '<input class="form-check-input" type="checkbox" name="short_term_goal_id" value="0" id="short_term_goal_checkbox_0">';
      tmp += '<label class="form-check-label" for="short_term_goal_checkbox_0">不關聯</label>';
      tmp += '</div>';
      $.each(data['row'], function (k, v) {
        tmp += '<div class="form-check col-sm-3">';
        tmp += '<input class="form-check-input" type="checkbox" name="short_term_goal_id" value="' + v['stg_id'] + '" id="short_term_goal_checkbox_' + v['stg_id'] + '">';
        tmp += '<label class="form-check-label" for="short_term_goal_checkbox_' + v['stg_id'] + '">' + v['stg_name'] + '</label>';
        tmp += '</div>';
      })
      $('#dst_goal_relation_checklist').html(tmp);

      if (goal_relation_list != '') {
        goal_relation_list.forEach(function (v, k) {
          //console.log(v);
          $('#short_term_goal_checkbox_' + v).prop('checked', true);
        })
      }
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
//表單送出
function saveform() {
  var form_check = 1;
  $('.notnull').each(function () {
    if ($(this).val() == '') {
      form_check = 0;
    }
  })
  if ($('#dst_default_duration') == '00:00') {
    alert('執行時長不可為0時0分');
    return 0;
  }
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
    if ($(this).attr('id') == 'dst_default_color') {
      ins_val[$(this).attr('id')] = $(this).val().substr(1, 6);
    } else {
      ins_val[$(this).attr('id')] = $(this).val();
    }
  })

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
  ins_val['dst_default_goal_relation'] = goal_relation;

  //console.log(ins_val);
  var doDailyScheduleAction = '';
  var FinishAlert = '';
  if ($('#dst_action').val() == 'INS') {
    doDailyScheduleAction = 'insDailyScheduleTemplate';
    FinishAlert = '新增完成';
  } else if ($('#dst_action').val() == 'UPD') {
    doDailyScheduleAction = 'updDailyScheduleTemplate';
    FinishAlert = '修改完成';
  }
  var url = "index.php?subSys=MSS&actionType=API&action=DailyScheduleTemplateSetAction";
  $.ajax({
    type: "POST",
    url: url,
    dataType: "json",
    data: { data: ins_val, doMissionAction: doDailyScheduleAction },
    success: function (data) {
      //console.log(data);
      alert(FinishAlert);
      $('#btn_moadl_close').click();
      reset();
      getRecord(1);
    },
    error: function (data) {
      console.log(ins_val);
      console.log('An error occurred.');
      console.log(data);
    }
  });
}

function editDailySchedule(dst_id) {
  reset();
  var sch_val = new Object();
  sch_val['dst_id'] = dst_id;
  var url = "index.php?subSys=MSS&actionType=API&action=DailyScheduleTemplateSetAction";
  $.ajax({
    type: "POST",
    url: url,
    dataType: "json",
    data: { data: sch_val, doMissionAction: 'getDailyScheduleTemplateByID' }, // serializes the form's elements.
    success: function (data) {
      $('#btnDailyScheduleCreate').click();
      reset();
      $('#dst_action').val('UPD');
      var goal_relation_list;
      $.each(data['row'][0], function (k, v) {
        switch (k) {
          case 'dst_default_color':
            v = '#' + v;
            $('#' + k).val(v);
            break;
          case 'dst_default_goal_relation':
            goal_relation_list = v.split(',');
            break;
          case 'dst_default_duration':
            $('#' + k).val(v);
            $('#' + k).data('daterangepicker').setStartDate(v);
            break;
          default:
            $('#' + k).val(v);
            break;
        }
      });
      //console.log(goal_relation_list);
      getShortTermGoalList(goal_relation_list);

    },
    error: function (data) {
      //console.log(ins_val);
      console.log('An error occurred.');
      console.log(data);
    }
  });
}
function delDailySchedule(dst_id) {
  if (!confirm('確定要刪除嗎?')) {
    return 0;
  }
  var sch_val = new Object();
  sch_val['dst_id'] = dst_id;
  var url = "index.php?subSys=MSS&actionType=API&action=DailyScheduleTemplateSetAction";
  $.ajax({
    type: "POST",
    url: url,
    dataType: "json",
    data: { data: sch_val, doMissionAction: 'delDailyScheduleTemplateByID' }, // serializes the form's elements.
    success: function (data) {
      alert('刪除完成');
      //console.log(data);
      getRecord(1);
    },
    error: function (data) {
      //console.log(ins_val);
      console.log('An error occurred.');
      console.log(data);
    }
  });
}

//重設任務表單
function reset() {
  $('.form_ins_val').val('');
  $('.form_ins_val').attr('disabled', false);
  $('#dst_default_color').val('#ffffff');
  $('#dst_action').val('INS');
}


$('#btnDailyScheduleCreate').on('click', function () {
  reset();
  getShortTermGoalList();
  $('#dst_action').val('INS');
})

$('#sch_pi_name,#sch_pi_status').on('change', function () {
  getRecord(1);
})

$('.ms_daily_schedule_table').not('.no_sort').on('click', function () {
  //console.log($(this).attr('id'));
  if ($(this).hasClass('sorting') || $(this).hasClass('sorting_asc')) {
    $('.ms_daily_schedule_table').not('.no_sort').removeClass('sorting sorting_asc sorting_desc');
    $('.ms_daily_schedule_table').not('.no_sort').addClass('sorting');
    $(this).removeClass('sorting');
    $(this).addClass('sorting_desc');
  } else {
    $('.ms_daily_schedule_table').not('.no_sort').removeClass('sorting sorting_asc sorting_desc');
    $('.ms_daily_schedule_table').not('.no_sort').addClass('sorting');
    $(this).removeClass('sorting');
    $(this).addClass('sorting_asc');
  }
  getRecord(1);
})
$('#color-chooser > li > a').click(function (e) {
  e.preventDefault()
  currColor = $(this).css('color');
  console.log(currColor);

  //rgb轉hex
  var hex_color = '';
  var tmp_color = currColor.match(/\d+/g).map(Number);
  tmp_color.forEach(function (v) {
    //當數字小於16時 需要補0 以免hex色碼出現不足6碼的情況
    if (v < 16) {
      hex_color += '0';
    }
    hex_color += parseInt(v).toString(16);
  });
  $('#dst_default_color').val('#'+hex_color);

})
