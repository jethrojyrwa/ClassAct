<?php
    session_start();
    require('con1.php');

	$t_username = $_POST['teacherusername'];
    $password = $_POST['password'];
	
	if (empty($t_username) || empty($password)) {
        echo "Username and password are required.";
        exit();
    }

    $sql = "SELECT t_id,t_username,password FROM teacher where t_username = '$t_username' AND password = '$password'";
    $res = $conn->query($sql);
    $row = mysqli_fetch_array($res);
    if ($res->num_rows == 1) {
        $_SESSION['t_id'] = $row[0];
        header("Location: teacherhome.php");
    } else {
        echo "<script type=\"text/javascript\">alert('Invalid Credentials');
                window.location.replace(\"teacherlog.html\");</script>";
    }
?>