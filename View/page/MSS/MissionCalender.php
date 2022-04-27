<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Calendar</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">Calendar</li>
        </ol>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <button type="button" class="btn btn-default" id="btnDailyScheduleDetial" data-toggle="modal" data-target="#modal-DailyScheduleDetial" style="display:none;">
      <i class="far fa-plus-square"></i>
      新建任務
    </button>
    <div class="row">
      <div class="col-md-3">
        <div class="sticky-top mb-3">
          <div class="card">
            <div class="card-header">
              <h4 class="card-title">日常任務模板</h4>
            </div>
            <div class="card-body">
              <!-- the events -->
              <div id="external-events">
                <!-- <div class="external-event bg-success">Lunch</div>
                <div class="external-event bg-warning">Go home</div>
                <div class="external-event bg-info">Do homework</div>
                <div class="external-event bg-primary">Work on UI design</div>
                <div class="external-event bg-danger">Sleep tight</div> -->
                <!-- <div id='draggableEl' data-event='{ "title": "my event", "duration": "02:00" }'>drag me</div> -->
                <!-- <div class="checkbox">
                  <label for="drop-remove">
                    <input type="checkbox" id="drop-remove">
                    remove after drop
                  </label>
                </div> -->
              </div>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Create Event</h3>
            </div>
            <div class="card-body">
              <div class="btn-group" style="width: 100%; margin-bottom: 10px;">
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
                  <input type="color" id="color_selecter">
                </ul>
              </div>
              <!-- /btn-group -->
              <div class="input-group">
                <input id="new-event" type="text" class="form-control" placeholder="Event Title">
                <input id="duration" type="text" class="form-control col-sm-3" placeholder="持續時間 時:分">
                <div class="input-group-append">
                  <button id="add-new-event" type="button" class="btn btn-primary">Add</button>
                </div>
              </div>
              <!-- /input-group -->

              <div class="row" id="ds_goal_relation_checklist">
                <!-- 新日常目標所要關聯的短期目標 -->
                <div class="form-check col-sm-6">
                  <input class="form-check-input" type="checkbox" id="customCheck1">
                  <label class="form-check-label" for="customCheck1">Checkbox</label>
                </div>
                <div class="form-check col-sm-6">
                  <input class="form-check-input" type="checkbox" checked="">
                  <label class="form-check-label">Checkbox checked</label>
                </div>
                <div class="form-check col-sm-6">
                  <input class="form-check-input" type="checkbox" disabled="">
                  <label class="form-check-label">Checkbox disabled</label>
                </div>

              </div>

            </div>
          </div>
        </div>
      </div>
      <!-- /.col -->
      <div class="col-md-9">
        <div class="card card-primary">
          <div class="card-body p-0">
            <!-- THE CALENDAR -->

            <div id="calendar"></div>
            <div class="loader loader-default ">
            </div>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->

    <!-- 彈出視窗-新增/修改表單 -->
    <div class="modal fade" id="modal-DailyScheduleDetial" style="display: none;" aria-hidden="true">
      <div class="modal-dialog modal-xl">
        <div class="modal-content">
          <div class="modal-header bg-danger">
            <h4 class="modal-title">日常目標內容</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            <form role="form">
              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label>日常目標名稱</label>
                    <div class="input-group">
                      <!--INS新增 UPD修改-->
                      <input type="hidden" class="form-control form_ins_val " name="ds_id" id="ds_id" placeholder="日常目標編號">
                      <input type="text" class="form-control form_ins_val notnull" name="ds_name" id="ds_name" placeholder="日常目標名稱">
                    </div>
                  </div>
                </div>
                <div class="col-sm-3">
                  <div class="form-group">
                    <label>日常目標狀態</label>
                    <div class="input-group">
                      <select class="custom-select form_ins_val notnull" id="ds_status">
                        <option value=""></option>
                        <option value="1">執行中</option>
                        <option value="5">完成</option>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="col-sm-3">
                  <div class="row">
                    <label>背景顏色</label><input type="color" id="modal_color_selecter">
                    <input type="text" class="form-control" id="modal_color_selecter_show_div" placeholder="背景顏色" value="背景顏色" disabled>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-12">
                  <div class="row">
                    <div class="col-sm-6">
                      <label>起始時間</label>
                      <div class="input-group">
                        <input type="text" class="form-control form_ins_val notnull" name="ds_start_time" id="ds_start_time" placeholder="起始時間" data-fname="起始時間">
                        <div class="input-group-prepend">
                          <!-- <button type="button" class="btn btn-success" onclick="setTime('ds_start_time')">Now</button> -->
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <label>結束時間</label>
                      <div class="input-group">
                        <input type="text" class="form-control form_ins_val notnull" name="ds_end_time" id="ds_end_time" placeholder="結束時間" data-fname="結束時間">
                        <div class="input-group-prepend">
                          <!-- <button type="button" class="btn btn-success" onclick="setTime('ds_end_time')">Now</button> -->
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <hr />
              <div class="row">
                <div class="col-sm-12">
                  <div class="row" id="modal_ds_goal_relation_checklist">

                  </div>
                </div>
              </div>
            </form>
          </div>
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-danger" onclick="delEvent()">刪除</button>

            <div class="row">
              <button type="button" class="btn btn-primary btn_submit" onclick="updDailySchedule()">送出</button>
              <button type="button" class="btn btn-default" id="btn_moadl_close" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>

      </div>

    </div>
  </div><!-- /.container-fluid -->
</section>
<!-- /.content -->