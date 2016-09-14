<!--Name :   	Karl Redmond
	Student No.: C00196815
	Course :     KCCOMC-2P
	Description: Delete Customer Screen
-->
<!-- include home screen and database login data-->
<?php
	include 'home.html.php';
	include 'garagedb.inc.php' ;
?>
<!-- Html Loaded first to show details of Customer which user has selected for Deletion-->
<html>
<body>
<br><br><br><br>
<div class ="main">
	<h1>Details  Of Customer To Be Deleted</h1>
	<form action = "ConfirmDeleteCustomer.php" method="POST">
		<label> Customer ID </label> 
		<input type="text" class="inputFieldR"  readonly
		name="customerID" id="customerID" value ="<?php echo $_POST['customerID']; ?>"></br><br>
		<label> Name </label> 
		<input type="text" class="inputFieldR" readonly
		name="name" id="name" value ="<?php echo $_POST['name']; ?>"></br><br>
		<label> Address </label> 
		<input type="text" class="inputFieldR" readonly
		name="address" id="address" value ="<?php echo $_POST['address']; ?>"></br><br>
		<label> Phone </label> 
		<input type="text" class="inputFieldR" readonly
		name="phone" id="phone" value ="<?php echo $_POST['phone']; ?>"></br><br>
	</form>
</div>
<?php
	if(isset($_POST['submit'])){//checks to see if submit button is set 
		$sql = "Select * From Bookings Where customerID = '$_POST[customerID]' and markForDeletion = 0";
			if(!$result = mysqli_query($con,$sql)){
				die("An Error in the SQL Query:" .mysqli_error() ) ;
			}
			else{
				if(mysqli_affected_rows($con) > 0) {
					echo '<script>alert("The Customer has a booking")</script>' ;
				}
			}
	}
?>
<!-- php and sql above is used to check if the selected customer has a booking, if they do, an alert is used to notify user of the Booking(s)-->
<script>
	function confirmCheck(){<!--Function used to provide user with a confirm option-->
		var response ; 
		response = confirm('Are you sure you want to delete this customer?');
		if(response){
			document.forms[0].submit();<!--Submits form-->
		}
		else{
			document.location.href = "http://garage.candept.com/DeleteCustomer.html.php";<!--Redirects User to DeleteCustomer.html.php-->
		}
	}
	confirmCheck() ;
</script>
<!--confirmCheck() runs automatically when user is directed to this screen, they are provide with a confirm message, 
if they select ok the form is submitted, and the user is redirected to ConfirmDeleteCustomer.php, if the user selects cancel they are redirected to DeleteCustomer.html.php-->
</body>
</html>




