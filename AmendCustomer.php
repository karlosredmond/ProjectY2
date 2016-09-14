<!--Name :       Karl Redmond
	Student No.: C00196815
	Course :     KCCOMC-2P
	Description: Amend Customer Screen
-->

<!-- include home screen and database login data-->
<?php
	include 'garagedb.inc.php';
	include 'home.html.php';
	$sql = "UPDATE Customers SET name = '$_POST[name]',
				address = '$_POST[address]',addressTwo = '$_POST[address2]',addressThree = '$_POST[address3]',phone = '$_POST[phone]',email = '$_POST[email]'
				WHERE customerId = '$_POST[customerID]' ";
				
	if(!mysqli_query($con,$sql)){
		echo "Error".msqli_error() ;
	}
	mysqli_close($con) ;
?>
<!-- The above sql and php updates the Customers table with the inputted data from the previous form-->
<div class ="main">
	<h1>Details Updated</h1>
	<form action = "AmendCustomer.html.php" method="POST">
		<label> Customer ID: </label> 
		<input type="text" class="inputFieldR" readonly
		value ="<?php echo $_POST['customerID']; ?>"></br><br>
		<label> Name: </label> 
		<input type="text" class="inputFieldR" readonly
		value ="<?php echo $_POST['name']; ?>"></br><br>
		<fieldset class="fieldsetK"></fieldset>
		</br><br>
		<input type="submit" value = "Return" title="Return to Amend Customer Screen">
		<!--When return is clicked the user is redirected to AmendCustomer.html.php-->

	</form>
</div>