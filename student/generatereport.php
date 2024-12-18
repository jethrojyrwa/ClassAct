<?php
    function calculateLearningOutcome($lo,$rollno,$class_id)
    {
        require('con1.php');
        $loSql = "SELECT room_no, date FROM room WHERE learning_outcome = '$lo' AND class_id='$class_id' " ;
        $loRes = $conn->query($loSql);
        $numCorrect = 0;
        $numTotal = 0;
        if(mysqli_num_rows($loRes)>0)
        {
            while($loRow = mysqli_fetch_array($loRes))
            {
                $dateRes = $conn->query("SELECT CURRENT_DATE()");
                $dateRow = mysqli_fetch_array($dateRes);
                if($dateRow[0]>$loRow[1])
                {
                    $sql1 = "SELECT Count(*) FROM student_answers WHERE room_no = $loRow[0] AND result=1 AND roll_no = '$rollno'";
                    $sql1Res = $conn->query($sql1);
                    $sql1Row = mysqli_fetch_array($sql1Res);
                    $numCorrect = $numCorrect + $sql1Row[0];

                    $sql2 = "SELECT Count(*) FROM question Where room_no = $loRow[0]";
                    $sql2Res = $conn->query($sql2);
                    $sql2Row = mysqli_fetch_array($sql2Res);
                    $numTotal = $numTotal + $sql2Row[0];
                }
            }
            if ($numTotal != 0) {
                return (($numCorrect/$numTotal)*100);
            } else {
                return 0; // or any default value you prefer when $numTotal is zero
            }
        }
        else
            return -1;
        
    }
    session_start();
    require('fpdf186/fpdf.php');
    require('con1.php');
    $class_id = $_SESSION['class_id'];
    $rollno = $_GET['roll_no'];
    //$name = $_GET['name'];
    $classSQL = "SELECT paper_code, paper_name,lo_1,lo_2,lo_3,lo_4,lo_5,lo_6 FROM class WHERE class_id = '$class_id'";
    $classRes = $conn->query($classSQL);
    $classRow = mysqli_fetch_array($classRes);

    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial','B',11);
    //$pdf->Cell(40,10,"Name:".$name);
    //$pdf->Ln();
    $pdf->Cell(40,10,"Paper:".$classRow[0]);
    $pdf->Cell(40,10,$classRow[1]);
    $pdf->Ln();
    $pdf->Ln();
    $pdf->Cell(100,10,"Learning Outcomes:",1);
    $pdf->Cell(100,10,"Percentage Accomplished:",1);
    $pdf->Ln();

    if($classRow[2] <> '')
    {
        $lo1Perc = calculateLearningOutcome('lo_1',$rollno,$class_id);
        $y = $pdf->GetY();
        $x = $pdf->GetX();
        $pdf->MultiCell(100,10,"1.".$classRow[2],0,'L');
        $y1 = $pdf->GetY();
        $x1 = $pdf->GetX();
        $pdf->setY($y);
        $pdf->setX($x);
        $pdf->Cell(100,10,'');
        $pdf->Cell(100,10,$lo1Perc.'%',0,0);
        $pdf->Ln(30);
    }

    if($classRow[3] <> '')
    {
        $lo2Perc = calculateLearningOutcome('lo_2',$rollno,$class_id);
        $y = $pdf->GetY();
        $x = $pdf->GetX();
        $pdf->MultiCell(100,10,"2.".$classRow[3],0,'L');
        $y1 = $pdf->GetY();
        $x1 = $pdf->GetX();
        $pdf->setY($y);
        $pdf->setX($x);
        $pdf->Cell(100,10,'');
        $pdf->MultiCell(40,10,$lo2Perc.'%');
        $pdf->Ln();
    }

    if($classRow[4] <> '')
    {
        $lo3Perc = calculateLearningOutcome('lo_3',$rollno,$class_id);
        $y = $pdf->GetY();
        $pdf->MultiCell(100,10,"3.".$classRow[4],0,'L');
        $y1 = $pdf->GetY();
        $pdf->setY($y);
        $pdf->Cell(100,10,'');
        $pdf->MultiCell(40,10,$lo3Perc.'%');
        $pdf->Ln();
    }

    if($classRow[5] <> '')
    {
        $lo4Perc = calculateLearningOutcome('lo_4',$rollno,$class_id);
        $y = $pdf->GetY();
        $pdf->MultiCell(100,10,"4.".$classRow[5],0,'L');
        $y1 = $pdf->GetY();
        $pdf->setY($y);
        $pdf->Cell(100,10,'');
        $pdf->MultiCell(140,10,$lo4Perc.'%');
        $pdf->Ln();
    }

    if($classRow[6] <> '')
    {
        $lo5Perc = calculateLearningOutcome('lo_5',$rollno,$class_id);
        $y = $pdf->GetY();
        $pdf->MultiCell(100,10,"5.".$classRow[6],0,'L');
        $y1 = $pdf->GetY();
        $pdf->setY($y);
        $pdf->Cell(100,10,'');
        $pdf->MultiCell(40,10,$lo5Perc.'%');
        $pdf->Ln();
    }

    if($classRow[7] <> '')
    {
        $lo6Perc = calculateLearningOutcome('lo_6',$rollno,$class_id);
        $y = $pdf->GetY();
        $pdf->MultiCell(100,10,"6.".$classRow[7],0,'L');
        $y1 = $pdf->GetY();
        $pdf->setY($y);
        $pdf->Cell(100,10,'');
        $pdf->Cell(40,10,$lo6Perc.'%');
        $pdf->Ln();
    }

    $pdf->Ln();
    $pdf->Cell(40,10,"N.B.: -1 denotes that classes for that LO have not been taken.");
    $pdf->Output();
?>