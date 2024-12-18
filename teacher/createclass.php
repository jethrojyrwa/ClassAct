<?php
    session_start();
    require('con1.php');
    if(!isset($_SESSION['t_id']))
    {
        header("Location: teacherlog.html");
        exit;
    }
    $t_id = $_SESSION['t_id'];

    if(isset($_POST['paper_code'],$_POST['paper_name'],$_POST['lo_1']))
    {
        $paper_code = $_POST['paper_code'];
        $paper_name = $_POST['paper_name'];
        $lo_1 = $_POST['lo_1'];
        $lo_2 = $_POST['lo_2'];
        $lo_3 = $_POST['lo_3'];
        $lo_4 = $_POST['lo_4'];
        $lo_5 = $_POST['lo_5'];
        $lo_6 = $_POST['lo_6'];

     
        $codeSql = 'SELECT concat(char(round(rand()*25)+97),char(round(rand()*25)+97),char(round(rand()*25)+97),char(round(rand()*25)+97),char(round(rand()*25)+97))';
        $codeRes = $conn->query($codeSql);
        $code = mysqli_fetch_array($codeRes);

        $classSql = "INSERT INTO class VALUES('$code[0]','$paper_code','$paper_name',0,'$t_id','$lo_1','$lo_2','$lo_3','$lo_4','$lo_5','$lo_6')";
        if($conn->query($classSql))
        {
            header("Location: teacherhome.php");
        }
        else
        {
            header("Location: teacherhome.php");
        }
    }
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create A Class</title>
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
    <form method="post" class="class-form">
        <label for="paper_code">Paper Code:</label>
        <input type='text' name='paper_code' id="paper_code" required><br>
        <label for="paper_name">Paper Name:</label>
        <input type='text' name='paper_name' id="paper_name" required><br>
        <label for="lo_1">Learning Outcome 1:</label>
        <input type='text' name='lo_1' id="lo_1" required><br>
        <label for="lo_2">Learning Outcome 2:</label>
        <input type='text' name='lo_2' id="lo_2"><br>
        <label for="lo_3">Learning Outcome 3:</label>
        <input type='text' name='lo_3' id="lo_3"><br>
        <label for="lo_4">Learning Outcome 4:</label>
        <input type='text' name='lo_4' id="lo_4"><br>
        <label for="lo_5">Learning Outcome 5:</label>
        <input type='text' name='lo_5' id="lo_5"><br>
        <label for="lo_6">Learning Outcome 6:</label>
        <input type='text' name='lo_6' id="lo_6"><br>
        <input type='submit' value='Create'>
    </form>
    
</body>
</html>
