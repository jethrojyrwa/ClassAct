<?php

	require("con1.php");
	session_start();

	$qtn_no = $_GET['qtn_no'];
	$sqlQ = "SELECT qtn_no,qtn_title,option1,option2,option3,option4,answerkey,room_no,Active FROM question WHERE qtn_no = $qtn_no";
	$resQ = $conn->query($sqlQ);
	$rowQ = mysqli_fetch_array($resQ);

	$sqlOp1 = "SELECT COUNT(*) FROM student_answers WHERE response = '$rowQ[2]' AND qtn_no=$rowQ[0]";
	$resOp1 = $conn->query($sqlOp1);
	$rowOp1 = mysqli_fetch_array($resOp1);

	$sqlOp2 = "SELECT COUNT(*) FROM student_answers WHERE response = '$rowQ[3]' AND qtn_no=$rowQ[0]";
	$resOp2 = $conn->query($sqlOp2);
	$rowOp2 = mysqli_fetch_array($resOp2);

	$sqlOp3 = "SELECT COUNT(*) FROM student_answers WHERE response = '$rowQ[4]' AND qtn_no=$rowQ[0]";
	$resOp3 = $conn->query($sqlOp3);
	$rowOp3 = mysqli_fetch_array($resOp3);

	$sqlOp4 = "SELECT COUNT(*) FROM student_answers WHERE response = '$rowQ[5]' AND qtn_no=$rowQ[0]";
	$resOp4 = $conn->query($sqlOp4);
	$rowOp4 = mysqli_fetch_array($resOp4);

	$data = array(
		array("label"=>$rowQ[2], "y"=>$rowOp1[0]),
		array("label"=>$rowQ[3], "y"=>$rowOp2[0]),
		array("label"=>$rowQ[4], "y"=>$rowOp3[0]),
		array("label"=>$rowQ[5], "y"=>$rowOp4[0]),
	);

?>
<!DOCTYPE HTML>
	<html>
	<head>
		<title>Graph</title>  
	<script>
	window.onload = function () {
	
	var chart = new CanvasJS.Chart("chartContainer", {
		animationEnabled: true,
		exportEnabled: true,
		theme: "light1", // "light1", "light2", "dark1", "dark2"
		title:{
			text: <?php echo json_encode($rowQ[1], JSON_NUMERIC_CHECK); ?>
		},
		axisY:{
			title: 'Count of Student Response',
			interval: 1
		},
		data: [{
			type: "column", //change type to bar, line, area, pie, etc
			//indexLabel: "{y}", //Shows y value on all Data Points
			indexLabelFontColor: "#5A5757",
			indexLabelPlacement: "outside",   
			dataPoints: <?php echo json_encode($data, JSON_NUMERIC_CHECK); ?>
		}]
	});
	chart.render();
	 
	}
	</script>
	</head>
	<body>
	<div id="chartContainer" style="height: 370px; width: 80%;"></div>
	<script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
	
	</body>
</html>     
