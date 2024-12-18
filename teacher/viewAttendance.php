<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Student Attendance</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1 class="title">ClassAct - A Classroom Assistant</h1>
    <nav class="nav">
        <a href="teacherhome.php" class="nav-link">Home</a>
        <span class="nav-divider">|</span>
        <a href="teacherprofile.php">Your Profile</a>
        <span>|</span>
        <a href="teacherlogout.php" class="nav-link">Logout</a>
    </nav>

    <?php
        session_start();
        require("con1.php");
        $class_id = $_SESSION['class_id'];
        $roll_no = $_GET['roll_no'];
        echo "<p class='roll-no'>Roll No.: $roll_no</p>";

        $classSql = "SELECT paper_code, paper_name FROM class WHERE class_id = '$class_id'";
        $classRes = $conn->query($classSql);
        $classRow = mysqli_fetch_array($classRes);
        echo "<p class='class-info'>Class: {$classRow[0]}: {$classRow[1]}</p>"; 

        $dateSql = "SELECT room_no, date, time FROM room WHERE class_id = '$class_id' AND date < CURRENT_DATE()";
        $dateRes = $conn->query($dateSql);
        $numPresent = 0;
        
        echo "<table class='attendance-table'>";
        echo "<tr>";
        echo "<th>Date</th><th>Time</th><th>Attendance</th>";
        echo "</tr>";
        while($dateRow = mysqli_fetch_assoc($dateRes))
        {
            echo "<tr>";
            echo "<td>{$dateRow['date']}</td>";
            echo "<td>{$dateRow['time']}</td>";

            $numQsql = "SELECT COUNT(*) FROM question WHERE room_no = {$dateRow['room_no']}";
            $numQres = $conn->query($numQsql);
            $numQrow = mysqli_fetch_array($numQres);

            $numAsql = "SELECT COUNT(*) FROM student_answers WHERE roll_no = '$roll_no' AND room_no={$dateRow['room_no']}";
            $numAres = $conn->query($numAsql);
            $numArow = mysqli_fetch_array($numAres);

            if($numQrow[0] == 0)
            {
                echo "<td class='invalid-attendance'>Invalid, no questions taken</td>";
                
            }
            elseif($numQrow[0] == $numArow[0])
            {
                echo "<td class='present-attendance'>Present</td>";
                $numPresent = $numPresent + 1;
            }
            else
            {
                echo "<td class='absent-attendance'>Absent</td>";
            }
            echo "</tr>";
        }

        echo "<tr>";
        echo "<td colspan='2'>Percentage:</td>";
        echo "<td>".round((($numPresent/$dateRes->num_rows)*100),2)."%</td>";
        echo "</tr>";
        echo "</table>";
    ?>
    <footer>
            <p>&copy; 2024 ClassAct. All rights reserved.</p>
            <p>Created by Jethro Jarvis Roy Jyrwa<br/>
                email: jethrojyrwaroy@gmail.com</p>
        </footer>
</body>
</html>
