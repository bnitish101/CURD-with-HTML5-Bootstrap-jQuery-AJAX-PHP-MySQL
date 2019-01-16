<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Chalange</title>
	<link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
	<div class="container">
		<div class="col-md-8 col-md-offset-2">
			<h3 align="center">User Details</h3>
			<label for="first_name">Frist Name</label>
			<input type="text" id="first_name" name="first_name" class="form-control">
			<br><br>
			<label for="last_name">Last Name</label>
			<input type="text" id="last_name" name="last_name" class="form-control">
			<br><br>
			<input type="hidden" id="user_id" name="user_id">
			<button type="button" id="clear" name="clear" class="btn btn-warning">Clear</button>
			<button type="button" name="submit" id="submit" class="btn btn-info">Submit</button>
			<br>
			<div id="message">
				
			</div>
			<br>

			<div id="result" class="table responsive-table">
				
			</div>
		</div>
		

	</div>
	<script src= "js/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			//alert("OK");
			fetchUser();
			function fetchUser(){
				$.ajax({
					url: "fetchUser.php",
					type: "POST",
					success: function(data) {
						$('#result').html(data);
					}
				});
			}
			$(document).on('click', '#submit', function(){
				var firstName = $('#first_name').val();
				var lastName = $('#last_name').val();
				var user_id = $('#user_id').val();
				var action = $('#submit').text();
				if(firstName!='' && lastName!='') {	
					$.ajax({
						type: "POST",
						url: "action.php",
						data:{firstName:firstName, lastName:lastName, action:action, user_id:user_id},
						success: function(data) {
							$('#first_name').val('');
							$('#last_name').val('');
							$('#submit').text("Submit");
							$('#clear').text("Clear");
							fetchUser();
							alert(data);

						}
					});
				} else {
					alert("Please Fill All The Fields!");
				}
			});
			$(document).on('click', '.edit', function(){
				//var firstName = $('#first_name').val();
				//var lastName = $('#last_name').val();
				var user_id = $(this).attr('id');
				var action = $(this).text();
				//alert(user_id);
				$.ajax({
					type: "POST",
					url: "action.php",
					data:{action:action, user_id:user_id},
					dataType: "json",
					success: function(data) {
						alert(data);
						$('#first_name').val(data.first_name);
						$('#last_name').val(data.last_name);
						$('#user_id').val(data.user_id);
						$('#submit').text("Update");
						$('#clear').text("Cancel");
					}
				});
			});
			$(document).on('click', '#clear', function(){
				$.ajax({
					success: function(){
						$('#first_name').val('');
						$('#last_name').val('');
						$('#submit').text("Submit");
						$('#clear').text("Clear");
					}
				});
			});
			$(document).on('click', '.delete', function() {
				var user_id = $(this).attr('id');
				var action = $('.delete').attr('name');
				//alert(action);
				if(confirm("Are you sure you want to delete this user?")) {	
					$.ajax({
						type: 'POST',
						url: 'action.php',
						data: {action:action, user_id:user_id},
						success: function(data) {
							fetchUser();
							alert(data);
						}
					});
				} else{
					return false;
				}
			});
		});
	</script>
</body>
</html>