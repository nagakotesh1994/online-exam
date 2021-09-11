<?php
session_start();
//DB Connecting Function (Start)
function DB_Connect()
{
    $server_name = "localhost";
    $username = "root";
    $password = "";
    $dbname = "exam";

    $conn = new mysqli($server_name, $username, $password, $dbname);

    if ($conn->connect_error) {
        echo "Error-Connecting Database:" . $conn->connect_error;
        return false;
    } else {
        return $conn;
    }
}
//DB Connecting Function (End)



//This Sanitize function is used for security (Start)
function Sanitize($FromData)
{
    $conn = DB_Connect();

    foreach ($FromData as $key => $value) {
        if (is_array($value)) {

            Sanitize($value);
        } else {

            $key = strip_tags($key); // Remove HTML
            $value = strip_tags($value); // Remove HTML

            $key = htmlspecialchars($key); // Convert characters
            $value = htmlspecialchars($value); // Convert characters

            $key = trim(rtrim(ltrim($key))); // Remove spaces
            $value = trim(rtrim(ltrim($value))); // Remove spaces

            $key = $conn->real_escape_string($key); // Prevent SQL Injection
            $value = $conn->real_escape_string($value); // Prevent SQL Injection

            $array[$key] = $value;
        }
    }
    return $array;
}
//This Sanitize function is used for security (End)


function Create_User()
{
    $conn = DB_Connect();
    $query = "CREATE TABLE IF NOT EXISTS users (
        `id` INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        `name` VARCHAR(255) NOT NULL,
        `email` VARCHAR(255) NOT NULL,
        `phoneno` VARCHAR(255) NOT NULL,
        `city` VARCHAR(255) NOT NULL,
        `status` VARCHAR(1000) DEFAULT 1,
        reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP)";
    if ($conn->query($query) === TRUE) {
        //echo "Table MyGuests created successfully";
    } else {
        echo "Error creating PG_Hostel table: " . $conn->error;
    }
}

function Insert_User($FromData)
{
    $conn = DB_Connect();
    Create_User();
    $FromData = Sanitize($FromData);
    extract($FromData);
    $query = "INSERT INTO users (`name`, `email`,`phoneno`,`city`) VALUES ('$name','$email','$phoneno','$city')";
    if ($conn->query($query) === TRUE) {
        return 1;
    } else {
        echo "Error creating PG_Hostel table: " . $conn->error;
        return 0;
    }
}


function Get_Users()
{
    $conn = DB_Connect();
    $query="SELECT * FROM `users`";
    $result=$conn->query($query);
    $sno=1;
    $str="";
    while($row=mysqli_fetch_array($result))
    {
        $str.="<tr class='odd'>
        <td class='dtr-control sorting_1' tabindex='0'>{$sno}</td>
        <td>{$row['name']}</td>
        <td>{$row['email']}</td>
        <td>{$row['phoneno']}</td>
        <td>{$row['city']}</td>
    </tr>";
    $sno++;
    }
    return $str;

}



function Create_Subject()
{
    $conn = DB_Connect();
    $query = "CREATE TABLE IF NOT EXISTS subject (
        `id` INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        `subject_name` VARCHAR(255) NOT NULL,
        `no_questions` VARCHAR(255) DEFAULT 0,
        `status` VARCHAR(1000) DEFAULT 1,
        reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP)";
    if ($conn->query($query) === TRUE) {
        //echo "Table MyGuests created successfully";
    } else {
        echo "Error creating subject table: " . $conn->error;
    }
}


function Insert_Subject($FromData)
{
    $conn = DB_Connect();
    Create_Subject();
    $FromData = Sanitize($FromData);
    extract($FromData);
    $query = "INSERT INTO subject (`subject_name`) VALUES ('$subject_name')";
    if ($conn->query($query) === TRUE) {
        return 1;
    } else {
        echo "Error creating Subject table: " . $conn->error;
        return 0;
    }
}


function Get_Subjects()
{
    $conn = DB_Connect();
    $query="SELECT * FROM `subject`";
    $result=$conn->query($query);
    $sno=1;
    $str="";
    if($result!==false)
    {
    while($row=mysqli_fetch_array($result))
    {
        $str.="<tr class='odd'>
        <td class='dtr-control sorting_1' tabindex='0'>{$sno}</td>
        <td>{$row['subject_name']}</td>
        </tr>";
    $sno++;
    }
    return $str;
}
}


function get_sub()
{
    $conn = DB_Connect();
    $query = "SELECT * FROM `subject`";
            $result=$conn->query($query);
            if($result!==false)
            {
            while ($row = mysqli_fetch_array($result)) {
              echo "<li class='nav-item'>
                <a href='pages/layout/top-nav.html' class='nav-link'>
                <i class='fa fa-folder-open' aria-hidden='true'></i>
                  <p>{$row['subject_name']}</p>
                </a>
              </li>";
            }
        }

}



function Create_Questions()
{
    $conn = DB_Connect();
    $query = "CREATE TABLE IF NOT EXISTS questions (
        `id` INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        `sub_id` INT(10) NOT NULL,
        `question_img` VARCHAR(255) NOT NULL,
        `qstn_ans`  INT(10) NOT NULL,
        `status` INT(10) DEFAULT 1,
        reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP)";
    if ($conn->query($query) === TRUE) {
        //echo "Table MyGuests created successfully";
    } else {
        echo "Error creating subject table: " . $conn->error;
    }
}


// Compress image
function compressImage($source, $destination)
{
    $info = getimagesize($source);

    if ($info['mime'] == 'image/jpeg')
        $image = imagecreatefromjpeg($source);

    elseif ($info['mime'] == 'image/gif')
        $image = imagecreatefromgif($source);

    elseif ($info['mime'] == 'image/png')
        $image = imagecreatefrompng($source);

    if ($info > 307200) {
        imagejpeg($image, $destination, 50);   //70
    } else {
        imagejpeg($image, $destination, 30);  //30
    }
}



function Insert_Questions($FromData)
{
    $conn = DB_Connect();
    Create_Questions();

   




    $FromData = Sanitize($FromData);
    extract($FromData);


    $questions_folder = $sub_id;

    @mkdir("qtn_bank/" . $questions_folder,0755, true); // $questions_folder folder mean id of subject

    $question_img = $_FILES["question_img"]["name"];     //getting file extension
    $tmp = explode(".", $question_img);                  //getting file extension
    $question_img_ext = end($tmp);                //getting file extension

    //getting before id + 1
    $query="SELECT * FROM `questions`";
    $result=$conn->query($query);
    $getid=0;
    while($row=mysqli_fetch_array($result))
    {
        $getid=$row['id'];
        
    }
    $getid=$getid+1;  // next id for image file name



    $question_img_com = $getid.".".$question_img_ext;     // getting file name
    $tempname = $_FILES["question_img"]["tmp_name"];
    $folder = "qtn_bank/".$questions_folder."/".$question_img_com;
    //move_uploaded_file($tempname, $folder);
    compressImage($tempname, $folder);


    $query = "INSERT INTO questions (`sub_id`,`question_img`,`qstn_ans`) VALUES ('$sub_id','$folder','$qstn_ans')";
    if ($conn->query($query) === TRUE) {
        return 1;
    } else {
        echo "Error creating Subject table: " . $conn->error;
        return 0;
    }

    
}


function Get_Questions($sub_id)
{
    $conn = DB_Connect();
    $query="SELECT * FROM `questions` WHERE `sub_id`={$sub_id}";
    $result=$conn->query($query);
    $sno=1;
    $str="";
    if($result!==false)
    {
    while($row=mysqli_fetch_array($result))
    {
        $str.="<tr class='odd'>
        <td class='dtr-control sorting_1' tabindex='0'>{$sno}</td>
        <td>{$row['sub_id']}</td>
        <td>{$row['question_img']}</td>
        <td>{$row['qstn_ans']}</td>
        </tr>";
    $sno++;
    }
    return $str;
    }

    
}

function Create_Marks()
{
    $conn = DB_Connect();
    $query = "CREATE TABLE IF NOT EXISTS marks (
        `id` INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        `correctAnsMarks` INT(10) DEFAULT 0,
        `wrongAnsMarks` INT(10) DEFAULT 0,
        `notAttempted` INT(10) DEFAULT 0,
        `time` VARCHAR(255) NOT NULL,
        `status` INT(10) DEFAULT 1,
        reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP)";
    if ($conn->query($query) === TRUE) {
        //echo "Table MyGuests created successfully";
    } else {
        echo "Error creating subject table: " . $conn->error;
    }
}

function Create_Student_ans()
{
    $conn = DB_Connect();
    $query = "CREATE TABLE IF NOT EXISTS student_ans (
        `id` INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        `email` VARCHAR(255) NOT NULL,
        `ans` VARCHAR(2000) NOT NULL,
        reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP)";
    if ($conn->query($query) === TRUE) {
        //echo "Table MyGuests created successfully";
    } else {
        echo "Error creating subject table: " . $conn->error;
    }
}



function Insert_Student_ans($FromData)
{
    $conn = DB_Connect();
    Create_Student_ans();
    $FromData = Sanitize($FromData);
    extract($FromData);
    $query = "INSERT INTO student_ans (`email`, `ans`) VALUES ('$email','$ans')";
    if ($conn->query($query) === TRUE) {
        echo "<script>window.location.href = 'examCompleted.php';</script>";
        return 1;
    } else {
        echo "Error creating student_ans table: " . $conn->error;
        return 0;
    }
}
Create_Marks();
