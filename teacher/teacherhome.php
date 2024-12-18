<?php
    session_start();
    require('con1.php');
    if(!isset($_SESSION['t_id']))
    {
        header("Location: teacherlog.html");
        exit;
    }
    $t_id = $_SESSION['t_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Home</title>
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
    <?php
        $sql1="SELECT f_name,m_name,l_name FROM teacher WHERE t_id = $t_id";
        $res1 = $conn->query($sql1);
        $row1 = mysqli_fetch_assoc($res1);
        echo "<center><h3>Welcome ".$row1['f_name'].' '.$row1['m_name'].' '.$row1['l_name']."</h3></center>";
        
    ?>
    
    <?php
        $sql2 = "SELECT class_id, paper_code, paper_name FROM class WHERE t_id = $t_id ORDER BY paper_code";
        $res2 = $conn->query($sql2);
        if($res2->num_rows>0){
            echo "<div class='classes'>";
            
            echo "<p>Your Classes:</p>";
            while($row2 = mysqli_fetch_assoc($res2))
            {
                $class_id = $row2['class_id'];
                echo "<div class='class'>";
                echo "<a href='viewclass.php?class_id=$class_id' class='class-link'>".$row2['paper_code'].$row2['paper_name']."</a>";
                echo "</div>";
            }
            echo "</div>";
        }
        else
        {
            echo "<p>You have not created any classes</p>";
        }
        
    ?>
    <br>
    <br>
    <a href='createclass.php' class='create-class-link'><button>Create A Class</button></a>
    
</body>
</html>
