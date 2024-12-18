<?php
    session_start();
    require('con1.php');
    if(!isset($_SESSION['t_id']))
    {
        header("Location: teacherlog.html");
        exit;
    }
    $t_id=$_SESSION['t_id'];
    $class_id = $_SESSION['class_id'];

    if(isset($_POST['date'],$_POST['time'],$_POST['lo']))
    {   
        
        $currentDate = "SELECT CURRENT_DATE()";
        $currentDateRes = $conn->query($currentDate);
        $currentDateRow = mysqli_fetch_array($currentDateRes);
        if($currentDateRow[0] > $_POST['date'])
        {
            echo "<script type=\"text/javascript\">alert('Invalid Date');
            window.location.replace(\"createroom.php\");</script>";
            exit();
        }
        else
        {
            $date = $_POST['date'];
        }


        $time = $_POST['time'];
        $lo = $_POST['lo'];

        $sql = "INSERT INTO room VALUES(NULL,'$date','$time',$t_id,'$class_id','$lo',0)";
        if($conn->query($sql))
        {
            header("Location: viewroom.php");
        }
        else
        {
            echo 'Could not create room. Try again!';
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create a Room</title>
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

    <form method='post' class="room-form">
    <label for="date">Date:</label>
    <input type='date' name='date' id="date" required>
    <label for="time">Time:</label>
    <input type='time' name='time' id="time" required>
    <label for="lo">This room is for which learning outcome?</label>
    <?php
        $learnSql = "SELECT lo_1,lo_2,lo_3,lo_4,lo_5,lo_6 FROM class WHERE class_id = '$class_id'";
        $learnRes = $conn->query($learnSql);
        $learnRow = mysqli_fetch_array($learnRes);
        $loNo=1;
        for($i=0;$i<5;$i++)
        {
            echo '<div class="radio-option">';
            if(!($learnRow[$i]==NULL ||$learnRow[$i]==''))
            {
                echo '<input type="radio" id="lo_'.$loNo.'" name="lo" value="lo_'.$loNo.'">
                <label for="lo_'.$loNo.'">Learning Outcome'.$loNo.' : '.$learnRow[$i].'</label><br>';
            }
            $loNo++;
        }
        echo "</div>";
    ?>    
    <input type='submit' value='Create Room'>
</form>

    </form>
   
</body>
</html>
