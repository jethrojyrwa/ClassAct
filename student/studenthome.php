<?php
    session_start();
    require('con1.php');
    if(!isset($_SESSION['roll_no']))
    {
        header("Location: studentlog.html");
        exit;
    }
    $roll_no = $_SESSION['roll_no'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ClassAct - Student Home</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>ClassAct - A Classroom Assistant</h1>
    <nav class="nav">
        <a href="studenthome.php" class="php-link">Home</a>
        <span>|</span>
        <a href="studentlogout.php" class="php-link">Logout</a>
    </nav>
    <a href="joinaclass.php"><button>Join A New Class</button></a>
    <br/><br/>
    
    <br/>
    <?php
        $classSql = "SELECT c.class_id, t.t_id, c.paper_code, c.paper_name, t.f_name, t.m_name, t.l_name FROM class c, teacher t, student s, student_classes sc WHERE sc.roll_no = s.roll_no AND sc.t_id = t.t_id AND sc.class_id = c.class_id AND sc.roll_no = '$roll_no'";
        $classRes = $conn->query($classSql);
        if($classRes->num_rows>0)
        {
            while($classRow = mysqli_fetch_assoc($classRes))
            {
                $class_id = $classRow['class_id'];
                $t_id = $classRow['t_id'];
                echo "<a href=updateStudentSessionClass.php?class_id=$class_id&t_id=$t_id class='php-link'><button>".$classRow['paper_code']." ".$classRow['paper_name']." - ".$classRow['f_name']." ".$classRow['m_name']." ".$classRow['l_name']."</button></a>";
                echo "<br/>";
            }
        }
        else
        {
            echo "No Classed Joined Yet";
        }
        
    ?>
</body>
</html>
