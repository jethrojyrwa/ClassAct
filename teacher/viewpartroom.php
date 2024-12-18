<?php
    session_start();
    require('con1.php');
    if(!isset($_SESSION['t_id']))
    {
        header("Location: teacherlog.html");
        exit;
    }
    elseif($_SESSION['room_active']!=1)
    {
        header("Location: viewroom.php");
        exit;
    }
    
    $room_no = $_SESSION['room_no'];

    function activateQuestion($qtn_no,$active)
    {
        require('con1.php');
        if($active==0)
        {
            $sql = "UPDATE question SET active = 1 WHERE qtn_no = $qtn_no";
            $conn->query($sql);
        }
        else
        {
            $sql = "UPDATE question SET active = 0 WHERE qtn_no = $qtn_no";
            $conn->query($sql);
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Viewing Room</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
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
        $quesSql = "SELECT qtn_no,qtn_title,option1,option2,option3,option4,active FROM question WHERE room_no = $room_no";
        $quesRes = $conn->query($quesSql);
        if($quesRes->num_rows > 0)
        {
            $quesNo = 0;
            echo "<div class='question-table'>";
            echo "<table>";
            echo "<tr>";
            echo "<th>Q No</th><th>Active</th><th>Display</th><th>No of Responses</th><th>View Graph</th>";
            echo "</tr>";
    
            while($quesRow = mysqli_fetch_assoc($quesRes))
            {
                $quesNo++;
                $qtn_no = $quesRow['qtn_no'];
                $active = $quesRow['active'];
                $respSql = "SELECT COUNT(*) FROM student_answers WHERE qtn_no = $qtn_no";
                $respRes = $conn->query($respSql);
                $respCount = mysqli_fetch_array($respRes);
                echo "<tr class='room-btn'>";
                echo "<td>$quesNo</td>";
                echo "<td><a href='updateActive.php?qtn_no=$qtn_no&active={$quesRow['active']}'>";
                if($quesRow['active']==0)
                {
                    echo "<button>Activate</button></a></td>";
                }
                else
                {
                    echo "<button>Deactivate</button></a></td>";
                }
               
                //MODAL 
                echo'<td>
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#staticBackdrop'.$quesNo.'">
                Display
                </button>

                <!-- Modal -->
                <div class="modal fade" id="staticBackdrop'.$quesNo.'" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel'.$quesNo.'">Question:'.$quesNo.'</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Question: '.$quesRow["qtn_title"].'
                        <br/>Option 1:'.$quesRow["option1"].'
                        <br/>
                        Option 2:'.$quesRow["option2"].'
                        <br/>
                        Option 3:'.$quesRow["option3"].'
                        <br/>
                        Option 4:'.$quesRow["option4"].'
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                    </div>
                </div>
                </div></td>';

                //MODAL
                echo "<td>".$respCount[0]."</td>";
                echo "<td><a href='graph.php?qtn_no=$qtn_no'><button>View Graph</button></a></td>";

                echo "</tr>";
            }
            echo "</table>";
            echo "</div>";
        }
        else
        {
            echo "No Questions Available! Go Back and View Questions to Add";
        }

        echo "<div class='active-students'>";
        echo "<p>Active Students:</p>";
        $studeSql = "SELECT DISTINCT sl_no,roll_no,room_no FROM active_students WHERE room_no = '$room_no'";
        $studeRes = $conn->query($studeSql);
        while($studeRow = mysqli_fetch_assoc($studeRes))
        {
            echo $studeRow['roll_no'];
            echo "<br/>";
        }
        echo "</div>";

        echo "<a href='deactivateroom.php?room_no=$room_no' class='deactivate-room-btn'><button>Deactivate Room</button></a>";
    ?>
</body>
</html>
