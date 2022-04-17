</div>
<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
  <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- daterangepicker 時間挑選-->
<script src="plugins/moment/moment.min.js"></script>
<script src="plugins/daterangepicker/daterangepicker.js"></script>
<!-- overlayScrollbars 畫面過長時的右側卷軸-->
<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- InputMask 欄位遮罩-->
<script src="plugins/moment/moment.min.js"></script>
<script src="plugins/inputmask/min/jquery.inputmask.bundle.min.js"></script>
<!-- Bootstrap slider 滑動樣式-->
<script src="plugins/bootstrap-slider/bootstrap-slider.min.js"></script>

<!-- ChartJS 畫圖功能-->
<!-- <script src="plugins/chart.js/Chart.min.js"></script> -->
<!-- JQVMap 地圖功能 -->
<!-- <script src="plugins/jqvmap/jquery.vmap.min.js"></script> -->
<!-- <script src="plugins/jqvmap/maps/jquery.vmap.usa.js"></script> -->
<!-- jQuery Knob Chart 旋鈕樣式功能-->
<!-- <script src="plugins/jquery-knob/jquery.knob.min.js"></script> -->
<!-- Tempusdominus Bootstrap 4 時間挑選功能-->
<!-- <script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script> -->
<!-- Sparkline 折線圖功能-->
<!-- <script src="plugins/sparklines/sparkline.js"></script> -->
<!-- DataTables 資料庫限制顯示數量與排序等功能-->
<!-- <script src="plugins/datatables/jquery.dataTables.js"></script> -->
<!-- <script src="plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script> -->
<!-- Summernote 文件編輯功能-->
<!-- <script src="plugins/summernote/summernote-bs4.min.js"></script> -->


<!-- AdminLTE App 主要樣式-->
<script src="dist/js/adminlte.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->

<!-- 其他需要的plugin由該檔案的js引用 -->
<!-- 引入時需要以index的資料夾(如:View/js/MSS/GoalRelations.js)來推算目標資料夾位置 如下兩例-->
<!-- document.write('<script src="dist/js/adminlte.js"></script>'); -->
<!-- document.write('<script src="plugins/datatables/jquery.dataTables.js"></script>'); -->

<?php
if (@$_GET["Content"]) {
  $src = "View/js/" . $_GET['subSys'] . '/' . $_GET["Content"] . ".js";
  $Content = $_GET["Content"];
  //echo "<script>$('.SideBar_" . $Content . "').addClass('active');$('.SideBar_" . $Content . "').parent().parent().parent().addClass('menu-open');$('.SideBar_" . $Content . "').parent().parent().parent().children('a').addClass('active');</script>";
  echo "<script>$('.SideBar_" . $Content . "').addClass('active');$('.SideBar_" . $Content . "').closest('.has-treeview').addClass('menu-open');$('.SideBar_" . $Content . "').closest('.has-treeview').children('a').addClass('active');$('.SideBar_" . $Content . "').closest('.has-treeview').parent().closest('.has-treeview').addClass('menu-open');
  $('.SideBar_" . $Content . "').closest('.has-treeview').parent().closest('.has-treeview').children('a').addClass('active');</script>";
} else {
  $src = "dist/js/pages/dashboard.js";
}
?>
<script src="<?php echo $src; ?>"></script>
<!-- AdminLTE for demo purposes -->
<!-- <script src="dist/js/demo.js"></script> -->

</body>

</html>