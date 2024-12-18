<?php
    session_start();
    require('con1.php');
    if(!isset($_SESSION['t_id']))
    {
        header("Location: teacherlog.html");
        exit;
    }
        $class_id = $_GET['class_id'];
        $_SESSION['class_id'] = $class_id;
    
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Viewing Class</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
<h1>ClassAct - A Classroom Assistant</h1>
    <nav class="nav">
        <a href="teacherhome.php">Home</a>
        <span>|</span>
        <a href="teacherprofile.php">Your Profile</a>
        <span>|</span>
        <a href="teacherlogout.php">Logout</a>
    </nav>
    <a href='viewroom.php' class="view-rooms-btn"><button>View Rooms</button></a><br><br>
    <?php
    

    $classSql = "SELECT paper_code,paper_name,lo_1,lo_2,lo_3,lo_4,lo_5,lo_6,class_id FROM class WHERE class_id='$class_id'";
    $classRes = $conn->query($classSql);
    $classRow = mysqli_fetch_array($classRes);
    echo "Class: ".$classRow[0].':'.$classRow[1];
    echo "<br/><br/>";
    echo "Code to Join: $classRow[8]";
    echo "<br/>";
    
    $j=2;
    echo "<div class='students-table'>";
    echo "<table border=1>";
    echo "<tr><th colspan=2>LOs:</th></tr>";
    for($i=1;$i<7;$i++)
    {
        if(!($classRow[$j]==NULL || $classRow[$j]==''))
        {
            echo "<tr>";
            echo "<td>Learning Outcome ".$i.":</td><td> ".$classRow[$j]."</td>";
            echo "</tr>";
            echo "<br/>";
        }
        $j++;
    }
    echo "</table>";
    echo "</div>";
    echo "<br/>";
    $sql = "SELECT s.roll_no, s.f_name, s.m_name, s.l_name FROM student s, student_classes sc, class c WHERE s.roll_no = sc.roll_no AND c.class_id = sc.class_id AND sc.class_id = '$class_id' ORDER BY s.roll_no";
    $students = $conn->query($sql);
    if($students->num_rows > 0)
    {
        echo "Students:";
        echo "<div class='students-table'>";
        echo "<table>";
        echo "<tr>";
        echo "<th>Roll No</th><th>Name</th><th>Report</th><th>Attendance</th><th>Remove</th>";
        echo "</tr>";
        while($s = mysqli_fetch_array($students))
        {
            echo "<tr>";
            echo "<td>$s[0]</td><td>$s[1] $s[2] $s[3]</td>";
            echo "<td><a target='_blank' href='generatereport.php?roll_no=$s[0]&name=$s[1]+$s[2]+$s[3]'><button>Generate Report</button></a></td>";
            echo "<td><a target='_blank' href='viewAttendance.php?roll_no=$s[0]'><button>View Attendance</button></a></td>";
            echo "<td><a href='removeStudent.php?roll_no=$s[0]'><button class='remove-student'>Remove Student</button></a></td>";
            echo "</tr>";
        }
        echo "</table>";
        echo "</div>";
    }
    ?>
</body>
</html>
