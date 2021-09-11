<?php
error_reporting(0);
include 'DB.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ISM | Exam Completed</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>

<body class="hold-transition sidebar-collapse">
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <img width="262" height="68" src="images/ism-edu.png">
                </li>

            </ul>
            <!-- Right navbar links -->
            <!-- <ul class="navbar-nav ml-auto">
                
                <li class="nav-item">
                    STUDENT NAME:<b><?php echo $_SESSION['name']; ?></b><br>
                    EMAIL:<b><?php echo $_SESSION['email']; ?></b><br>
                    REMAINING EXAM TIME: <b id="time">03:00</b><br>
                </li>
            </ul> -->

        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->


        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Exam Completed</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Exam Completed</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <!-- left column -->
                        <div class="col-md-3"></div>
                        <div class="col-md-6">
                            <!-- Form Element sizes -->
                            <div class="card card-success">
                                <div class="card-header">
                                    <h3 class="card-title">Exam Completed Result</h3>
                                </div>
                                <div class="card-body">
                                    <?php


                                    $conn = DB_Connect();
                                    $query2 = "SELECT * FROM `marks`";
                                    $result2 = $conn->query($query2);
                                    if ($row2 = mysqli_fetch_array($result2)) {
                                        $correctAnsMarks = $row2['correctAnsMarks'];
                                        $wrongAnsMarks = $row2['wrongAnsMarks'];
                                        $notAttempted = $row2['notAttempted'];
                                    }


                                    $email = $_SESSION['email'];
                                    $query = "SELECT * FROM `student_ans` WHERE email='{$email}'";
                                    $result = $conn->query($query);
                                    while ($row = mysqli_fetch_array($result)) {
                                        $ans = $row['ans'];
                                    }
                                    $user_ans_array = explode(",", $ans);

                                    $query3 = "SELECT * FROM `questions`";
                                    $result3 = $conn->query($query3);
                                    $ans_str = '';
                                    $i = 0;
                                    while ($row3 = mysqli_fetch_array($result3)) {
                                        if ($i == 0)
                                            $ans_str .= $row3['qstn_ans'];
                                        else
                                            $ans_str .= ',' . $row3['qstn_ans'];
                                        $i++;
                                    }
                                    $ans_array = explode(",", $ans_str);
                                    //print_r($ans_array);

                                    $total_correct_ans=0;
                                    $total_Wrong_ans=0;
                                    $total_notAttempted=0;
                                    $total_marks = 0;

                                    //print_r($user_ans_array);
                                    for ($i = 0; $i < count($user_ans_array); $i++) {

                                        $temp_arr = explode(':', $user_ans_array[$i]);

                                        //echo $temp_arr[1] . "==" . ($ans_array[$i]) . "<br>";
                                        if ($temp_arr[1] == $ans_array[$i]) {
                                            $total_marks += $correctAnsMarks;
                                            $total_correct_ans++;

                                        } else if ($temp_arr[1] == 0) {
                                            $total_marks += $notAttempted;
                                            $total_notAttempted++;
                                            
                                        } else {
                                            $total_marks += $wrongAnsMarks;
                                            $total_Wrong_ans++;
                                        }
                                    }
                                    echo "<table border='1' style='width:100%'>
                                        <tr align='center'><th>Email</th><th>Not  Attempted</th><th>Wrong Answer</th><th>Correct Answers</th><th>Total Marks</th></tr>
                                        <tr align='center'><td>{$email}</td><td>{$total_notAttempted}</td><td>{$total_Wrong_ans}</td><td>{$correctAnsMarks}</td><td>{$total_marks}</td></tr>
                                    </table>";
                                    //echo $total_marks;

                                    ?>
                                </div>
                                <!-- /.card-body -->
                            </div>

                            <p align="center">
                            <button class="btn btn-success" onclick="window.print()">Print</button>
                            </p>
                        </div>
                        <div class="col-md-3"></div>
                        <!--/.col (left) -->
                        <!-- right column -->

                        <!--/.col (right) -->
                    </div>
                    <!-- /.row -->
                </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <!-- <footer class="main-footer">
            <div class="float-right d-none d-sm-block">
                <b>Version</b> 3.1.0
            </div>
            <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
        </footer> -->

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- bs-custom-file-input -->
    <script src="plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="dist/js/demo.js"></script>
    <!-- Page specific script -->
    <script>
        $(function() {
            bsCustomFileInput.init();
        });
    </script>
</body>

</html>