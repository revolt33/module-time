<?php
	date_default_timezone_set("Asia/Calcutta");
	if ( isset($_POST['data']) ) {
		$data = json_decode($_POST['data']);
		$date = new DateTime();
		$con = selectDatabase();
		$timestamp = $date->getTimestamp();
		$str = "";
		switch ($data->type) {
			case 'add_task':
				$title = $data->values->title;
				$str = "insert into main (title, start, mid, spent, pausecount, mode) values('".$title."', ".$timestamp.", ".$timestamp.", 0, 0, 'b')";
				break;
			case 'pause_task':
				$id = $data->values->id;
				$str = "update main set pausecount=pausecount+1, spent=spent+(".$timestamp."-mid), mode='p' where id=".$id;
				break;
			case 'resume_task':
				$id = $data->values->id;
				$str = "update main set mid=".$timestamp.", mode='b' where id=".$id;
				break;
			case 'stop_task':
				$id = $data->values->id;
				$str = "update main set end=".$timestamp.", spent=(case when mode='b' then spent+(".$timestamp."-mid) else spent end), mode='e' where id=".$id;
				break;
		}
		mysqli_query($con, $str);
		echo getData();
	}
	function getData() {
		$con = selectDatabase();
		$str = "select * from main";
		$query = mysqli_query( $con, $str );
		$str = "
		<table class='table table-striped'>
			<thead>
				<tr>
					<th>#</th>
					<th>Task Name</th>
					<th>Start</th>
					<th>Last Accessed</th>
					<th>End</th>
					<th>Time Lapsed</th>
					<th>Pause Count</th>
				</tr>
			</thead>
			<tbody>
		";
		$spent = 0;
		while ( $row = mysqli_fetch_array( $query ) ) {
			$str .= "
				<tr>
					<td>".$row['id']."</td>
					<td>".$row['title']."</td>
					<td>".date('d M, Y h:i:s A', $row['start'])."</td>
					<td>".date('d M, Y h:i:s A', $row['mid'])."</td>";
			switch ($row['mode']) {
			 	case 'b':
			 		$str .= "
			 		<td><button type='button' class='btn btn-warning pause' actionType='pause_task' serial='".$row['id']."'>Pause</button><button type='button' class='btn btn-danger stop space' actionType='stop_task' serial='".$row['id']."'>Stop</button></td>";
			 		break;
			 	case 'p':
			 		$str .= "
			 		<td><button type='button' class='btn btn-success resume' actionType='resume_task' serial='".$row['id']."'>Resume</button><button type='button' class='btn btn-danger stop space' actionType='stop_task' serial='".$row['id']."'>Stop</button></td>";
			 		break;
		 		case 'e':
		 			$str .= "
		 			<td>".date('d M, Y h:i:s A' , $row['end'])."</td>";
		 			break;
			}
			$str .= "
					<td>".(intval($row['spent']/(60*60))>0?(intval($row['spent']/(60*60))."h "):"").intval(($row['spent']%(60*60))/60)."m ".($row['spent']%60)."s</td>
					<td>".$row['pausecount']."</td>
				</tr>";
			$spent += $row['spent'];
		}
		$str .= "
			</tbody>
			<tfoot>
				<th colspan='3'></th>
				<th>Total time spent:</th>
				<th>".intval($spent/(60*60))."h ".intval(($spent%(60*60))/60)."m ".($spent%60)."s</th>
				<th></th>
			</tfoot>
		</table>
		";
		return $str;
	}
	function selectDatabase() {
		$con= mysqli_connect('localhost','username', 'password') or die('Could not connect to database'); // set your database username and password
		mysqli_select_db($con, ""); //your database name here
		return $con;
	}
?>