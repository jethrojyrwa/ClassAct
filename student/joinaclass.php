<?php
    session_start();
    require('con1.php');
    if(!isset($_SESSION['roll_no']))
    {
        header("Location: studentlog.html");
        exit;
    }
    $roll_no = $_SESSION['roll_no'];

    if(isset($_POST['class_id'])) {
        $class_id = $_POST['class_id'];
        $class_id = strtolower($class_id);
        $t_idSql = "SELECT c.t_id FROM teacher t, class c WHERE t.t_id = c.t_id";
        $t_idRes = $conn->query($t_idSql);
        $t_idRow = mysqli_fetch_array($t_idRes);

        $joinSql = "INSERT INTO student_classes VALUES(NULL,'$roll_no','$class_id',$t_idRow[0])";
        if($conn->query($joinSql)) {
            $numUpdate = "UPDATE class SET no_students = no_students + 1 WHERE class_id = '$class_id'";
            $conn->query($numUpdate);
            header("Location: studenthome.php");
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Join Class</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1 class="title">ClassAct - A Classroom Assistant</h1>
    <nav class="nav">
        <a href="studenthome.php" class="nav-link">Home</a>
        <span class="nav-divider">|</span>
        <a href="studentlogout.php" class="nav-link">Logout</a>
    </nav>
    <form method='post' class="join-form">
        <label for="class_id">Enter Code of Class:</label>
        <input type='text' name='class_id' id="class_id" class="class-input" required>
        <input type='submit' value='Join' class="join-button">
    </form>
</body>
</html>
