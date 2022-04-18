var now_format = '';

$(function () {
  //設定日期格式遮罩
  var now = new Date();
  now_format = now.getFullYear() + "-" + (now.getMonth() + 1 < 10 ? '0' : '') + (now.getMonth() + 1) + "-" + (now.getDate() < 10 ? '0' : '') + (now.getDate()) + " " + (now.getHours() < 10 ? '0' : '') + now.getHours() + ":" + (now.getMinutes() < 10 ? '0' : '') + now.getMinutes() + ":" + (now.getSeconds() < 10 ? '0' : '') + now.getSeconds();

  //取得任務清單
  getRecord(1);
})

//表單送出
// function saveform() {
//   var form_check = 1;
//   $('.notnull').each(function () {
//     if ($(this).val() == '') {
//       form_check = 0;
//     }
//   })
//   if (!form_check) {
//     alert('有欄位尚未輸入');
//     return 0;
//   }
//   if (!form_check) {
//     return 0;
//   }
//   var ins_val = new Object();
//   $('.form_ins_val').each(function () {
//     //console.log($(this).attr('type'));
//     ins_val[$(this).attr('id')] = $(this).val();
//   })
//   //console.log(ins_val);
//   var doMissionAction = '';
//   var FinishAlert = '';
//   if ($('#stg_action').val() == 'INS') {
//     doMissionAction = 'insShortTermMission';
//     FinishAlert = '新增完成';
//   } else if ($('#stg_action').val() == 'UPD') {
//     doMissionAction = 'updShortTermMission';
//     FinishAlert = '修改完成';
//   }
//   //return false;
//   var url = "index.php?subSys=MSS&actionType=API&action=MissionAction";
//   $.ajax({
//     type: "POST",
//     url: url,
//     dataType: "json",
//     data: { data: ins_val, doMissionAction: doMissionAction },
//     success: function (data) {
//       //console.log(data);
//       if (data) {
//         alert(FinishAlert);
//         $('#btn_moadl_close').click();
//         reset();
//         getRecord(1);
//       }
//     },
//     error: function (data) {
//       console.log(ins_val);
//       console.log('An error occurred.');
//       console.log(data);
//     }
//   });
// }

//取得任務清單
function getRecord(pageNum) {
  var sch_val = new Object();
  sch_val['goal_type'] = $('#schGoalType').val();
  $.each($('.ms_relations_table'), function (k, v) {
    if (!$(this).hasClass('sorting')) {
      if ($(this).hasClass('sorting_asc')) {
        sch_val['orderby'] = $(this).attr('id').replace("ms_relations_table_", "");
        sch_val['Inverted'] = 'asc';
      } else if ($(this).hasClass('sorting_desc')) {
        sch_val['orderby'] = $(this).attr('id').replace("ms_relations_table_", "");
        sch_val['Inverted'] = 'desc';
      }
    }
  })
  sch_val['pageNum'] = pageNum;
  //console.log(sch_val);
  var url = "index.php?subSys=MSS&actionType=API&action=MissionAction";
  $.ajax({
    type: "POST",
    url: url,
    dataType: "json",
    data: { data: sch_val, doMissionAction: 'getUnconnectedGoal' },
    success: function (data) {
      //console.log(data);
      var count_data = 0;
      var ms_relations_table_body_html = '';
      var table_field = new Array();
      $.each($('.ms_relations_table'), function (k, v) {
        table_field[k] = $(this).attr('id').replace("ms_relations_table_", "");
      })
      $.each(data['row'], function (k, v) {

        if (count_data % 2 == 0) {
          ms_relations_table_body_html += '<tr role="row" class="odd">';
        } else {
          ms_relations_table_body_html += '<tr role="row" class="even">';
        }
        var show_data = '';
        $.each(table_field, function (k1, v1) {
          if (v1 == 'edit') {
            show_data = '<div class="btn-group">';
            show_data += '<button type="button" class="btn btn-default" onclick="showRelationDetail(\'' + v['goal_type'] + '_' + v['goal_id'] + '\')"><i class="far fa-edit"></i></button>';
            //show_data += '<button type="button" class="btn btn-default" onclick="delMission(' + v['goal_id'] +'_'+ v['goal_type'] + ')"><i class="far fa-trash-alt"></i></button>';
            show_data += '</div>';
          } else if (v1 == 'goal_type') {
            switch (v[v1]) {
              case '1':
                show_data = '長期';
                break;
              case '2':
                show_data = '中期';
                break;
              case '3':
                show_data = '短期';
                break;
              case '4':
                show_data = '每日';
                break;
            }
          } else {
            show_data = v[v1];
          }
          ms_relations_table_body_html += '<td>' + show_data + '</td>';
        })

        count_data++;
      })
      //console.log(ms_relations_table_body_html);
      //console.log(data['rowcount']);
      $('#ms_relations_table_body').html(ms_relations_table_body_html);
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
      $('#ms_relations_table_info').html('Showing ' + parseInt((pageNum - 1) * 10 + 1) + ' to ' + pageNum * 10 + ' of ' + data['rowcount'] + ' entries');
      $('.pagination').html(pagination_html);
    },
    error: function (data) {
      //console.log(ins_val);
      console.log('An error occurred.');
      console.log(data);
    }
  });
}

function showRelationDetail(goal_type_id) {
  var sch_val = new Object();
  var goal_type_id_array = goal_type_id.split("_");
  sch_val['goal_type'] = goal_type_id_array[0];
  sch_val['goal_id'] = goal_type_id_array[1];
  //return;
  var url = "index.php?subSys=MSS&actionType=API&action=MissionAction";
  $.ajax({
    type: "POST",
    url: url,
    dataType: "json",
    data: { data: sch_val, doMissionAction: 'getRelationDetailByID' }, // serializes the form's elements.
    success: function (data) {
      console.log(data);
      $('#btnGoalRelationsList').click();
      reset();
      //目前目標詳細資料
      $.each(data['row_main_goal'][0], function (k, v) {
        switch (k.substring(4)) {
          case 'id':
            switch (k.substring(0, 3)) {
              case 'ltg':
                $('#goal_type').val('1');
                $('#goal_type_label').val('長期');
                break;
              case 'mtg':
                $('#goal_type').val('2');
                $('#goal_type_label').val('中期');
                break;
              case 'stg':
                $('#goal_type').val('3');
                $('#goal_type_label').val('短期');
                break;
            }
            k = 'goal' + k.substring(3)
            //console.log('goal'+k.substring(3) + ':' + v);
            $('#' + k).val(v);
            break;
          case 'status':
            switch (v) {
              case '0':
                v = '準備中'
                break;
              case '1':
                v = '執行中'
                break;
              case '5':
                v = '完成'
                break;
              case '7':
                v = '取消'
                break;
              case '9':
                v = '刪除'
                break;
            }
            k = 'goal' + k.substring(3)
            //console.log('goal'+k.substring(3) + ':' + v);
            $('#' + k).val(v);
            break;
          default:
            k = 'goal' + k.substring(3)
            console.log('goal' + k.substring(3) + ':' + v);
            $('#' + k).val(v);
            break;
        }
      });

      //目標下層關聯清單
      var count_data = 0;
      var ms_lower_relations_table_body_html = '';
      var table_field = new Array();
      $.each($('.ms_lower_relations_table'), function (k, v) {
        table_field[k] = $(this).attr('id').replace("ms_lower_relations_table_", "");
      })
      $.each(data['row_lower_goal'], function (k, v) {
        var lower_table_abbr = Object.keys(v)[0].substring(0, 3);
        //console.log(lower_table_abbr);
        var goal_type = '';
        switch (lower_table_abbr) {
          case 'ltg':
            goal_type = '長期';
            break;
          case 'mtg':
            goal_type = '中期';
            break;
          case 'stg':
            goal_type = '短期';
            break;
        }

        if (count_data % 2 == 0) {
          ms_lower_relations_table_body_html += '<tr role="row" class="odd">';
        } else {
          ms_lower_relations_table_body_html += '<tr role="row" class="even">';
        }
        var show_data = '';
        $.each(table_field, function (k1, v1) {
          if (v1 != 'edit') {
            v1 = lower_table_abbr + v1.substring(4);
          }
          //console.log(v1);
          if (v1 == 'edit') {
            show_data = '<div class="btn-group">';
            show_data += '<button type="button" class="btn btn-default" onclick="delRelation(\'Lower_' + v[lower_table_abbr + '_id'] + ')"><i class="far fa-trash-alt"></i></button>';
            show_data += '</div>';
          } else if (v1 == lower_table_abbr + '_status') {
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
          } else if (v1 == lower_table_abbr + '_type') {
            show_data = goal_type;
          } else {
            show_data = v[v1];
          }
          ms_lower_relations_table_body_html += '<td>' + show_data + '</td>';
        })

        count_data++;
      })
      console.log(ms_lower_relations_table_body_html);
      //console.log(data['rowcount']);
      $('#ms_lower_relations_table_body').html(ms_lower_relations_table_body_html);

      //目標上層關聯清單
      var count_data = 0;
      var ms_upper_relations_table_body_html = '';
      var table_field = new Array();
      $.each($('.ms_upper_relations_table'), function (k, v) {
        table_field[k] = $(this).attr('id').replace("ms_upper_relations_table_", "");
      })
      $.each(data['row_upper_goal'], function (k, v) {
        var upper_table_abbr = Object.keys(v)[0].substring(0, 3);
        //console.log(upper_table_abbr);
        var goal_type = '';
        switch (upper_table_abbr) {
          case 'ltg':
            goal_type = '長期';
            break;
          case 'mtg':
            goal_type = '中期';
            break;
          case 'stg':
            goal_type = '短期';
            break;
        }

        if (count_data % 2 == 0) {
          ms_upper_relations_table_body_html += '<tr role="row" class="odd">';
        } else {
          ms_upper_relations_table_body_html += '<tr role="row" class="even">';
        }
        var show_data = '';
        $.each(table_field, function (k1, v1) {
          if (v1 != 'edit') {
            v1 = upper_table_abbr + v1.substring(4);
          }
          //console.log(v1);
          if (v1 == 'edit') {
            show_data = '<div class="btn-group">';
            show_data += '<button type="button" class="btn btn-default" onclick="delRelation(\'upper_' + v[upper_table_abbr + '_id'] + ')"><i class="far fa-trash-alt"></i></button>';
            show_data += '</div>';
          } else if (v1 == upper_table_abbr + '_status') {
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
          } else if (v1 == upper_table_abbr + '_type') {
            show_data = goal_type;
          } else {
            show_data = v[v1];
          }
          ms_upper_relations_table_body_html += '<td>' + show_data + '</td>';
        })

        count_data++;
      })
      console.log(ms_upper_relations_table_body_html);
      //console.log(data['rowcount']);
      $('#ms_upper_relations_table_body').html(ms_upper_relations_table_body_html);
    },
    error: function (data) {
      //console.log(ins_val);
      console.log('An error occurred.');
      console.log(data);
    }
  });
}
function getUnconnectedRelationList() {
  var add_level = '';
  $('.level_tabs').each(function (i) {
    if ($(this).hasClass('active')) {
      add_level = $(this).attr('id').substring(0,5);
    }
  });
  var goal_id=$('#goal_id').val();
  var goal_type=$('#goal_type').val();
  
  var sch_val = new Object();
  sch_val['add_level'] = add_level;
  sch_val['goal_id'] = goal_id;
  sch_val['goal_type'] = goal_type;

  var url = "index.php?subSys=MSS&actionType=API&action=MissionAction";
  $.ajax({
    type: "POST",
    url: url,
    dataType: "json",
    data: { data: sch_val, doMissionAction: 'getUnconnectedRelationListByID' }, // serializes the form's elements.
    success: function (data) {
      console.log(data);

      // $('#btnMissionCreate').click();
      // reset();
      // $('#ltg_action').val('UPD');
      // $.each(data['row'][0], function (k, v) {
      //   //console.log(k + ':' + v);
      //   $('#' + k).val(v);
      //   if (k == 'ltg_start_time' || k == 'ltg_end_time') {
      //     $('#' + k).data('daterangepicker').setStartDate(null);
      //     $('#' + k).data('daterangepicker').setStartDate(v);
      //   }

      // });
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
  var url = "index.php?subSys=MSS&actionType=API&action=MissionAction";
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
  $('.form_ins_val').val('');
  $('.form_ins_val').attr('disabled', true);
  $('.form_ins_val').attr('readonly', true);
}

//設定欄位為現在時間
function setTime(field_name) {
  var now = new Date();
  now_format = now.getFullYear() + "-" + (now.getMonth() + 1 < 10 ? '0' : '') + (now.getMonth() + 1) + "-" + (now.getDate() < 10 ? '0' : '') + (now.getDate()) + " " + (now.getHours() < 10 ? '0' : '') + now.getHours() + ":" + (now.getMinutes() < 10 ? '0' : '') + now.getMinutes() + ":" + (now.getSeconds() < 10 ? '0' : '') + now.getSeconds();
  $('#' + field_name).val(now_format);
}

$('#btnRelationsCreate').on('click', function () {
  getUnconnectedRelationList();
})

$('#schGoalType').on('change', function () {
  getRecord(1);
  if ($('#schGoalType').val() != '') {
  }
  //console.log($(this).val());
})

$('.ms_relations_table').not('.no_sort').on('click', function () {
  //console.log($(this).attr('id'));
  if ($(this).hasClass('sorting') || $(this).hasClass('sorting_asc')) {
    $('.ms_relations_table').not('.no_sort').removeClass('sorting sorting_asc sorting_desc');
    $('.ms_relations_table').not('.no_sort').addClass('sorting');
    $(this).removeClass('sorting');
    $(this).addClass('sorting_desc');
  } else {
    $('.ms_relations_table').not('.no_sort').removeClass('sorting sorting_asc sorting_desc');
    $('.ms_relations_table').not('.no_sort').addClass('sorting');
    $(this).removeClass('sorting');
    $(this).addClass('sorting_asc');
  }
  getRecord(1);
})