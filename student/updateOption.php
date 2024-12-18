<?php
    session_start();
    require('con1.php');

    $rollno = $_SESSION['roll_no'];
    $class_id = $_SESSION['class_id'];
    $room_no = $_SESSION['room_no'];
    $qtn_no = $_GET['qtn_no'];    
    $response = $_GET['response'];
    $answer = $_GET['answer'];
    
    $answerSql = "SELECT * FROM student_answers WHERE roll_no = '$rollno' AND qtn_no=$qtn_no";
    $answerRes = $conn->query($answerSql);
    if(!($answerRes->num_rows>0))
    {
        if($response == $answer)
        {
            $sql = "INSERT INTO student_answers VALUES(NULL,'$rollno','$class_id',$room_no,$qtn_no,'$response',1)";
            if($conn->query($sql))
            {
                echo "<script type=\"text/javascript\">alert('Succesfully Answered');
                window.location.replace(\"viewpartstudroom.php\");</script>";
                
            }
            
        }
        else
        {
            $sql = "INSERT INTO student_answers VALUES(NULL,'$rollno','$class_id',$room_no,$qtn_no,'$response',0)";
            if($conn->query($sql))
            {
                echo "<script type=\"text/javascript\">alert('Unuccesfully Answered');
                window.location.replace(\"viewpartstudroom.php\");</script>";
            }
        }
    }
    else
    {
        echo "<script type=\"text/javascript\">alert('Cannot Answer Twice');
                window.location.replace(\"viewpartstudroom.php\");</script>";
    }

    
    
?>