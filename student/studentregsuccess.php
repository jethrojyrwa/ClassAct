<?php

    require('con1.php');

	if (preg_match('/^[a-zA-Z0-9\/]/', $_POST['rollno']))
	{
		$rollno = $_POST['rollno'];
	}
	else
	{
		echo "<script type=\"text/javascript\">alert('Invalid rollno');
                window.location.replace(\"teacherregister.html\");</script>";
		exit();
	}

	if (preg_match('/^[a-zA-Z]/', $_POST['f_name']))
	{
		$fnm = $_POST['f_name'];
	}
	else
	{
		echo "<script type=\"text/javascript\">alert('Invalid Firstname');
                window.location.replace(\"teacherregister.html\");</script>";
		exit();
	}
	
	
	if (preg_match('/^[a-zA-Z]/', $_POST['l_name']))
	{
		$lnm = $_POST['l_uname'];
	}
	else
	{
		echo "<script type=\"text/javascript\">alert('Invalid Lastname');
                window.location.replace(\"teacherregister.html\");</script>";
		exit();
	}
	
	if(preg_match('/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}/',$_POST['email'] ))
	{
		$em = $_POST['email'];
	}
	else
	{
		echo "<script type=\"text/javascript\">alert('Invalid email');
                window.location.replace(\"teacherregister.html\");</script>";
		exit();
	}
	
	if(preg_match('/^[0-9]{10}/',$_POST['phno'],))
	{
		$ph = $_POST['phno'];
	}
	else
	{
		echo "<script type=\"text/javascript\">alert('Invalid phone number');
                window.location.replace(\"teacherregister.html\");</script>";
		exit();
	}

	$gd = $_POST['gender'];
	$ps = $_POST['passw'];

	if($_POST['mname'] == '')
	{
		$sql = "INSERT INTO student VALUES('$rollno','$fnm',NULL,'$lnm','$em','$ph','$gd','$ps')";
	}
	else{
		if (preg_match('/^[a-zA-Z]$/', $_POST['mname']))
		{
			$mnm = $_POST['mname'];
		}
		else
		{
			echo "<script type=\"text/javascript\">alert('Invalid Firstname');
					window.location.replace(\"teacherregister.html\");</script>";
			exit();
		}
		$sql = "INSERT INTO student VALUES('$rollno','$fnm','$mnm','$lnm','$em','$ph','$gd','$ps')";
	}
	
	
	if(mysqli_query($conn,$sql))
	{
		header("Location: studentlog.html");
	}

	else
	{
		header("Location: studentregister.html");
	}
	