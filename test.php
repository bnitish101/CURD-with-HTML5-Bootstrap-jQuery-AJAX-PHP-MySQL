<?php  
$conn = mysqli_connect('localhost', 'root', '', 'cmd_db');
if (!$conn) {
	die("DataBase connection faild!".mysqli_connect_error());
}			


	$sql = "SELECT * FROM users1";
	$result = mysqli_query($conn, $sql);

    $row = mysqli_fetch_assoc($result);
        $output[] = $row;
        echo "output in array <br>";
      echo "<pr>";
      print_r($row);
      echo "<br><br><br>";      
    echo " output in json format <br>". $dataJson = json_encode($output);
?>
<div id="result"></div>
<script src= "js/jquery.min.js"></script>
<script>
	if (typeof(Storage) !== "undifined") {
		localStorage.setItem("data_j", "Nitish");
		 document.getElementById("result").innerHTML = localStorage.getItem("data_j");
	}
</script>