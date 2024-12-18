<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Class Details</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
<h1>Student's Answers</h1>
    <nav class="nav">
        <a href="teacherhome.php">Home</a>
        <span>|</span>
        <a href="teacherprofile.php">Your Profile</a>
        <span>|</span>
        <a href="teacherlogout.php">Logout</a>
    </nav>

    <?php
        session_start();
        require('con1.php');
        if(!isset($_SESSION['t_id']))
        {
            header("Location: teacherlog.html");
            exit;
        }
        $room_no = $_GET['room_no'];
        $class_id = $_SESSION['class_id'];

        $roomSql = "SELECT r.date,r.time,r.learning_outcome,c.paper_code,c.paper_name,c.no_students FROM room r, class c WHERE c.class_id = r.class_id AND r.room_no=$room_no AND c.class_id='$class_id'";
        $roomRes = $conn->query($roomSql);
        $roomRow = mysqli_fetch_array($roomRes);
        echo "<div class='class-details'>";
        echo "<p><strong>Class:</strong> ".$roomRow[3].":".$roomRow[4]."</p>";
        echo "<p><strong>Date:</strong> ".$roomRow[0]."</p>";
        echo "<p><strong>Time:</strong> ".$roomRow[1]."</p>";
        echo "<p><strong>Total no. of Students in Class:</strong>".$roomRow[5]."</p>";

        $loSql = "SELECT $roomRow[2] FROM class WHERE class_id ='$class_id'";
        $loRes = $conn->query($loSql);
        $loRow = mysqli_fetch_array($loRes);
        echo "<p><strong>Learning Outcome:</strong> ".$loRow[0]."</p>";
        echo "</div>";
        echo "<hr>";

        $stuSql = "SELECT s.roll_no, s.f_name,s.m_name,s.l_name FROM student s, student_classes sc WHERE s.roll_no = sc.roll_no AND sc.class_id = '$class_id'";
        $stuRes = $conn->query($stuSql);
        while($stuRow=mysqli_fetch_array($stuRes))
        {
            echo "<div class='student-details'>";
            echo "<p><strong>Roll No.:</strong>".$stuRow[0]."</p>";
            echo "<p><strong>Name:</strong>".$stuRow[1]." ".$stuRow[2]." ".$stuRow[3]."</p>";
            $ansSql = "SELECT q.qtn_title,sa.response,q.answerkey FROM question q, student_answers sa WHERE q.qtn_no = sa.qtn_no AND sa.room_no=$room_no AND sa.roll_no = '$stuRow[0]'";
            $ansRes = $conn->query($ansSql);
            echo "<table class='answer-table' border=1>";
            echo "<tr>";
            echo "<th>SlNo</th><th>Question</th><th>Response</th><th>Correct Answer</th>";
            $slno = 1;
            while($ansRow = mysqli_fetch_array($ansRes))
            {
                echo "</tr>";
                echo "<tr>";
                echo "<td>$slno</td>";
                echo "<td>$ansRow[0]</td>";
                if($ansRow[1]==$ansRow[2])
                {
                    echo "<td bgcolor='lightgreen'>$ansRow[1]</td>";
                    echo "<td bgcolor='lightgreen'>$ansRow[2]</td>";
                }
                else
                {
                    echo "<td bgcolor='lightcoral'>$ansRow[1]</td>";
                    echo "<td bgcolor='lightgreen'>$ansRow[2]</td>";
                }
                
                echo "</tr>";
                $slno++;
            }
            echo "</table>";
            echo "</div>";
            
        
        }
        echo "<a href='viewroom.php' class='add-mcq-btn'><button>View All Rooms</button></a>";
    ?>
</body>
</html>
