<?php
    session_start();
    require('con1.php');
    if(!isset($_SESSION['roll_no']))
    {
        header("Location: studentlog.html");
        exit;
    }
    $t_id = $_SESSION['t_id'];
    $class_id = $_SESSION['class_id'];
    $roll_no = $_SESSION['roll_no'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student's Class</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1 class="title">ClassAct - A Classroom Assistant</h1>
    <nav class="nav">
        <a href="studenthome.php" class="nav-link">Home</a>
        <span class="nav-divider">|</span>
        <a href="studentlogout.php" class="nav-link">Logout</a>
    </nav>
    <p class="intro">Join a Room to interact with questions:</p>
    <?php
        $roomSql = "SELECT room_no, date, time, active FROM room WHERE t_id = $t_id AND class_id = '$class_id'";
        $roomRes = $conn->query($roomSql);
        while($roomRow = mysqli_fetch_assoc($roomRes))
        {
            $room_no = $roomRow['room_no'];
            if($roomRow['active'] == 1)
            {
                echo "<div class='room-button'>";
                echo "<a href='updateSessionStudent.php?room_no=$room_no'><button>Date: " . $roomRow['date'] . " Time: " . $roomRow['time'] . "</button></a>";
                echo "</div>";
            }
        }

        $stuLearnSql = "SELECT paper_code,paper_name,lo_1,lo_2,lo_3,lo_4,lo_5,lo_6 FROM class WHERE class_id='$class_id'";
        $stuLearnRes = $conn->query($stuLearnSql);
        $stuLearnRow = mysqli_fetch_array($stuLearnRes);
        echo "Class: ".$stuLearnRow[0].':'.$stuLearnRow[1];
        echo "<br/><br/>";
        echo "<table border=1>";
        echo "<tr><th colspan=2a>LOs:</th></tr>";

        $teachDeets = "SELECT f_name,m_name,l_name,email,ph_no FROM teacher WHERE t_id = $t_id";
        $teachDeetsRes = $conn->query($teachDeets);
        $teachDeetsRow = mysqli_fetch_assoc($teachDeetsRes);
        echo "Teacher: ".$teachDeetsRow['f_name']." ".$teachDeetsRow['m_name']." ".$teachDeetsRow['l_name'];
        echo "<br/>";
        echo "Email: ".$teachDeetsRow['email'];
        echo "<br/>";
        echo "Phone Number: ".$teachDeetsRow['ph_no'];
        echo "<hr>";

        echo "<div class='students-table'>";
        $j=2;
        for($i=1;$i<7;$i++)
        {
            if(!($stuLearnRow[$j]==NULL || $stuLearnRow[$j]==''))
            {
                echo "<tr><td>Learning Outcome ".$i.":</td><td> ".$stuLearnRow[$j]."</td></tr>";
                
            }
            $j++;
        }
        echo "<br/>";

        echo "<div>";

        echo "<a href='viewAttendance.php' target='_blank'><button '>View My Attendance</button></a>";
        echo "<span>|</span>";
        echo "<a target='_blank' href='generatereport.php?roll_no=$roll_no&class_id=$class_id'><button>View My Class Report</button></a>";
        echo "</div>";

    ?>
</body>
</html>
