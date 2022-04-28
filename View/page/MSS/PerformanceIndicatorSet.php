<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Performance Indicator Set</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">Performance Indicator Set</li>
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
            <h3 class="card-title">績效指標清單</h3>
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
              <!--button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button-->
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <div class="row">
              <div class="col-sm-2 col-2">
                <button type="button" class="btn btn-default" id="btnPerformanceCreate" data-toggle="modal" data-target="#modal-PerformanceCreate"><i class="far fa-plus-square"></i> 新建績效指標</button>
              </div>
              <!--div class="col-lg-3 offset-lg-9 col-md-5 offset-md-7 col-sm-7 offset-sm-5 col-9"-->
              <div class="col-sm-10 col-10">
                <div class="col-xs-12 text-right input-group justify-content-end">
                  <select class="custom-select schPerformanceForm" id="sch_pi_status">
                    <option value="0">計畫中</option>
                    <option value="1" selected>使用中</option>
                    <option value="9">刪除</option>
                  </select>
                  <input type="text" class="form-control text-right schPerformanceForm" name="sch_pi_name" id="sch_pi_name" placeholder="指標名稱" style="width: 230px;">
                </div>
              </div>
            </div>
            <!--績效指標列表-->
            <div id="ms_performance_table_wrapper" class="dataTables_wrapper dt-bootstrap4">
              <div class="row">
                <div class="col-sm-12">
                  <table id="ms_performance_table" class="table  table-hover dataTable" role="grid" aria-describedby="ms_performance_table_info">
                    <thead>
                      <tr role="row">
                        <th id="ms_performance_table_edit" class="ms_performance_table no_sort" aria-controls="ms_performance_table" rowspan="1" colspan="1">操作</th>
                        <th id="ms_performance_table_pi_name" class="ms_performance_table no_sort" aria-controls="ms_performance_table" rowspan="1" colspan="1">指標名稱</th>
                        <th id="ms_performance_table_pi_unit" class="ms_performance_table no_sort" aria-controls="ms_performance_table" rowspan="1" colspan="1">計量單位</th>
                        <th id="ms_performance_table_pi_describe" class="ms_performance_table no_sort" aria-controls="ms_performance_table" rowspan="1" colspan="1">計量描述</th>
                      </tr>
                    </thead>
                    <tbody id="ms_performance_table_body">

                      <tr role="row" class="odd">
                        <td class="">-</td>
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
                  <div class="dataTables_info" id="ms_performance_table_info" role="status" aria-live="polite">Showing 1 to 10 of 0 entries</div>
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
  <div class="modal fade" id="modal-PerformanceCreate" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header bg-danger">
          <h4 class="modal-title">Performance Indicator Ins/Upd Form</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <form role="form">
            <div class="row">
              <div class="col-sm-9">
                <div class="form-group">
                  <label>指標名稱</label>
                  <div class="input-group">
                    <input type="hidden" class="form-control form_ins_val notnull" name="pi_action" id="pi_action" placeholder="表單動作">
                    <!--INS新增 UPD修改-->
                    <input type="hidden" class="form-control form_ins_val " name="pi_id" id="pi_id" placeholder="指標編號">
                    <input type="text" class="form-control form_ins_val notnull" name="pi_name" id="pi_name" placeholder="指標名稱">
                  </div>
                </div>
              </div>

              <div class="col-sm-3">
                <div class="form-group">
                  <label>任務狀態</label>
                  <div class="input-group">
                    <select class="custom-select form_ins_val notnull" id="pi_status">
                      <option value="0">計畫中</option>
                      <option value="1" selected>使用中</option>
                      <option value="2" >已完成</option>
                      <option value="9">刪除</option>
                    </select>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-6">
                <label>計量單位</label>
                <div class="input-group">
                  <input type="text" class="form-control form_ins_val notnull" name="pi_unit" id="pi_unit" placeholder="計量單位">
                </div>
              </div>
              <div class="col-sm-6">
                <label>計量描述</label>
                <div class="input-group">
                  <input type="text" class="form-control form_ins_val notnull" name="pi_describe" id="pi_describe" placeholder="計量描述">
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