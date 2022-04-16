
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Interval Trend</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">Interval Trend</li>
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
        <div class="card card-warning " id="SingleTrendCard">
          <div class="card-header ">
            <h3 class="card-title">單日趨勢</h3>
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
              </button>
              <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
            </div>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-lg-9 col-md-7  col-sm-5 col-3">
                <label id="today_gap"></label>
              </div>
              <!--div class="col-lg-3 offset-lg-9 col-md-5 offset-md-7 col-sm-7 offset-sm-5 col-9"-->
              <div class="col-lg-3 col-md-5 col-sm-7 col-9">
                <div class="col-xs-12 text-right input-group  justify-content-end">
                  <input type="text" class="form-control f_input" name="cost_of_buying_rate"  id="cost_of_buying_rate" placeholder="成本匯率" data-fname="成本匯率">
                  <input type="text" class="form-control f_input" name="cost_of_buying_price"  id="cost_of_buying_price" placeholder="買幣金額" data-fname="買幣金額">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-7 col-md-6  col-sm-5 col-3">
                <label id="today_gap2"></label>
              </div>
              <!--div class="col-lg-3 offset-lg-9 col-md-5 offset-md-7 col-sm-7 offset-sm-5 col-9"-->
              <div class="col-lg-5 col-md-6 col-sm-7 col-9">
                <div class="col-xs-12 text-right input-group justify-content-end" >
                  <input type="text" class="form-control f_input" name="refreshTime"  id="refreshTime" placeholder="刷新時間/秒" data-fname="刷新時間/秒" >
                  <select class="form-control f_input currency_class" name="currency_single" id="currency_single" data-fname="幣別" >
                    <option value=""></option>
                    <option value="AUD" selected>澳幣</option>
                    <option value="USD">美金</option>
                    <option value="CNY">人民幣</option>
                  </select>
                  <button type="button" id="date_single_left_button" class="btn btn-default"><</button>
                  <input type="text" class="form-control f_input" name="date_single"  id="date_single" placeholder="日期" data-fname="日期" >
                  <button type="button" id="date_single_right_button" class="btn btn-default">></button>
                  <input type="text" class="form-control f_input pull-right" name="base_multiple"  id="base_multiple" placeholder="波動基數" data-fname="波動基數" >
                </div>
              </div>
            </div>
            <div class="chart">
              <canvas id="lineChart_single"></canvas>
            </div>
          </div>
          <!-- /.card-body -->
        </div>
        <div class="card card-info " id="RangeTrendCard">
          <div class="card-header ">
            <h3 class="card-title">區間趨勢</h3>
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
              </button>
              <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
            </div>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-lg-8 col-md-7  col-sm-5 col-3">
                <label id="range_gap"></label>
              </div>
              <!--div class="col-lg-3 offset-lg-9 col-md-5 offset-md-7 col-sm-7 offset-sm-5 col-9"-->
              <div class="col-lg-4 col-md-5 col-sm-7 col-9">
                <div class="col-xs-12 text-right input-group  justify-content-end">
                  <input type="text" class="form-control f_input" name="capital"  id="capital" placeholder="本金" data-fname="本金">
                  <select class="form-control f_input currency_class" name="currency" id="currency" data-fname="幣別" >
                    <option value=""></option>
                    <option value="AUD" selected>澳幣</option>
                    <option value="USD">美金</option>
                    <option value="CNY">人民幣</option>
                  </select>
                  <input type="text" class="form-control f_input" name="date_range"  id="date_range" placeholder="日期" data-fname="日期" >
                </div>
              </div>
            </div>
            <div class="chart">
              <canvas id="lineChart"></canvas>
            </div>
          </div>
          <!-- /.card-body -->
        </div>

      </div>
    </div>
    <!-- /.row -->
  </div><!-- /.container-fluid -->
</section>