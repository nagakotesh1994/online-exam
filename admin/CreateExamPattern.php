<?php
include '../DB.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Dashboard</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="../plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="../plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="../plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="../plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="../plugins/summernote/summernote-bs4.min.css">

  <link rel="stylesheet" href="../css/style.css">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">

    <!-- Preloader -->
    <!-- <div class="preloader flex-column justify-content-center align-items-center">
      <img class="animation__shake" src="../dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
    </div> -->

    <!-- Navbar -->
    <?php include 'navbar.php'; ?>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <?php include 'sidebar.php'; ?>

    <?php
    if (isset($_REQUEST['submit'])) {
      $sub = $_REQUEST['sub'];
      for ($i = 0; $i < count($sub); $i++) {
        $id = $i + 1;
        $query = "UPDATE `subject` SET `no_questions` = '{$sub[$i]}' WHERE `subject`.`id` = {$id}";
        $conn->query($query);
      }

      // $marks = $_REQUEST['marks'];
      // for($i=0;$i<count($marks);$i++)
      // {
      //   $id=$i+1;
      //   $query = "UPDATE `subject` SET `no_questions` = '{$marks[$i]}' WHERE `subject`.`id` = {$id}";
      //   $conn->query($query);
      // }

      $marks = $_REQUEST['marks'];
      //print_r($marks);
      $query = "UPDATE `marks` SET `correctAnsMarks` = '{$marks[0]}' WHERE `marks`.`id` = 1";
      $conn->query($query);

      $query = "UPDATE `marks` SET `wrongAnsMarks` = '{$marks[1]}' WHERE `marks`.`id` = 1";
      $conn->query($query);

      $query = "UPDATE `marks` SET `notAttempted` = '{$marks[2]}' WHERE `marks`.`id` = 1";
      $conn->query($query);

      $query="UPDATE `marks` SET `time` = '{$_REQUEST['time']}' WHERE `marks`.`id` = 1";
      $conn->query($query);
    }

    ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">Create Exam Pattern</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Dashboard v1</li>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <!-- Small boxes (Stat box) -->

          <!-- /.row -->
          <!-- Main row -->
          <div class="row">

            <div class="col-md-6">
              <!-- general form elements -->
              <div class="card card-primary">
                <div class="card-header">
                  <h3 class="card-title">Add Questions</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form method="post">
                  <div class="card-body">


                    <?php
                    $query = "SELECT * FROM `subject`";
                    $result = $conn->query($query);
                    while ($row = mysqli_fetch_array($result)) {

                      echo "<div class='form-group'>
                      <label for='exampleInputEmail1'>Number of Questions from {$row['subject_name']}</label>
                      <input type='number' class='form-control' name='sub[]' id='exampleInputEmail1'value='{$row['no_questions']}'>
                      </div>";
                    }


                    $query = "SELECT * FROM `marks`";
                    $result = $conn->query($query);
                    $marks = array("Correct Answer", "Wrong Answer", "Not Attempted");

                    if ($row = mysqli_fetch_array($result)) {
                      echo "<div class='form-group'>
                      <label for='exampleInputEmail1'>Enter {$marks[0]} Marks:</label>
                      <input type='number' name='marks[]' class='form-control' id='exampleInputEmail1'value='{$row['correctAnsMarks']}'>
                      </div>";

                      echo "<div class='form-group'>
                      <label for='exampleInputEmail1'>Enter {$marks[1]} Marks:</label>
                      <input type='number'  name='marks[]' class='form-control' id='exampleInputEmail1'value='{$row['wrongAnsMarks']}'>
                      </div>";

                      echo "<div class='form-group'>
                      <label for='exampleInputEmail1'>Enter {$marks[2]} Marks:</label>
                      <input type='number'  name='marks[]' class='form-control' id='exampleInputEmail1'value='{$row['notAttempted']}'>
                      </div>";

                      echo "<div class='form-group'>
                      <label for='exampleInputEmail1'>Exam Time:</label>
                      <div class='row'>
                        <div class='col-3'>
                          <input type='time' name='time' step='1' value='{$row['time']}' class='form-control' placeholder='.col-3'>
                        </div>
                      </div>
                    </div>";

                    }
                    ?>

                    


                  </div>
                  <!-- /.card-body -->

                  <div class="card-footer">
                    <button type="submit" name="submit" class="btn btn-primary float-right">Submit</button>
                  </div>
                </form>
              </div>
              <!-- /.card -->
            </div>




            <!-- right col -->
          </div>
          <!-- /.row (main row) -->
        </div><!-- /.container-fluid -->
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <footer class="main-footer">
      <strong>Copyright &copy; 2014-2021 <a href="#">ISM</a>.</strong>
      All rights reserved.
      <div class="float-right d-none d-sm-inline-block">
        <!-- <b>Version</b> 3.1.0 -->
      </div>
    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
  </div>
  <!-- ./wrapper -->

  <!-- jQuery -->
  <script src="../plugins/jquery/jquery.min.js"></script>
  <!-- jQuery UI 1.11.4 -->
  <script src="../plugins/jquery-ui/jquery-ui.min.js"></script>
  <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
  <script>
    $.widget.bridge('uibutton', $.ui.button)
  </script>
  <!-- Bootstrap 4 -->
  <script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- ChartJS -->
  <script src="../plugins/chart.js/Chart.min.js"></script>
  <!-- Sparkline -->
  <script src="../plugins/sparklines/sparkline.js"></script>
  <!-- JQVMap -->
  <script src="../plugins/jqvmap/jquery.vmap.min.js"></script>
  <script src="../plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
  <!-- jQuery Knob Chart -->
  <script src="../plugins/jquery-knob/jquery.knob.min.js"></script>
  <!-- daterangepicker -->
  <script src="../plugins/moment/moment.min.js"></script>
  <script src="../plugins/daterangepicker/daterangepicker.js"></script>
  <!-- Tempusdominus Bootstrap 4 -->
  <script src="../plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
  <!-- Summernote -->
  <script src="../plugins/summernote/summernote-bs4.min.js"></script>
  <!-- overlayScrollbars -->
  <script src="../plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
  <!-- AdminLTE App -->
  <script src="../dist/js/adminlte.js"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="../dist/js/demo.js"></script>
  <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
  <script src="../dist/js/pages/dashboard.js"></script>
</body>

</html>