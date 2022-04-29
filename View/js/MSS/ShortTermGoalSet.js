var now_format = '';

$(function () {
  //設定日期格式遮罩
  var now = new Date();
  now_format = now.getFullYear() + "-" + (now.getMonth() + 1 < 10 ? '0' : '') + (now.getMonth() + 1) + "-" + (now.getDate() < 10 ? '0' : '') + (now.getDate()) + " " + (now.getHours() < 10 ? '0' : '') + now.getHours() + ":" + (now.getMinutes() < 10 ? '0' : '') + now.getMinutes() + ":" + (now.getSeconds() < 10 ? '0' : '') + now.getSeconds();
  //設定任務開始日期與結束日期的時間挑選元件
  $('#stg_start_time,#stg_end_time').daterangepicker({
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
  //開始時間預設為現在
  $('#stg_start_time').data('daterangepicker').setStartDate(now_format);
  //結束時間預設為月底 並將欄位留空
  var default_end = new Date(now.getFullYear(), now.getMonth() + 1, 0);
  default_end_format = default_end.getFullYear() + "-" + (default_end.getMonth() + 1 < 10 ? '0' : '') + (default_end.getMonth() + 1) + "-" + (default_end.getDate() < 10 ? '0' : '') + (default_end.getDate()) + " 23:59:59";
  $('#stg_end_time').data('daterangepicker').setStartDate(default_end_format);

  $('#stg_end_time').val('');
  //設定日期欄位清除功能
  $('#stg_start_time,#stg_end_time').on('cancel.daterangepicker', function (ev, picker) {
    $(this).val('');
  });

  //取得任務清單
  getRecord(1);
})

//取得可進行連結的短期目標
function getPerformanceIndicatorList(performance_relation_list = '') {
  var sch_val = new Object();
  var url = "index.php?subSys=MSS&actionType=API&action=ShortTermGoalSetAction";
  sch_val['pi_name'] = $('#sch_pi_name').val();
  sch_val['onckecked'] = performance_relation_list;
  $.ajax({
    type: "POST",
    url: url,
    dataType: "json",
    data: { data: sch_val, doMissionAction: 'getPerformanceIndicatorList' }, // serializes the form's elements.
    success: function (data) {
      console.log(data);
      $('#stg_performance_relation').html('');
      var tmp = '';
      tmp += '<div class="form-check col-sm-3">';
      tmp += '<input class="form-check-input" type="checkbox" name="performance_indicator_id" value="0" id="performance_indicator_checkbox_0">';
      tmp += '<label class="form-check-label" for="performance_indicator_checkbox_0">不關聯</label>';
      tmp += '</div>';
      $.each(data['row'], function (k, v) {
        tmp += '<div class="form-check col-sm-3">';
        tmp += '<input class="form-check-input" type="checkbox" name="performance_indicator_id" value="' + v['pi_id'] + '" id="performance_indicator_checkbox_' + v['pi_id'] + '">';
        tmp += '<label class="form-check-label" for="performance_indicator_checkbox_' + v['pi_id'] + '">' + v['pi_name'] + '</label>';
        tmp += '</div>';
      })
      $('#stg_performance_relation').html(tmp);
      if (performance_relation_list != '' && performance_relation_list != null) {
        console.log(performance_relation_list);
        performance_relation_list = performance_relation_list.split(',');
        performance_relation_list.forEach(function (v, k) {
          //console.log(v);
          $('#performance_indicator_checkbox_' + v).prop('checked', true);
        })
      }
      $('input[name="performance_indicator_id"]').on("change", function () {
        //console.log(this);
        if ($(this).attr('id') == 'performance_indicator_checkbox_0' && $(this).prop('checked')) {
          if (confirm('確定不關聯任何績效指標嗎?')) {
            $('input[name="performance_indicator_id"]').each(function () {
              $(this).prop('checked', false);
            })
            $(this).prop('checked', true);
          } else {
            $(this).prop('checked', false);
          }
        } else {
          if ($('#performance_indicator_checkbox_0').prop('checked')) {
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
  if (!form_check) {
    alert('有欄位尚未輸入');
    return 0;
  }

  if (new Date($('#stg_start_time').val()) > new Date($('#stg_end_time').val())) {
    alert('結束時間比起始時間還早')
    return ;
  }

  var performance_relation = '';
  $('input[name="performance_indicator_id"]').each(function () {
    if ($(this).prop('checked')) {
      if (performance_relation != '') {
        performance_relation += ',';
      }
      performance_relation += $(this).val();
    }
  })
  var ins_val = new Object();
  $('.form_ins_val').each(function () {
    //console.log($(this).attr('type'));
    ins_val[$(this).attr('id')] = $(this).val();
  })
  ins_val['stg_performance_relation'] = performance_relation;
  //console.log(ins_val);
  var doMissionAction = '';
  var FinishAlert = '';
  if ($('#stg_action').val() == 'INS') {
    doMissionAction = 'insShortTermMission';
    FinishAlert = '新增完成';
  } else if ($('#stg_action').val() == 'UPD') {
    doMissionAction = 'updShortTermMission';
    FinishAlert = '修改完成';
  }
  //return false;
  var url = "index.php?subSys=MSS&actionType=API&action=ShortTermGoalSetAction";
  $.ajax({
    type: "POST",
    url: url,
    dataType: "json",
    data: { data: ins_val, doMissionAction: doMissionAction },
    success: function (data) {
      //console.log(data);
      if (data) {
        alert(FinishAlert);
        $('#btn_moadl_close').click();
        reset();
        getRecord(1);
      }
    },
    error: function (data) {
      console.log(ins_val);
      console.log('An error occurred.');
      console.log(data);
    }
  });
}

//取得任務清單
function getRecord(pageNum) {
  var sch_val = new Object();
  sch_val['stg_status'] = $('#schMissionStatus').val();
  $.each($('.ms_short_table'), function (k, v) {
    if (!$(this).hasClass('sorting')) {
      if ($(this).hasClass('sorting_asc')) {
        sch_val['orderby'] = $(this).attr('id').replace("ms_short_table_", "");
        sch_val['Inverted'] = 'asc';
      } else if ($(this).hasClass('sorting_desc')) {
        sch_val['orderby'] = $(this).attr('id').replace("ms_short_table_", "");
        sch_val['Inverted'] = 'desc';
      }
    }
  })
  sch_val['pageNum'] = pageNum;
  //console.log(sch_val);
  var url = "index.php?subSys=MSS&actionType=API&action=ShortTermGoalSetAction";
  $.ajax({
    type: "POST",
    url: url,
    dataType: "json",
    data: { data: sch_val, doMissionAction: 'getShortTermMission' },
    success: function (data) {
      //console.log(data);
      var count_data = 0;
      var ms_short_table_body_html = '';
      var table_field = new Array();
      $.each($('.ms_short_table'), function (k, v) {
        table_field[k] = $(this).attr('id').replace("ms_short_table_", "");
      })
      $.each(data['row'], function (k, v) {

        if (count_data % 2 == 0) {
          ms_short_table_body_html += '<tr role="row" class="odd">';
        } else {
          ms_short_table_body_html += '<tr role="row" class="even">';
        }
        var show_data = '';
        $.each(table_field, function (k1, v1) {
          if (v1 == 'edit') {
            show_data = '<div class="btn-group">';
            show_data += '<button type="button" class="btn btn-default" onclick="editMission(' + v['stg_id'] + ')"><i class="far fa-edit"></i></button>';
            show_data += '<button type="button" class="btn btn-default" onclick="delMission(' + v['stg_id'] + ')"><i class="far fa-trash-alt"></i></button>';
            show_data += '</div>';
          } else if (v1 == 'stg_status') {
            switch (v[v1]) {
              case '0':
                show_data = '準備中';
                break;
              case '1':
                show_data = '執行中';
                break;
              case '5':
                show_data = '完成';
                break;
              case '7':
                show_data = '取消';
                break;
              case '9':
                show_data = '刪除';
                break;
            }
          } else {
            show_data = v[v1];
          }
          ms_short_table_body_html += '<td>' + show_data + '</td>';
        })

        count_data++;
      })
      //console.log(ms_short_table_body_html);
      //console.log(data['rowcount']);
      $('#ms_short_table_body').html(ms_short_table_body_html);
      var max_page = Math.ceil(data['rowcount'] / 10);
      //console.log(max_page);
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
      $('#ms_short_table_info').html('Showing ' + parseInt((pageNum - 1) * 10 + 1) + ' to ' + pageNum * 10 + ' of ' + data['rowcount'] + ' entries');
      $('.pagination').html(pagination_html);
    },
    error: function (data) {
      //console.log(ins_val);
      console.log('An error occurred.');
      console.log(data);
    }
  });
}

function editMission(stg_id) {
  var sch_val = new Object();
  sch_val['stg_id'] = stg_id;
  var url = "index.php?subSys=MSS&actionType=API&action=ShortTermGoalSetAction";
  $.ajax({
    type: "POST",
    url: url,
    dataType: "json",
    data: { data: sch_val, doMissionAction: 'getShortTermMissionByID' }, // serializes the form's elements.
    success: function (data) {
      $('#btnMissionCreate').click();
      reset();
      $('#stg_action').val('UPD');
      $.each(data['row'][0], function (k, v) {
        //console.log(k + ':' + v);
        $('#' + k).val(v);
        if (k == 'stg_start_time' || k == 'stg_end_time') {
          $('#' + k).data('daterangepicker').setStartDate(null);
          $('#' + k).data('daterangepicker').setStartDate(v);
        }
        if (k == 'stg_performance_relation') {
          getPerformanceIndicatorList(v);
        }
      });
    },
    error: function (data) {
      //console.log(ins_val);
      console.log('An error occurred.');
      console.log(data);
    }
  });
}
function delMission(stg_id) {
  if (!confirm('確定要刪除嗎?')) {
    return 0;
  }
  var sch_val = new Object();
  sch_val['stg_id'] = stg_id;
  var url = "index.php?subSys=MSS&actionType=API&action=ShortTermGoalSetAction";
  $.ajax({
    type: "POST",
    url: url,
    dataType: "json",
    data: { data: sch_val, doMissionAction: 'delShortTermMissionByID' }, // serializes the form's elements.
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
  var now = new Date();
  now_format = now.getFullYear() + "-" + (now.getMonth() + 1 < 10 ? '0' : '') + (now.getMonth() + 1) + "-" + (now.getDate() < 10 ? '0' : '') + (now.getDate()) + " " + (now.getHours() < 10 ? '0' : '') + now.getHours() + ":" + (now.getMinutes() < 10 ? '0' : '') + now.getMinutes() + ":" + (now.getSeconds() < 10 ? '0' : '') + now.getSeconds();
  $('.form_ins_val').val('');
  $('.form_ins_val').attr('disabled', false);

  $('#stg_status').val('0');
  $('#stg_start_time').val(now_format);
  $('#stg_action').val('INS');
}

//設定欄位為現在時間
function setTime(field_name) {
  var now = new Date();
  now_format = now.getFullYear() + "-" + (now.getMonth() + 1 < 10 ? '0' : '') + (now.getMonth() + 1) + "-" + (now.getDate() < 10 ? '0' : '') + (now.getDate()) + " " + (now.getHours() < 10 ? '0' : '') + now.getHours() + ":" + (now.getMinutes() < 10 ? '0' : '') + now.getMinutes() + ":" + (now.getSeconds() < 10 ? '0' : '') + now.getSeconds();
  $('#' + field_name).val(now_format);
}

$('#btnMissionCreate').on('click', function () {
  reset();
  getPerformanceIndicatorList();
  $('#stg_action').val('INS');
})

$('#schMissionStatus').on('change', function () {
  getRecord(1);
  if ($('#schMissionStatus').val() != '') {
  }
  //console.log($(this).val());
})

$('.ms_short_table').not('.no_sort').on('click', function () {
  //console.log($(this).attr('id'));
  if ($(this).hasClass('sorting') || $(this).hasClass('sorting_asc')) {
    $('.ms_short_table').not('.no_sort').removeClass('sorting sorting_asc sorting_desc');
    $('.ms_short_table').not('.no_sort').addClass('sorting');
    $(this).removeClass('sorting');
    $(this).addClass('sorting_desc');
  } else {
    $('.ms_short_table').not('.no_sort').removeClass('sorting sorting_asc sorting_desc');
    $('.ms_short_table').not('.no_sort').addClass('sorting');
    $(this).removeClass('sorting');
    $(this).addClass('sorting_asc');
  }
  getRecord(1);
})
$('#sch_pi_name').on('change', function () {

  var performance_relation = '';
  $('input[name="performance_indicator_id"]').each(function () {
    if ($(this).prop('checked')) {
      if (performance_relation != '') {
        performance_relation += ',';
      }
      performance_relation += $(this).val();
    }
  })
  getPerformanceIndicatorList(performance_relation);
})
