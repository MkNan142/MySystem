<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Goal Relations Set</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">Goal Relations</li>
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
        <div class="card  card-secondary ">
          <div class="card-header">
            <h3 class="card-title">未關聯任務清單</h3>
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
              <!--button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button-->
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <div class="row">
              <!--div class="col-lg-3 offset-lg-9 col-md-5 offset-md-7 col-sm-7 offset-sm-5 col-9"-->
              <div class="col-sm-2 col-2">
                <button type="button" class="btn btn-default" id="btnGoalRelationsList" data-toggle="modal" data-target="#modal-GoalRelationsList" style="display:none;"><i class="far fa-plus-square"></i> 新建任務</button>
              </div>
              <div class="col-sm-10 col-10">
                <div class="col-xs-12 text-right input-group justify-content-end">
                  <select class="custom-select schMissionForm" id="schGoalType">
                    <option value=""></option>
                    <option value="1">長期</option>
                    <option value="2">中期</option>
                    <option value="3">短期</option>
                    <option value="4">每日</option>
                  </select>
                </div>
              </div>
            </div>
            <!--未關聯任務列表-->
            <div id="ms_relations_table_wrapper" class="dataTables_wrapper dt-bootstrap4">
              <div class="row">
                <div class="col-sm-12">
                  <table id="ms_relations_table" class="table  table-hover dataTable" role="grid" aria-describedby="ms_relations_table_info">
                    <thead>
                      <tr role="row">
                        <th id="ms_relations_table_edit" class="ms_relations_table no_sort" aria-controls="ms_relations_table" rowspan="1" colspan="1">操作</th>
                        <th id="ms_relations_table_goal_type" class="ms_relations_table no_sort" aria-controls="ms_relations_table" rowspan="1" colspan="1">任務類型</th>
                        <th id="ms_relations_table_goal_name" class="ms_relations_table no_sort" aria-controls="ms_relations_table" rowspan="1" colspan="1">任務名稱</th>
                        <th id="ms_relations_table_goal_status" class="ms_relations_table sorting" aria-controls="ms_relations_table" rowspan="1" colspan="1">目前狀態</th>
                        <th id="ms_relations_table_goal_start_time" class="ms_relations_table sorting" aria-controls="ms_relations_table" rowspan="1" colspan="1">開始時間</th>
                        <th id="ms_relations_table_goal_end_time" class="ms_relations_table sorting_desc" aria-controls="ms_relations_table" rowspan="1" colspan="1">結束時間</th>
                      </tr>
                    </thead>
                    <tbody id="ms_relations_table_body">

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
                  <div class="dataTables_info" id="ms_relations_table_info" role="status" aria-live="polite">Showing 1 to 10 of 0 entries</div>
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
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">任務關聯清單</h3>
          </div>
          <!-- ./card-header -->
          <div class="card-body p-0">
            <table class="table table-hover">
              <tbody id="goal_relation_list_expandable_table">
                <tr>
                  <td class="border-0">183</td>
                </tr>
                
                <tr data-widget="expandable-table" aria-expanded="true">
                  <td>
                    <i class="expandable-table-caret fas fa-caret-right fa-fw"></i>
                    219
                  </td>
                </tr>
                <tr class="expandable-body">
                  <td>
                    <div class="p-0">
                      <table class="table table-hover">
                        <tbody>
                          <tr data-widget="expandable-table" aria-expanded="false">
                            <td>
                              <i class="expandable-table-caret fas fa-caret-right fa-fw"></i>
                              219-1
                            </td>
                          </tr>
                          <tr class="expandable-body">
                            <td>
                              <div class="p-0" style="display: none;">
                                <table class="table table-hover">
                                  <tbody>
                                    <tr>
                                      <td>219-1-1</td>
                                    </tr>
                                    <tr>
                                      <td>219-1-2</td>
                                    </tr>
                                    <tr>
                                      <td>219-1-3</td>
                                    </tr>

                                  </tbody>
                                </table>
                              </div>
                            </td>
                          </tr>

                          <tr data-widget="expandable-table" aria-expanded="false">
                            <td>
                              <button type="button" class="btn btn-primary p-0">
                                <i class="expandable-table-caret fas fa-caret-right fa-fw"></i>
                              </button>
                              219-2
                            </td>
                          </tr>
                          <tr class="expandable-body d-none">
                            <td>
                              <div class="p-0" style="display: none;">
                                <table class="table table-hover">
                                  <tbody>
                                    <tr>
                                      <td>219-2-1</td>
                                    </tr>
                                    <tr>
                                      <td>219-2-2</td>
                                    </tr>
                                    <tr>
                                      <td>219-2-3</td>
                                    </tr>
                                  </tbody>
                                </table>
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <td>219-3</td>
                          </tr>

                        </tbody>
                      </table>
                    </div>
                  </td>

                </tr>
              </tbody>
            </table>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
    </div>
  </div><!-- /.container-fluid -->

  <!-- 彈出視窗-關聯表單 -->
  <div class="modal fade" id="modal-GoalRelationsList" style="display: none;" aria-hidden="true" data-keyboard="true">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header bg-secondary ">
          <h4 class="modal-title">Goal Relations List</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <form role="form">
            <div class="row ">
              <div class="col-sm-12">
                <div class="row ">
                  <div class="col-sm-4">
                    <div class="form-group row">
                      <label class="col-sm-4 col-form-label">任務名稱</label>
                      <div class="col-sm-8">
                        <input type="hidden" class="form-control form_ins_val " name="goal_id" id="goal_id" placeholder="任務編號">
                        <input type="text" readonly class="form-control-plaintext form_ins_val" name="goal_name" id="goal_name" value="2022作息調整" placeholder="任務名稱">
                        <!-- <input type="text" class="form-control  notnull" name="stg_name" id="stg_name" placeholder="任務名稱"> -->
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group row">
                      <label class="col-sm-4 col-form-label">任務類型</label>
                      <div class="col-sm-8">
                        <input type="hidden" readonly class="form-control-plaintext form_ins_val" name="goal_type" id="goal_type" value="短期任務" placeholder="任務類型">
                        <input type="text" readonly class="form-control-plaintext form_ins_val" name="goal_type_label" id="goal_type_label" value="短期任務" placeholder="任務類型">
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group row">
                      <label class="col-sm-4 col-form-label">任務狀態</label>
                      <div class="col-sm-8">
                        <input type="text" readonly class="form-control-plaintext form_ins_val" name="goal_status" id="goal_status" value="短期任務" placeholder="任務類型">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-12">
                <div class="row">
                  <div class="col-sm-4 ">
                    <div class="form-group row">
                      <label class="col-sm-4 col-form-label">起始時間</label>
                      <div class="col-sm-8">
                        <input type="text" readonly class="form-control-plaintext form_ins_val" name="goal_start_time" id="goal_start_time" placeholder="起始時間" data-fname="起始時間">
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group row">
                      <label class="col-sm-4 col-form-label">結束時間</label>
                      <div class="col-sm-8">
                        <input type="text" readonly class="form-control-plaintext form_ins_val" name="goal_end_time" id="goal_end_time" placeholder="結束時間" data-fname="結束時間">
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
                  <textarea readonly class="form-control-plaintext form_ins_val notnull" rows="2" name="goal_describe" id="goal_describe" placeholder="詳細任務內容"></textarea>
                </div>
              </div>
            </div>
            <hr />
            <br>
            <ul class="nav nav-tabs" id="myTab" role="tablist">
              <li class="nav-item">
                <a class="nav-link active level_tabs" id="lower-tab" data-toggle="tab" href="#lower" role="tab" aria-controls="lower" aria-selected="false">下層關聯</a>
              </li>
              <li class="nav-item">
                <a class="nav-link level_tabs" id="upper-tab" data-toggle="tab" href="#upper" role="tab" aria-controls="upper" aria-selected="true">上層關聯</a>
              </li>
            </ul>
            <div class="tab-content" id="myTabContent">
              <button type="button" class="btn btn-outline-secondary" id="btnRelationsCreate" data-toggle="modal" data-target="#modal-RelationsCreate"><i class="far fa-plus-square"></i> 新建關聯</button>

              <div class="tab-pane fade show active" id="lower" role="tabpanel" aria-labelledby="lower-tab">
                <div class="col-sm-12">
                  <table id="ms_lower_relations_table" class="table  table-hover dataTable" role="grid" aria-describedby="ms_relations_table_info">
                    <thead>
                      <tr role="row">
                        <th id="ms_lower_relations_table_edit" class="ms_lower_relations_table no_sort" aria-controls="ms_lower_relations_table" rowspan="1" colspan="1">操作</th>
                        <th id="ms_lower_relations_table_goal_type" class="ms_lower_relations_table no_sort" aria-controls="ms_lower_relations_table" rowspan="1" colspan="1">下層類型</th>
                        <th id="ms_lower_relations_table_goal_name" class="ms_lower_relations_table no_sort" aria-controls="ms_lower_relations_table" rowspan="1" colspan="1">任務名稱</th>
                        <th id="ms_lower_relations_table_goal_status" class="ms_lower_relations_table no_sort" aria-controls="ms_lower_relations_table" rowspan="1" colspan="1">目前狀態</th>
                        <th id="ms_lower_relations_table_goal_start_time" class="ms_lower_relations_table no_sort" aria-controls="ms_lower_relations_table" rowspan="1" colspan="1">開始時間</th>
                        <th id="ms_lower_relations_table_goal_end_time" class="ms_lower_relations_table no_sort" aria-controls="ms_lower_relations_table" rowspan="1" colspan="1">結束時間</th>
                      </tr>
                    </thead>
                    <tbody id="ms_lower_relations_table_body">
                      <tr role="row" class="odd">
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="tab-pane fade" id="upper" role="tabpanel" aria-labelledby="upper-tab">
                <div class="col-sm-12">
                  <table id="ms_upper_relations_table" class="table  table-hover dataTable" role="grid" aria-describedby="ms_relations_table_info">
                    <thead>
                      <tr role="row">
                        <th id="ms_upper_relations_table_edit" class="ms_upper_relations_table no_sort" aria-controls="ms_upper_relations_table" rowspan="1" colspan="1">操作</th>
                        <th id="ms_upper_relations_table_goal_type" class="ms_upper_relations_table no_sort" aria-controls="ms_upper_relations_table" rowspan="1" colspan="1">上層類型</th>
                        <th id="ms_upper_relations_table_goal_name" class="ms_upper_relations_table no_sort" aria-controls="ms_upper_relations_table" rowspan="1" colspan="1">任務名稱</th>
                        <th id="ms_upper_relations_table_goal_status" class="ms_upper_relations_table no_sort" aria-controls="ms_upper_relations_table" rowspan="1" colspan="1">目前狀態</th>
                        <th id="ms_upper_relations_table_goal_start_time" class="ms_upper_relations_table no_sort" aria-controls="ms_upper_relations_table" rowspan="1" colspan="1">開始時間</th>
                        <th id="ms_upper_relations_table_goal_end_time" class="ms_upper_relations_table no_sort" aria-controls="ms_upper_relations_table" rowspan="1" colspan="1">結束時間</th>
                      </tr>
                    </thead>
                    <tbody id="ms_upper_relations_table_body">
                      <tr role="row" class="odd">
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" id="btn_moadl_close" data-dismiss="modal">Close</button>
        </div>
      </div>

    </div>

  </div>
  <!-- 彈出視窗-關聯設定 -->
  <div class="modal fade" id="modal-RelationsCreate" style="display: none;" aria-hidden="true" data-keyboard="true">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header bg-secondary ">
          <h4 class="modal-title" id="goal_relation_set_form_title">Goal Relations Set Form</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="col-sm-12">
            <table id="ms_unconnect_relations_table" class="table  table-hover dataTable" role="grid" aria-describedby="ms_relations_table_info">
              <thead>
                <tr role="row">
                  <th id="ms_unconnect_relations_table_edit" class="ms_unconnect_relations_table no_sort" aria-controls="ms_unconnect_relations_table" rowspan="1" colspan="1">操作</th>
                  <th id="ms_unconnect_relations_table_goal_name" class="ms_unconnect_relations_table no_sort" aria-controls="ms_unconnect_relations_table" rowspan="1" colspan="1">任務名稱</th>
                  <th id="ms_unconnect_relations_table_goal_status" class="ms_unconnect_relations_table no_sort" aria-controls="ms_unconnect_relations_table" rowspan="1" colspan="1">目前狀態</th>
                  <th id="ms_unconnect_relations_table_goal_start_time" class="ms_unconnect_relations_table no_sort" aria-controls="ms_unconnect_relations_table" rowspan="1" colspan="1">開始時間</th>
                  <th id="ms_unconnect_relations_table_goal_end_time" class="ms_unconnect_relations_table no_sort" aria-controls="ms_unconnect_relations_table" rowspan="1" colspan="1">結束時間</th>
                </tr>
              </thead>
              <tbody id="ms_unconnect_relations_table_body">
                <tr role="row" class="odd">
                  <td>-</td>
                  <td>-</td>
                  <td>-</td>
                  <td>-</td>
                  <td>-</td>
                  <td>-</td>
                </tr>
              </tbody>
            </table>
          </div>

        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" id="btn_moadl_close" data-dismiss="modal">Close</button>
        </div>
      </div>

    </div>

  </div>
</section>