<?php
include 'DB.php';
if (!isset($_SESSION['email'])) {
    echo "<script>window.location.href = 'index.php';</script>";
}

if (isset($_REQUEST['submit'])) {
    $email=$_SESSION['email'];
    $ans=$_REQUEST['user_ans'];

    $data = array("email"=>$email,"ans"=>$ans);
    Insert_Student_ans($data);

}

$conn = DB_Connect();
$query = "SELECT * FROM `marks`";

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
    <?php
    $query = "SELECT * FROM `subject`";
    $result = $conn->query($query);
    $questions = "";
    $answers = "";
    $i = 1;
    while ($row = mysqli_fetch_array($result)) {
        $id = $row['id'];
        $nq = $row['no_questions'];
        if ($nq > 0) {
            $query1 = "SELECT * FROM `questions` WHERE id='{$id}'";
            $result1 = $conn->query($query1);

            while ($row1 = mysqli_fetch_array($result1)) {
                if ($i == 1) {
                    $questions .= $row1['question_img'];
                    $answers .= $row1['qstn_ans'];
                } else {

                    $questions .= "," . $row1['question_img'];
                    $answers .= "," . $row1['qstn_ans'];
                }
                $i++;
            }
        }
    }
    $questions_array = explode(',', $questions);
    $answers_array = explode(',', $answers);
    //print_r($questions_array);
    //echo "<br>";
    //print_r($answers_array);
    ?>
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
            <div class="col-md-4">

                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Question Numbers</h3>
                    </div>
                    <!-- tabs start -->

                    <div class="tab-content p-4" id="myTabContent">
                        <div class="tab-pane fade show active" id="home" role="tabpanel">
                            <?php

                            for ($i = 0; $i < count($questions_array); $i++) {
                                $num = $i + 1;
                                echo "<a type='button' class='incomplete' data-target='#carouselExampleIndicators' id='ind{$num}' data-slide-to='{$i}' class='active'>{$num}</a>";
                            }
                            ?>

                        </div>
                        <!-- <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                            <?php
                            for ($i = 61; $i <= 120; $i++) {
                                echo "<a type='button' class='incomplete'>{$i}</a>";
                            }
                            ?>

                        </div> -->


                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <?php
                            for ($i = 0; $i < ceil(count($questions_array) / 60); $i++) {
                                if ($i == 0) {
                                    echo "<li class='nav-item navactive1'>
                                    <a class='nav-link active' id='home-tab' data-toggle='tab' href='#home' role='tab' aria-controls='home' aria-selected='true'>Page - 1 </a>
                                    </li>";
                                } else {
                                    echo "<li class='nav-item navactive1'>
                                    <a class='nav-link' id='profile-tab' data-toggle='tab' href='#profile' role='tab' aria-controls='profile' aria-selected='false'>Page - 2</a>
                                    </li>";
                                }
                            }
                            ?>


                        </ul>

                    </div>
                    <!-- tabs end -->
                    <div class="card-footer">
                        <!-- <button type="submit" class="btn btn-primary">Submit</button> -->
                    </div>

                </div>


            </div>


            <div class="col-md-8">
                <!-- general form elements -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Question View</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form action="" method="post">
                        <input type="text" name="user_ans" id="user_ans">
                        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel" data-interval="false">
                            <!-- data-interval="false" -->
                            <!-- <ol class="carousel-indicators">
                                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                                <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                                <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                            </ol> -->
                            <div class="carousel-inner">
                                <?php
                                $i = 1;
                                foreach ($questions_array as $val) {
                                    if ($i == 1) {

                                        echo "<div class='carousel-item active'>
                                        <div class='card-body text-center'>
                                            <img src='admin/{$val}' alt='' class='question'>
                                            <br><br><br>";
                                        for ($j = 1; $j <= 4; $j++) {
                                            echo "<label for=''>{$j}.</label> 
                                            <input type='radio' value='{$j}' onclick='show_qn(this)' class='option' id='{$i}' name='rad{$i}[]'> &nbsp; &nbsp";
                                        }
                                        echo "</div>
                                    </div>";
                                    } else {
                                        echo "<div class='carousel-item'>
                                        <div class='card-body text-center'>
                                            <img src='admin/{$val}' alt=' class='question'>
                                            <br><br><br>";
                                        for ($j = 1; $j <= 4; $j++) {
                                            echo "<label for=''>{$j}.</label> 
                                            <input type='radio' value='{$j}' onclick='show_qn(this)' class='option' id='{$i}' name='rad{$i}[]'> &nbsp; &nbsp";
                                        }

                                        echo "</div>
                                    </div>";
                                    }
                                    $i++;
                                }
                                ?>
                            </div>
                            <!-- <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a> -->
                        </div>





                        <div class="card-body text-center">
                            <p align="center">
                                <a href="#carouselExampleIndicators" role="button" data-slide="prev" class="btn btn-primary">
                                    <i class="fa fa-arrow-circle-left" aria-hidden="true" data-slide="prev"></i>&nbsp;Prev
                                </a>
                                <a href="#carouselExampleIndicators" role="button" data-slide="next" class="btn btn-primary">
                                    Next&nbsp;<i class="fa fa-arrow-circle-right" aria-hidden="true" data-slide="next"></i>
                                </a>
                            </p>
                            <button type="submit" name='submit' class="btn btn-primary">Submit Entire Exam and Close</button>
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


    // $('.carousel').carousel({
    //     interval: 2000
    // })


    function toggleRadio(event) {
        if (event.target.type === 'radio' && event.target.checked === true) {
            setTimeout(() => {
                event.target.checked = false;

            }, 0);
        }
    }
    document.addEventListener('mouseup', toggleRadio);

    <?php
    $qstr = "";
    for ($i = 0; $i < count($questions_array); $i++) {
        if ($i == 0)
            $qstr .= "0";
        else
            $qstr .= ",0";
    }
    echo "var qstr='" . $qstr . "';";

    ?>

    var q_array = qstr.split(',');
    //var ArrToStr = "";

    function show_qn(id) {
        setTimeout(() => {


            var btnid = "ind" + id.id;

            if (id.checked) {
                document.getElementById(btnid).classList.remove("incomplete");
                document.getElementById(btnid).classList.add("complected");
                q_array[id.id - 1] = id.value;
            } else {

                document.getElementById(btnid).classList.remove("complected");
                document.getElementById(btnid).classList.add("incomplete");
                q_array[id.id - 1] = '0';
            }
            //console.log(q_array);
            var ArrToStr = "";
            for (var i = 0; i < q_array.length; i++) {
                if (i == 0)
                    ArrToStr += i + ':' + q_array[i];
                else
                    ArrToStr += ',' + i + ':' + q_array[i];
            }
            console.log(ArrToStr);
            document.getElementById('user_ans').value=ArrToStr;
        }, 0);
    }
</script>
</body>

</html>