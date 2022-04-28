var now_format = '';

$(function () {
    //取得任務清單
    getRecord(1);
})

//取得任務清單
function getRecord(pageNum) {
    var sch_val = new Object();
    sch_val['pi_name'] = $('#sch_pi_name').val();
    sch_val['pi_status'] = $('#sch_pi_status').val();

    sch_val['orderby'] = '';//預設排序欄位為空白
    sch_val['Inverted'] = 'desc';//預設排序為asc
    $.each($('.ms_performance_table'), function (k, v) {
        if (!$(this).hasClass('sorting')) {
            if ($(this).hasClass('sorting_asc')) {
                sch_val['orderby'] = $(this).attr('id').replace("ms_performance_table_", "");
                sch_val['Inverted'] = 'asc';
            } else if ($(this).hasClass('sorting_desc')) {
                sch_val['orderby'] = $(this).attr('id').replace("ms_performance_table_", "");
                sch_val['Inverted'] = 'desc';
            }
        }
    })
    sch_val['pageNum'] = pageNum;
    console.log(sch_val);
    var url = "index.php?subSys=MSS&actionType=API&action=MissionAction";
    $.ajax({
        type: "POST",
        url: url,
        dataType: "json",
        data: { data: sch_val, doMissionAction: 'getPerformanceIndicator' },
        success: function (data) {
            console.log(data);
            var count_data = 0;
            var ms_performance_table_body_html = '';
            var table_field = new Array();
            $.each($('.ms_performance_table'), function (k, v) {
                table_field[k] = $(this).attr('id').replace("ms_performance_table_", "");
            })
            $.each(data['row'], function (k, v) {

                if (count_data % 2 == 0) {
                    ms_performance_table_body_html += '<tr role="row" class="odd">';
                } else {
                    ms_performance_table_body_html += '<tr role="row" class="even">';
                }
                var show_data = '';
                $.each(table_field, function (k1, v1) {
                    if (v1 == 'edit') {
                        show_data = '<div class="btn-group">';
                        show_data += '<button type="button" class="btn btn-default" onclick="editPerformance(' + v['pi_id'] + ')"><i class="far fa-edit"></i></button>';
                        show_data += '<button type="button" class="btn btn-default" onclick="delPerformance(' + v['pi_id'] + ')"><i class="far fa-trash-alt"></i></button>';
                        show_data += '</div>';
                    } else {
                        show_data = v[v1];
                    }
                    ms_performance_table_body_html += '<td>' + show_data + '</td>';
                })

                count_data++;
            })
            //console.log(ms_performance_table_body_html);
            //console.log(data['rowcount']);
            $('#ms_performance_table_body').html(ms_performance_table_body_html);
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
            $('#ms_performance_table_info').html('Showing ' + parseInt((pageNum - 1) * 10 + 1) + ' to ' + pageNum * 10 + ' of ' + data['rowcount'] + ' entries');
            $('.pagination').html(pagination_html);
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
    if (!form_check) {
        return 0;
    }
    var ins_val = new Object();
    $('.form_ins_val').each(function () {
        //console.log($(this).attr('type'));
        ins_val[$(this).attr('id')] = $(this).val();
    })
    //console.log(ins_val);
    var doPerformanceAction = '';
    var FinishAlert = '';
    if ($('#pi_action').val() == 'INS') {
        doPerformanceAction = 'insPerformanceIndicator';
        FinishAlert = '新增完成';
    } else if ($('#pi_action').val() == 'UPD') {
        doPerformanceAction = 'updPerformanceIndicator';
        FinishAlert = '修改完成';
    }
    //return false;
    var url = "index.php?subSys=MSS&actionType=API&action=MissionAction";
    $.ajax({
        type: "POST",
        url: url,
        dataType: "json",
        data: { data: ins_val, doMissionAction: doPerformanceAction },
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

function editPerformance(pi_id) {
    var sch_val = new Object();
    sch_val['pi_id'] = pi_id;
    var url = "index.php?subSys=MSS&actionType=API&action=MissionAction";
    $.ajax({
        type: "POST",
        url: url,
        dataType: "json",
        data: { data: sch_val, doMissionAction: 'getPerformanceIndicatorByID' }, // serializes the form's elements.
        success: function (data) {
            $('#btnPerformanceCreate').click();
            reset();
            $('#pi_action').val('UPD');
            $.each(data['row'][0], function (k, v) {
                $('#' + k).val(v);
            });
        },
        error: function (data) {
            //console.log(ins_val);
            console.log('An error occurred.');
            console.log(data);
        }
    });
}
function delPerformance(pi_id) {
    if (!confirm('確定要刪除嗎?')) {
        return 0;
    }
    var sch_val = new Object();
    sch_val['pi_id'] = pi_id;
    var url = "index.php?subSys=MSS&actionType=API&action=MissionAction";
    $.ajax({
        type: "POST",
        url: url,
        dataType: "json",
        data: { data: sch_val, doMissionAction: 'delPerformanceIndicatorByID' }, // serializes the form's elements.
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

    $('#pi_status').val('0');
    $('#pi_start_time').val(now_format);
    $('#pi_action').val('INS');
}


$('#btnMissionCreate').on('click', function () {
    reset();
    $('#pi_action').val('INS');
})

$('#sch_pi_name,#sch_pi_status').on('change', function () {
    getRecord(1);
})

$('.ms_performance_table').not('.no_sort').on('click', function () {
    //console.log($(this).attr('id'));
    if ($(this).hasClass('sorting') || $(this).hasClass('sorting_asc')) {
        $('.ms_performance_table').not('.no_sort').removeClass('sorting sorting_asc sorting_desc');
        $('.ms_performance_table').not('.no_sort').addClass('sorting');
        $(this).removeClass('sorting');
        $(this).addClass('sorting_desc');
    } else {
        $('.ms_performance_table').not('.no_sort').removeClass('sorting sorting_asc sorting_desc');
        $('.ms_performance_table').not('.no_sort').addClass('sorting');
        $(this).removeClass('sorting');
        $(this).addClass('sorting_asc');
    }
    getRecord(1);
})