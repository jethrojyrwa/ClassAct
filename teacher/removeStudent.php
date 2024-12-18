<?php
    session_start();
    require('con1.php');
    $roll_no = $_GET['roll_no'];
    $class_id = $_SESSION['class_id'];
    $delStuSql = "DELETE FROM student_classes WHERE roll_no='$roll_no' AND class_id='$class_id'";
    if($conn->query($delStuSql))
    {
        $updateNoStu = "UPDATE class SET no_students = no_students - 1 WHERE class_id='$class_id'";
        $conn->query($updateNoStu);
        header("Location: viewclass.php");
    }

