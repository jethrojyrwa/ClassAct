<?php
    session_start();
    require('con1.php');
    if(!isset($_SESSION['t_id']))
    {
        header("Location: teacherlog.html");
        exit;
    }
    $room_no=$_SESSION['room_no'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Questions</title>
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
    <a href='addMCQ.php' class='add-mcq-btn'><button >Add MCQ</button></a>
</body>
</html>


<?php
    $vquesSql = "SELECT qtn_no, qtn_title, option1, option2, option3, option4 FROM question WHERE room_no = $room_no";
    $vquesRes = $conn->query($vquesSql);
    if($vquesRes->num_rows > 0)
    {
        $quesNo = 0;
        echo "<div class='question-table'>";
        echo "<table>";
        echo "<tr>";
        echo "<th>Q No</th><th>Question</th><th>Option 1</th><th>Option 2</th><th>Option 3</th><th>Option 4</th><th>Delete</th>";
        echo "</tr>";
        while($vquesRow = mysqli_fetch_assoc($vquesRes))
        {
            $quesNo++;
            $qtn_no = $vquesRow['qtn_no'];
            echo "<tr class='room-btn'>";
            echo "<td>$quesNo</td>";
            echo "<td>".$vquesRow['qtn_title']."</td>";
            echo "<td>".$vquesRow['option1']."</td>";
            echo "<td>".$vquesRow['option2']."</td>";
            echo "<td>".$vquesRow['option3']."</td>";
            echo "<td>".$vquesRow['option4']."</td>";
            echo "<td><a href='deleteMCQ.php?qtn_no=$qtn_no'><button>Delete MCQ</button></a></td>";
            echo "</tr>";
        }
        echo "</table>";
        echo "</div>";
        echo "<a href='viewroom.php' class='add-mcq-btn'><button>View All Rooms</button></a>";
    }