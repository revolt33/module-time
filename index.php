<?php
	date_default_timezone_set("Asia/Calcutta");
	include 'process.php';
	echo "
	<html>
	<head>
		<title>Final Project Documentation</title>
		<meta charset='utf-8'>
		<meta http-equiv='X-UA-Compatible' content='IE=edge'>
		<meta name='viewport' content='width=device-width, initial-scale=1'>
		<link rel='stylesheet' type='text/css' href='css/bootstrap.min.css'>
		<script type='text/javascript' src='js/jquery.js' defer></script>
		<script type='text/javascript' src='js/bootstrap.min.js' defer></script>
		<script type='text/javascript' src='script.js' defer></script>
		<style>
			#main {
				margin-top: 50px;
			}
			.marginalise {
				margin-top: 10px;
			}
			.popup {
				display: none;
			}
			.space {
				margin-left: 5px;
			}
		</style>
	</head>
	<body>
		<nav class='nav navbar-inverse'>
			<div class='navbar-header'>
				<a href='#' class='navbar-brand'>Final Project Documentation</a>
			</div>
		</nav>
		<div class='container-fluid' id='main'>
			<div class='col-md-9' id='table-content'>".getData()."</div>
			<div class='col-md-3'>
				<div class='panel panel-primary'>
					<div class='panel-heading'>Add a Task</div>
					<div class='panel-body' >
						<form>
							<input id='task' type='text' placeholder='Name of task' class='form-control' />
							<div class='alert alert-danger marginalise popup'>
								<a href='#' class='close' data-dismiss='alert' area-label='close'>&times;</a>Task name cannot be left empty.
							</div>
							<div class='btn-group btn-group-justified marginalise' role='group'>
								<div class='btn-group' role='group'>
									<button type='button' class='btn btn-primary' id='submit'>Add Task</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</body>
	</html>
	";
?>