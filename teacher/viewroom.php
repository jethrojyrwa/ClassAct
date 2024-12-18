<?php
    session_start();
    require('con1.php');
    if(!isset($_SESSION['t_id']))
    {
        header("Location: teacherlog.html");
        exit;
    }
    $t_id = $_SESSION['t_id'];
    $class_id = $_SESSION['class_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Room</title>
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
    <a href='createroom.php' class="create-room-btn"><button>Create A Room</button></a>
    <br><br>
    <p>Created Rooms:</p>
    <?php
        $roomSql = "SELECT room_no, date, time,learning_outcome FROM room WHERE t_id = $t_id AND class_id = '$class_id'";
        $roomRes = $conn->query($roomSql);
        while($roomRow = mysqli_fetch_assoc($roomRes))
        {
            $room_no = $roomRow['room_no'];
            echo "<div class='room-btn'>";
            echo "<a href='updatesession.php?room_no=$room_no'><button>Date: ".$roomRow['date']." Time: ".$roomRow['time']."</button></a>";
            echo "<span>|</span>";
            echo "<a href='updateSessionQuestions.php?room_no=$room_no'><button>View Questions</button></a>";
            echo "<span>|</span>";
            echo "<a href='viewStudentAnswers.php?room_no=$room_no'><button>View Student Responses</button></a>";
            echo "<span>|</span>";
            echo "<a href='deleteroom.php?room_no=$room_no'><button>Delete Room</button></a>";
            echo "<span>|</span>";
            $lorSql = "SELECT {$roomRow['learning_outcome']} FROM class WHERE class_id='$class_id'";
            $lorRes = $conn->query($lorSql);
            $lorRow = mysqli_fetch_array($lorRes);
            echo "LO: ". $lorRow[0];
            echo "</div>";
        }
    ?>
</body>
</html>
