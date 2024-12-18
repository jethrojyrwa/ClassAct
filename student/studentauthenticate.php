<?php
    session_start();
    require('con1.php');

	$roll_no = $_POST['roll_no'];
    $roll_no = strtoupper($roll_no);
    $password = $_POST['password'];
	
	if (empty($roll_no) || empty($password)) {
        echo "Username and password are required.";
        exit();
    }

    

    $sql = "SELECT roll_no,password FROM student where roll_no = '$roll_no' AND password = '$password'";
    $res = $conn->query($sql);

    if ($res->num_rows == 1) {
        $_SESSION['roll_no'] = $roll_no;
        header("Location: studenthome.php");
    } else {
        echo "Invalid credentials.";
    }
?>