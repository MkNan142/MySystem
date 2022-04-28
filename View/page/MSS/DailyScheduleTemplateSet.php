<!-- 
Daily Schedule Template
DailyScheduleTemplate
ms_daily_schedule
ms_dst_ 
`dst_id`, `dst_name`, `dst_default_goal_relation`, `dst_default_duration`, `dst_default_color`, `dst_order_number`
-->

<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Daily Schedule Template Set</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">Daily Schedule Template Set</li>
        </ol>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card  card-danger ">
          <div class="card-header">
            <h3 class="card-title">常用的日常目標</h3>
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <div class="row">
              <div class="col-sm-2 col-2">
                <button type="button" class="btn btn-default" id="btnDailyScheduleCreate" data-toggle="modal" data-target="#modal-DailyScheduleCreate">
                  <i class="far fa-plus-square"></i> 新建績效指標</button>
              </div>
              <!--div class="col-lg-3 offset-lg-9 col-md-5 offset-md-7 col-sm-7 offset-sm-5 col-9"-->
              <div class="col-sm-10 col-10">
                <div class="col-xs-12 text-right input-group justify-content-end">
                  <!-- <input type="text" class="form-control text-right schDailyScheduleForm" name="sch_dst_name" id="sch_dst_name" placeholder="目標名稱" style="width: 230px;"> -->
                </div>
              </div>
            </div>
            <!--績效指標列表-->
            <div id="ms_daily_schedule_table_wrapper" class="dataTables_wrapper dt-bootstrap4">
              <div class="row">
                <div class="col-sm-12">
                  <table id="ms_daily_schedule_table" class="table  table-hover dataTable" role="grid" aria-describedby="ms_daily_schedule_table_info">
                    <thead>
                      <tr role="row">
                        <th id="ms_daily_schedule_table_edit" class="ms_daily_schedule_table no_sort" aria-controls="ms_daily_schedule_table" rowspan="1" colspan="1">操作</th>
                        <th id="ms_daily_schedule_table_dst_name" class="ms_daily_schedule_table no_sort" aria-controls="ms_daily_schedule_table" rowspan="1" colspan="1">目標名稱</th>
                        <th id="ms_daily_schedule_table_dst_default_goal_relation" class="ms_daily_schedule_table no_sort" aria-controls="ms_daily_schedule_table" rowspan="1" colspan="1">預設關聯</th>
                        <th id="ms_daily_schedule_table_dst_default_duration" class="ms_daily_schedule_table no_sort" aria-controls="ms_daily_schedule_table" rowspan="1" colspan="1">執行時長</th>
                        <th id="ms_daily_schedule_table_dst_default_color" class="ms_daily_schedule_table no_sort" aria-controls="ms_daily_schedule_table" rowspan="1" colspan="1">背景顏色</th>
                      </tr>
                    </thead>
                    <tbody id="ms_daily_schedule_table_body">

                      <tr role="row" class="odd">
                        <td class="">-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <!-- 頁數按鈕 -->
              <div class="row">
                <div class="col-sm-12 col-md-5">
                  <div class="dataTables_info" id="ms_daily_schedule_table_info" role="status" aria-live="polite">Showing 1 to 10 of 0 entries</div>
                </div>
                <div class="col-sm-12 col-md-7">
                  <ul class="pagination float-right">
                    <li class="page-item"><a class="page-link" href="#"> « </a></li>
                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item"><a class="page-link" href="#"> » </a></li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
          <!-- /.card-body -->
        </div>

      </div>
    </div>
    <!-- /.row -->
  </div><!-- /.container-fluid -->

  <!-- 彈出視窗-新增/修改表單 -->
  <div class="modal fade" id="modal-DailyScheduleCreate" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header bg-danger">
          <h4 class="modal-title">Daily Schedule Template Ins/Upd Form</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <form role="form">
            <div class="row">
              <div class="col-sm-6">
                <div class="form-group">
                  <label>目標名稱</label>
                  <div class="input-group">
                    <input type="hidden" class="form-control form_ins_val notnull" name="dst_action" id="dst_action" placeholder="表單動作">
                    <!--INS新增 UPD修改-->
                    <input type="hidden" class="form-control form_ins_val " name="dst_id" id="dst_id" placeholder="指標編號">
                    <input type="text" class="form-control form_ins_val notnull" name="dst_name" id="dst_name" placeholder="指標名稱">
                  </div>
                </div>
              </div>

              <div class="col-sm-2">
                <div class="form-group">
                  <label>執行時長</label>
                  <div class="input-group">
                    <input id="dst_default_duration" type="text" class="form-control form_ins_val notnull" placeholder="時:分">
                  </div>
                </div>
              </div>

              <div class="col-sm-2">
                <div class="form-group">
                  <label>背景顏色</label>
                  <div class="input-group">
                    <input type="color" id="dst_default_color" class="form-control form_ins_val notnull">
                  </div>
                </div>
              </div>

              <div class="col-sm-2">
                <div class="form-group">
                  <label>排序編號</label>
                  <div class="input-group">
                    <input id="dst_order_number" type="number" class="form-control form_ins_val " placeholder="0">
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-12">
                <div class="form-group">
                  <label>建議色彩</label>
                  <div class="input-group">
                    <ul class="fc-color-picker" id="color-chooser">
                      <li><a class="text-maroon" href="#"><i class="fas fa-square"></i></a></li>
                      <li><a class="text-danger" href="#"><i class="fas fa-square"></i></a></li>
                      <li><a class="text-pink" href="#"><i class="fas fa-square"></i></a></li>

                      <!-- <li><a class="text-fuchsia" href="#"><i class="fas fa-square"></i></a></li> -->
                      <li><a class="text-orange" href="#"><i class="fas fa-square"></i></a></li>
                      <li><a class="text-warning" href="#"><i class="fas fa-square"></i></a></li>

                      <li><a class="text-lime" href="#"><i class="fas fa-square"></i></a></li>
                      <li><a class="text-teal" href="#"><i class="fas fa-square"></i></a></li>
                      <li><a class="text-success" href="#"><i class="fas fa-square"></i></a></li>

                      <li><a class="text-olive" href="#"><i class="fas fa-square"></i></a></li>
                      <li><a class="text-info" href="#"><i class="fas fa-square"></i></a></li>
                      <li><a class="text-lightblue" href="#"><i class="fas fa-square"></i></a></li>

                      <li><a class="text-primary" href="#"><i class="fas fa-square"></i></a></li>
                      <li><a class="text-navy" href="#"><i class="fas fa-square"></i></a></li>
                      <li><a class="text-purple" href="#"><i class="fas fa-square"></i></a></li>

                      <li><a class="text-indigo" href="#"><i class="fas fa-square"></i></a></li>
                      <li><a class="text-light" href="#"><i class="fas fa-square"></i></a></li>
                      <li><a class="text-gray" href="#"><i class="fas fa-square"></i></a></li>

                      <li><a class="text-secondary" href="#"><i class="fas fa-square"></i></a></li>
                      <li><a class="text-gray-dark" href="#"><i class="fas fa-square"></i></a></li>
                      <li><a class="text-gray-dark" href="#"><i class="fas fa-square"></i></a></li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-12">
                <div class="row" id="dst_goal_relation_checklist">
                </div>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" id="btn_moadl_close" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" onclick="saveform()">送出</button>
        </div>
      </div>

    </div>

  </div>

</section>