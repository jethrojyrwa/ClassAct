<?php
    session_start();
    require('con1.php');
    if(!isset($_SESSION['t_id']))
    {
        header("Location: teacherlog.html");
        exit;
    }
    $room_no = $_SESSION['room_no'];
    if(isset($_POST['qtn_title']))
    {
        $qtn_title = $_POST['qtn_title'];
        $option1 = $_POST['opbox1'];
        $option2 = $_POST['opbox2'];
        $option3 = $_POST['opbox3'];
        $option4 = $_POST['opbox4'];

        $selectedOpbox = $_POST['radio'];
    
        $answer = $_POST[$selectedOpbox];
        echo $answer;
        $sql = "INSERT INTO question VALUES(NULL,'$qtn_title','$option1','$option2','$option3','$option4','$answer',$room_no,0)";
        if($conn->query($sql))
        {
            header("Location: viewQuestions.php");
        }
        else
        {
            echo "<script>windows.alert('Could not Add')";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add MCQ</title>
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
    <form method="post" class="mcq-form">
        <label for="qtn_title">Question Title:</label>
        <input type='text' name='qtn_title' id="qtn_title" required>
        <div>
        <input type="radio" name="radio" value="opbox1">
        <label for="option1">Option 1:</label>
        <input type="text" id="opbox1" name="opbox1" required>
        
        </div>
        <div>
        <input type="radio" name="radio" value="opbox2">
        <label for="option2">Option 2:</label>
        <input type="text" id="opbox2" name="opbox2" required>
        
        </div><div>
        <input type="radio" name="radio" value="opbox3">
        <label for="option3">Option 3:</label>
        <input type="text" id="opbox3" name="opbox3" required>
        
        </div><div>
        <input type="radio" name="radio" value="opbox4">
        <label for="option4">Option 4:</label>
        <input type="text" id="opbox4" name="opbox4" required>
        
        </div>
        <input type='submit' value='Add MCQ'>
    </form>
    
</body>
</html>
