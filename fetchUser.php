<?php  
$conn = mysqli_connect('localhost', 'root', '', 'cmd_db');
if (!$conn) {
	die("DataBase connection faild!".mysqli_connect_error());
}
//echo "OK";
$output = "";
$proceduer = "
	CREATE PROCEDURE fetchUser()
	BEGIN
		SELECT * FROM users1 ORDER BY (id) DESC ; 
	END;
";
if(mysqli_query($conn, "DROP PROCEDURE IF EXISTS fetchUser")){
	if (mysqli_query($conn, $proceduer)) {
		$query = "CALL fetchUser()";
		$result = mysqli_query($conn, $query);
		$output .="<table class='table table-responsive'>
			<thead>
				<tr>
					<th>Fist Name</th>
					<th>Last Name</th>
					<th calspan='2'>Action</th>
				</tr>
			</thead>
			<tbody>
			";


			if (mysqli_num_rows($result)>0) {
				while ($row = mysqli_fetch_assoc($result)) {
					$output .= "<tr>";
						$output .= "<td>";
							$output .= $row['first_name'];
						$output .= "</td>";
						$output .= "<td>";
							$output .= $row['last_name'];
						$output .= "</td>";
						$output .= "<td>";
							$output .= "<button type='button' class='btn btn-success btn-xs edit' name='edit' id=".$row['id'].">Edit</button>";
						$output .= "</td>";
						$output .= "<td>";
							$output .= "<button type='button' class='btn btn-danger btn-xs delete' name='delete' id='".$row['id']."'>Delete</button>";
						$output .= "</td>";
					$output .= "</tr>";
				}
				
			} else {
				$output .="<tr>";
					$output .= "<td>No records found!</td>";
				$output .="</tr>";
			}
		$output .= "</tbody>";
		$output .= "<table>";
		echo $output;
	}
}
?>