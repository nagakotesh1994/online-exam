<?php
include 'DB.php';
if (!isset($_SESSION['email'])) {
    echo "<script>window.location.href = 'index.php';</script>";
}

$conn = DB_Connect();
$query = "SELECT * FROM `marks`";;

$result = $conn->query($query);
if ($row = mysqli_fetch_array($result)) {

    $time_arr = explode(":", $row['time']);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AdminLTE 3 | Log in (v2)</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body class="hold-transition sidebar-collapse" style="background-color: #E9ECEF;">
    <div class="wrapper">
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <img width="262" height="68" src="images/ism-edu.png">
                </li>

            </ul>
            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- Navbar Search -->
                <li class="nav-item">
                    STUDENT NAME:<b><?php echo $_SESSION['name']; ?></b><br>
                    EMAIL:<b><?php echo $_SESSION['email']; ?></b><br>
                    REMAINING EXAM TIME: <b id="time">03:00</b><br>
                </li>
            </ul>




        </nav>

    </div>

    <div class="container-fluid">
        <br>
        <div class="row">
            <div class="col-md-3">

                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Quick Example</h3>
                    </div>
                    <!-- tabs start -->

                    <div class="tab-content p-4" id="myTabContent">
                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                            <?php
                            for ($i = 1; $i <= 60; $i++) {
                                echo "<a type='button' class='complected'>{$i}</a>";
                            }

                            ?>



                        </div>
                        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">

                            <?php
                            for ($i = 61; $i <= 120; $i++) {
                                echo "<a type='button' class='complected'>{$i}</a>";
                            }

                            ?>

                        </div>

                        <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                            <?php
                            for ($i = 121; $i <= 180; $i++) {
                                echo "<a type='button' class='complected'>{$i}</a>";
                            }

                            ?>

                        </div>
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item navactive1">
                                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Page - 1 </a>
                            </li>
                            <li class="nav-item navactive1">
                                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Page - 2</a>
                            </li>
                            <li class="nav-item navactive1">
                                <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Page - 3</a>
                            </li>
                        </ul>



                    </div>
                    <!-- tabs end -->
                    <div class="card-footer">
                        <!-- <button type="submit" class="btn btn-primary">Submit</button> -->
                    </div>

                </div>


            </div>


            <div class="col-md-9">
                <!-- general form elements -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Quick Example</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->

                    <div id="carouselExampleSlidesOnly" class="carousel slide" data-ride="carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img class="d-block w-100" src="..." alt="First slide">
                            </div>
                            <div class="carousel-item">
                                <img class="d-block w-100" src="..." alt="Second slide">
                            </div>
                            <div class="carousel-item">
                                <img class="d-block w-100" src="..." alt="Third slide">
                            </div>
                        </div>
                    </div>



                    <form action="">
                        <div class="card-body text-center">
                            <img src="questions/1.png" alt="" class="question">
                            <br><br><br>
                            <label for="">1.</label> <input type="radio" class="option" id="opt" name="group[]"> &nbsp; &nbsp;
                            <label for="">2.</label> <input type="radio" class="option" id="opt" name="group[]"> &nbsp; &nbsp;
                            <label for="">3.</label> <input type="radio" class="option" id="opt" name="group[]"> &nbsp; &nbsp;
                            <label for="">4.</label> <input type="radio" class="option" id="opt" name="group[]"> &nbsp; &nbsp;

                            <br><br><br><br> <br><br>
                            <p align="center">
                                <a href="" class="btn btn-primary"><i class="fa fa-arrow-circle-left" aria-hidden="true"></i>&nbsp;Prev</a>
                                <a href="" class="btn btn-primary">Next&nbsp;<i class="fa fa-arrow-circle-right" aria-hidden="true"></i></a>&nbsp;
                                <input class="btn btn-primary" type="reset" value="Reset">

                            </p>
                        </div>
                    </form>

                    <!-- /.card-body -->

                    <div class="card-footer">
                        <!-- <button type="submit" class="btn btn-primary">Submit</button> -->
                    </div>

                </div>
                <!-- /.card -->

            </div>



        </div>
    </div>
</body>
<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<script>
    $('.carousel').carousel({
        interval: false,
    });


    var h = <?php echo $time_arr[0]; ?>; // hours
    var m = <?php echo $time_arr[1]; ?>; //min
    var s = <?php echo $time_arr[2]; ?>; //sec
    var intime;



    function timer() {
        if (m == 0 && h > 0) {
            h--;
            m = 59;
        } else if (s == 0) {
            m--;
            s = 59;
        } else {
            s--;
        }

        if (h == 0 && m == 0 && s == 0) {
            //submit form when it is 0
            clearInterval(intime);
        }

        document.getElementById("time").innerHTML = h + ":" + m + ":" + s;
    }
    intime = setInterval(function() {
        timer();
    }, 1000);


    $('.carousel').carousel({
  interval: 2000
})


</script>
</body>

</html>