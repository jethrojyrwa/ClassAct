<?php
    session_start();
    require('con1.php');
    if(!isset($_SESSION['roll_no']))
    {
        header("Location: studentlog.html");
        exit;
    }
    
    $room_no = $_SESSION['room_no'];
    $checkRoom = "SELECT active FROM room WHERE room_no=$room_no";
    $checkRes = $conn->query($checkRoom);
    $checkRow = mysqli_fetch_assoc($checkRes);
    if($checkRow['active']==0)
    {
        header("Location: studenthome.php");
        exit;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Student Room</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1 class="title">ClassAct - A Classroom Assistant</h1>
    <nav class="nav">
        <a href="studenthome.php" class="nav-link">Home</a>
        <span class="nav-divider">|</span>
        <a href="studentlogout.php" class="nav-link">Logout</a>
    </nav>
    <?php
        $questSql = "SELECT qtn_no,qtn_title,option1,option2,option3,option4,answerkey,room_no,Active FROM question WHERE room_no = $room_no AND Active=1";
        $questRes = $conn->query($questSql);
        
        //echo "<tr>";
        //echo "<th>Question No</th><th>Option 1</th><th>Option 2</th><th>Option 3</th><th>Option 4</th>";
        //echo "</tr>";

        if($questRes->num_rows > 0) {
            $quesno = 1;
            while($questRow = mysqli_fetch_array($questRes)) {
                if($questRow[8] == 1) { // 8 = active
                    echo '<p class="question-header">Questions</p>';
                    echo "<table class='question-table' border=1>";
                    $qtn_no = $questRow['0']; // 0 = qtn_no
                    echo "<tr>";
                    echo "<td colspan=2>".$quesno."</td>";
                    echo "</tr>";
                    echo "<td width = 100 height=100><a href='updateOption.php?qtn_no=$qtn_no&response=$questRow[2]&answer=$questRow[6]' class='option-link'><button>".$questRow[2]."</button></a></td>"; // 2 = option1
                    echo "<td width = 100 height=100><a href='updateOption.php?qtn_no=$qtn_no&response=$questRow[3]&answer=$questRow[6]' class='option-link'><button>".$questRow[3]."</button></a></td>"; // 3 = option2
                    echo "</tr>";
                    echo "<tr>";
                    echo "<td width = 100 height=100><a href='updateOption.php?qtn_no=$qtn_no&response=$questRow[4]&answer=$questRow[6]' class='option-link'><button>".$questRow[4]."</button></a></td>"; // 4 = option3
                    echo "<td width = 100 height=100><a href='updateOption.php?qtn_no=$qtn_no&response=$questRow[5]&answer=$questRow[6]' class='option-link'><button>".$questRow[5]."</button></a></td>"; // 5 = option4
                    echo "</tr>";
                    $quesno++;
                }
            }
            echo "</table>";
            if(isset($_GET['msg'])) {
                $msg = $_GET['msg'];
                echo "<p class='message'>$msg</p>";
            }
        } else {
            echo "<p class='no-question'>No questions active. Please Wait</p>";
        }
    ?>
    <a href="leaveroom.php" class="leave-room"><button>Leave Room</button></a>
</body>
</html>
