<?php

//Include database and Calculator class
include_once 'includes/config.php';
include_once 'class/calculator.class.php';

//Instance
$database = new Database();
$db = $database->connect();
$test = new Calculator($db);

//AJAX request
if(isset($_GET['task'])){
	$task = $_GET['task'];
	$test->calculate($task);
	return;
}
//AJAX request for showing logs (CTRL+A)
if(isset($_GET['action'])){
	$action = $_GET['action'];
	if($action == 'showMeLogs'){
		$test->showMeLogs();
	}
	return;
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Infomedia task</title>
	<meta charset="utf-8">
	<!-- Bootstrap -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
	<!-- jQuery library -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<!-- CSS file -->
	<link rel="stylesheet" type="text/css" href="css/style.css">

</head>
<body>
	<div class="container">
		<?php $test->drawMeTable(); ?>
	</div>
	<div class="logs">
		<table class="table table-striped"></table>
	</div>
	<!-- Javascript file -->
	<script type="text/javascript" src="js/calculator.js"></script>
</body>
</html>