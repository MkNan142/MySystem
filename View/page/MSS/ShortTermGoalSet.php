<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Short Term Goal Set</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">Short Term Goal Set</li>
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
            <h3 class="card-title">短期任務清單</h3>
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
              <!--button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button-->
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <div class="row">
              <div class="col-sm-2 col-2">
                <button type="button" class="btn btn-default" id="btnMissionCreate" data-toggle="modal" data-target="#modal-MissionCreate"><i class="far fa-plus-square"></i> 新建任務</button>
              </div>
              <!--div class="col-lg-3 offset-lg-9 col-md-5 offset-md-7 col-sm-7 offset-sm-5 col-9"-->
              <div class="col-sm-10 col-10">
                <div class="col-xs-12 text-right input-group justify-content-end">
                  <select class="custom-select schMissionForm" id="schMissionStatus">
                    <option value=""></option>
                    <option value="0">準備中</option>
                    <option value="1">執行中</option>
                    <option value="5">完成</option>
                    <option value="7">取消</option>
                    <option value="9">刪除</option>
                  </select>
                  <!--input type="text" class="form-control f_input schMissionForm" name="schMissionDateRange" id="schMissionDateRange" placeholder="日期區間" data-fname="日期區間"-->
                </div>
              </div>
            </div>
            <!--交易資料列表-->
            <div id="ms_short_table_wrapper" class="dataTables_wrapper dt-bootstrap4">
              <div class="row">
                <div class="col-sm-12">
                  <table id="ms_short_table" class="table  table-hover dataTable" role="grid" aria-describedby="ms_short_table_info">
                    <thead>
                      <tr role="row">
                        <th id="ms_short_table_edit" class="ms_short_table no_sort" aria-controls="ms_short_table" rowspan="1" colspan="1">操作</th>
                        <th id="ms_short_table_stg_name" class="ms_short_table no_sort" aria-controls="ms_short_table" rowspan="1" colspan="1">任務名稱</th>
                        <th id="ms_short_table_stg_status" class="ms_short_table sorting" aria-controls="ms_short_table" rowspan="1" colspan="1">目前狀態</th>
                        <th id="ms_short_table_stg_start_time" class="ms_short_table sorting" aria-controls="ms_short_table" rowspan="1" colspan="1">開始時間</th>
                        <th id="ms_short_table_stg_end_time" class="ms_short_table sorting" aria-controls="ms_short_table" rowspan="1" colspan="1">結束時間</th>
                        <th id="ms_short_table_stg_create_time" class="ms_short_table sorting_desc" aria-controls="ms_short_table" rowspan="1" colspan="1">建立時間</th>
                      </tr>
                    </thead>
                    <tbody id="ms_short_table_body">

                      <tr role="row" class="odd">
                        <td class="">-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td class="sorting_1">-</td>
                        <td>-</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <!-- 頁數按鈕 -->
              <div class="row">
                <div class="col-sm-12 col-md-5">
                  <div class="dataTables_info" id="ms_short_table_info" role="status" aria-live="polite">Showing 1 to 10 of 0 entries</div>
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
  <div class="modal fade" id="modal-MissionCreate" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header bg-danger">
          <h4 class="modal-title">Short Term Goal Ins/Upd Form</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <form role="form">
            <div class="row">
              <div class="col-sm-12">
                <div class="row">
                  <div class="col-sm-9">
                    <div class="form-group">
                      <label>任務名稱</label>
                      <div class="input-group">
                        <input type="hidden" class="form-control form_ins_val notnull" name="stg_action" id="stg_action" placeholder="表單動作">
                        <!--INS新增 UPD修改-->
                        <input type="hidden" class="form-control form_ins_val " name="stg_id" id="stg_id" placeholder="任務編號">
                        <input type="text" class="form-control form_ins_val notnull" name="stg_name" id="stg_name" placeholder="任務名稱">
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-3">
                    <div class="form-group">
                      <label>任務狀態</label>
                      <div class="input-group">
                        <select class="custom-select form_ins_val notnull" id="stg_status">
                          <option value=""></option>
                          <option value="0">準備中</option>
                          <option value="1">執行中</option>
                          <option value="5">完成</option>
                          <option value="7">取消</option>
                          <option value="9">刪除</option>
                        </select>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-sm-3">
                <div class="row">

                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-12">
                <div class="row">
                  <div class="col-sm-6">
                    <label>起始時間</label>
                    <div class="input-group">
                      <input type="text" class="form-control form_ins_val" name="stg_start_time" id="stg_start_time" placeholder="起始時間" data-fname="起始時間">
                      <div class="input-group-prepend">
                        <button type="button" class="btn btn-success" onclick="setTime('stg_start_time')">Now</button>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <label>結束時間</label>
                    <div class="input-group">
                      <input type="text" class="form-control form_ins_val" name="stg_end_time" id="stg_end_time" placeholder="結束時間" data-fname="結束時間">
                      <div class="input-group-prepend">
                        <button type="button" class="btn btn-success" onclick="setTime('stg_end_time')">Now</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-12">
                <div class="form-group">
                  <label>任務描述</label>
                  <textarea class="form-control form_ins_val notnull" rows="3" name="stg_describe" id="stg_describe" placeholder="在此輸入詳細任務內容描述..."></textarea>
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