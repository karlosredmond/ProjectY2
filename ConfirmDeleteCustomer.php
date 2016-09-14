<!--Name :   	Karl Redmond
	Student No.: C00196815
	Course :     KCCOMC-2P
	Description: Delete Customer Screen
-->
<!-- include home screen and database login data-->	
<?php
	include 'home.html.php';
	include 'garagedb.inc.php' ;
	$sql = "UPDATE Customers SET markForDeletion = 1
				WHERE customerId = '$_POST[customerID]' ";
	if(!mysqli_query($con,$sql)){
			echo "Error".msqli_error() ;
	}
	$sql = "DELETE FROM Bookings
				WHERE customerID='$_POST[customerID]' ";
	if(!mysqli_query($con,$sql)){
			echo "Error".msqli_error() ;
	}
	mysqli_close($con) ;
?>
<!--sql and php above marks the selected customer for deletion in the markForDeletion Field of Customers table, and deletes any bookings they have from the Bookings table -->
<html>
<body>
<br><br><br><br>
<div class ="main">
	<h1>Customer Deleted</h1>
	<form action = "DeleteCustomer.html.php" method="POST">
		<label> Customer ID </label> 
		<input type="text" class="inputFieldR"  readonly
		name="customerID" id="customerID" value ="<?php echo $_POST['customerID']; ?>"></br><br>
		<label> Name </label> 
		<input type="text" class="inputFieldR" readonly
		name="name" id="name" value ="<?php echo $_POST['name']; ?>"></br><br>
		<fieldset class="fieldsetK"></fieldset></br><br>
		<input type="submit" value = "Return" title="Return to Delete Customer Screen" >
		<!--On Clicking Return the user is redirected to DeleteCustomer.html.php-->
	</form>
</div>
</body>
</html>