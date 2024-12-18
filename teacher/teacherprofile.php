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
    <title>Teacher Profile</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1 class="header">ClassAct - A Classroom Assistant</h1>
    <nav class="nav">
        <a href="teacherhome.php" class="nav-link">Home</a>
        <span>|</span>
        <a href="teacherprofile.php" class="nav-link">Your Profile</a>
        <span>|</span>
        <a href="teacherlogout.php" class="nav-link">Logout</a>
    </nav>

    <?php
        $teachSql = "SELECT t_username,f_name,m_name,l_name,email,ph_no,gender FROM teacher WHERE t_id = $t_id";
        $teachRes = $conn->query($teachSql);
        $teachRow = mysqli_fetch_assoc($teachRes);
        echo "<div class='profile-container'>";
        echo "<table class='profile-table'>";
        echo "<tr>";
        echo "<th colspan=2>Profile</th>";
        echo "</tr>";

        echo "<tr>";
        echo "<td>Username</td>";
        echo "<td>".$teachRow['t_username']."</td>";
        echo "</tr>";

        echo "<tr>";
        echo "<td>Name</td>";
        echo "<td>".$teachRow['f_name']." ".$teachRow['m_name']." ".$teachRow['l_name']."</td>";
        echo "</tr>";

        echo "<tr>";
        echo "<td>Email</td>";
        echo "<td>".$teachRow['email']."</td>";
        echo "</tr>";

        echo "<tr>";
        echo "<td>Phone Number</td>";
        echo "<td>".$teachRow['ph_no']."</td>";
        echo "</tr>";

        echo "<tr>";
        echo "<td>Gender</td>";
        echo "<td>".$teachRow['gender']."</td>";
        echo "</tr>";

        echo "</table>";
        echo "</div>";
    ?>
    <footer>
            <p>&copy; 2024 ClassAct. All rights reserved.</p>
            <p>Created by Jethro Jarvis Roy Jyrwa<br/>
                email: jethrojyrwaroy@gmail.com</p>
        </footer>
</body>
</html>
