<!--Name :       Karl Redmond
	Student No.: C00196815
	Course :     KCCOMC-2P
	Description: Add Customer Screen
-->
<!-- include home screen and database login data-->
<?php
	include 'garagedb.inc.php';
	include 'home.html.php';
	
	date_default_timezone_set("UTC");
	
	$sql = "Insert into Customers (customerID,name, address, addressTwo,addressThree, phone,email)
	VALUES ('$_POST[customerID]','$_POST[name]','$_POST[address]','$_POST[address2]','$_POST[address3]','$_POST[phone]','$_POST[email]')";
	$_SESSION["customerID"] = $_POST['customerID'] ;
	$_SESSION["name"] = $_POST['name'] ;
	if(!$result = mysqli_query($con,$sql)){
		die("An Error in the SQL Query:" .mysqli_error() ) ;
	}
	mysqli_close($con) ; 
?>
<!-- sql and php above used to add a customer to the Customers table-->
<!-- Details are submitted and the customerID and name is shown on screen-->
<div class ="main">
	<h1>Details Submitted</h1>
	<form action = "AddCustomer.html.php" method="POST">
		<label> Customer ID </label> 
		<input type="text" class="inputFieldR"  readonly
		value ="<?php echo $_SESSION['customerID']; ?>"></br><br>
		<label> Name </label> 
		<input type="text" class="inputFieldR" readonly
		name="name" id="name" value ="<?php echo $_SESSION['name']; ?>"></br><br>
		<fieldset class="fieldsetK"></fieldset>
		</br><br>
		<input type="submit" value = "Return" title="Return to Add Customer Screen">
		<!-- On Clicking return the user is redirected to AddCustomer.html.php -->
	</form>
</div>



	