<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>My System Dashboard | AdminLTE 3</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Theme style 畫面框架主要樣式-->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- overlayScrollbars 側面板需要-->
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Font Awesome icon樣式-->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Tempusdominus Bbootstrap 4 -->
  <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- bootstrap slider -->
  <link rel="stylesheet" href="plugins/bootstrap-slider/css/bootstrap-slider.min.css">
  <!-- DataTables 資料表格需要用到此樣式-->
  <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.css">
  <!-- Daterange picker 日期挑選-->
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

  <!-- iCheck -->
  <!-- <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css"> -->
  <!-- JQVMap -->
  <!-- <link rel="stylesheet" href="plugins/jqvmap/jqvmap.min.css"> -->
  <!-- summernote 類似於word的文字套件-->
  <!-- <link rel="stylesheet" href="plugins/summernote/summernote-bs4.css"> -->
  <!-- Ionicons -->
  <!-- <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css"> -->

  <!-- 其他需要的plugin由該檔案的css引用 -->
  <!-- 引入時需要以該檔的css資料夾(如:View/css/MSS/GoalRelations.css)來推算目標資料夾位置 如下兩例-->
  <!-- @import "../../../dist/css/adminlte.min.css"; -->
  <!-- @import "../../../plugins/overlayScrollbars/css/OverlayScrollbars.min.css"; -->


  <?php
  if (@$_GET["Content"]) {
    $src = "View/css/" . $_GET['subSys'] . '/'  . $_GET["Content"] . ".css";
    echo '<link href="' . $src . '" rel="stylesheet">';
  }
  ?>

</head>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
    <?php
    include_once 'View/NavBar.php';
    include_once 'View/SideBar.php';
    ?>
    <div class="content-wrapper">
      <!-- /.sidebar -->