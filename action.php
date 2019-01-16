<?php  
$conn = mysqli_connect('localhost', 'root', '', 'cmd_db');
if (!$conn) {
	die("DataBase connection faild!".mysqli_connect_error());
}

if(isset($_POST['action'])) {
	if($_POST['action']=="Submit") {
		//echo $_POST['lastName'];
		$procedure = "
			CREATE PROCEDURE addUser(IN firstName VARCHAR(250), lastName VARCHAR(250))
			BEGIN
				INSERT INTO users1(first_name, last_name) VALUES (firstName, lastName);
			END;
		";
		if(mysqli_query($conn, "DROP PROCEDURE IF EXISTS addUser")) {
			echo mysqli_error($conn);
			if(mysqli_query($conn, $procedure)) {
				//echo "string";
				$query = "CALL addUser('".$_POST['firstName']."','".$_POST['lastName']."')";
				//$query = "INSERT INTO users1(first_name, last_name) VALUES ('firstName', 'lastName')";
				mysqli_query($conn, $query);
				echo "User Added Successfully.";
			}
		}
	}
	if($_POST['action']=="Edit") {
		//echo $_POST['lastName'];
		$output = array();
		$procedure = "
			CREATE PROCEDURE editUser(IN user_id INT(11))
			BEGIN
				SELECT * FROM users1 WHERE id = user_id;
			END;
		";
		if(mysqli_query($conn, "DROP PROCEDURE IF EXISTS editUser")) {
			echo mysqli_error($conn);
			if(mysqli_query($conn, $procedure)) {
				//echo "string";
				$query = "CALL editUser('".$_POST['user_id']."')";
				//$query = "INSERT INTO users1(first_name, last_name) VALUES ('firstName', 'lastName')";
				$result = mysqli_query($conn, $query);
				if (mysqli_num_rows($result)==1) {
					while($row = mysqli_fetch_array($result)){
						$output['user_id'] = $row['id'];
						$output['first_name'] = $row['first_name'];
						$output['last_name'] = $row['last_name'];

					}
					//print_r($output);
					echo json_encode($output);

				}
					//echo "User Updated Successfully.";
			}
		}
	}
	if($_POST['action']=="Update") {
		//echo $_POST['lastName'];
		$procedure = "
			CREATE PROCEDURE updateUser(IN firstName VARCHAR(250), lastName VARCHAR(250), user_id INT(11))
			BEGIN
				UPDATE users1 SET first_name = firstName, last_name=lastName WHERE id = user_id;
			END;
		";
		if(mysqli_query($conn, "DROP PROCEDURE IF EXISTS updateUser")) {
			echo mysqli_error($conn);
			if(mysqli_query($conn, $procedure)) {
				//echo "string";
				$query = "CALL updateUser('".$_POST['firstName']."','".$_POST['lastName']."','".$_POST['user_id']."')";
				//$query = "INSERT INTO users1(first_name, last_name) VALUES ('firstName', 'lastName')";
				mysqli_query($conn, $query);
				echo "User Updated Successfully.";
			}
		}
	}
	if($_POST['action']=="delete") {
		/*echo $_POST['user_id'];*/
		$procedure = "
			CREATE PROCEDURE deleteUser(IN user_id INT(11))
			BEGIN
				DELETE FROM users1 WHERE id = user_id;
			END;
		";
		if(mysqli_query($conn, "DROP PROCEDURE IF EXISTS deleteUser")) {
			if(mysqli_query($conn, $procedure)) {
				$query = "CALL deleteUser(".$_POST['user_id'].")";
				mysqli_query($conn, $query);
				echo "User Deleted Successfully.";
			}
		}
	}

}

?>