<!--Name :       Karl Redmond
	Student No.: C00196815
	Course :     KCCOMC-2P
	Description: Add Customer Screen
-->

<!-- include home screen and database login data-->
<?php
	include 'home.html.php';
	include 'garagedb.inc.php' ;
?>

<html>
<head>
<script>
	function confirmCheck(){<!--Provide user with message to confirm data-->
		var response ; 
		response = confirm('Are you sure you want to save these changes?');
		if(response){
			document.getElementById("customerID").disabled = false; <!-- Customer id set to false if user selects ok-->
			return true ;
		}
		else{
			return false ;
		}
	}
</script>
</head>
<body>
<div class ="main">
	<h1>Add Customer</h1>
	<form  id="CusForm" autocomplete=off action="AddCustomer.php" onsubmit="return confirmCheck()" method = "post">	
	<!--On form submit user is provided with a confirm message-->			
		<input   type="hidden" name="customerID" id="customerID" disabled
		value="<?php $sql = "SELECT MAX(customerID) as maxID FROM Customers" ;	
						if(!$result = mysqli_query($con,$sql)){
							die("An Error in the SQL Query:" .mysqli_error("Error") ) ;
						} 
						$row = mysqli_fetch_assoc($result);
						$largestID = $row['maxID'];
						$_SESSION['customerID'] = $largestID + 1; 
						echo $_SESSION['customerID']?>"/>
						<!-- sql and php above used to retrieve the max customer Id and increment by one -->
		<label for="name">Name</label>
		<!-- the pattern for the below input allows spaces dots and letters only, inline style used to place image in input field -->
		<input style="background-image:url(img/icons/User.png);  "
		required autofocus pattern="[a-zA-Z. ]*" class="inputFieldK requiredK" type="text" name="name" id="name"  
		placeholder="Type First & Last Name" title="Enter Name Here, only letters, spaces and dots permitted"  /><br/><br/>
		<label for="address">Address (Street)</label>
		<input type="text" name="address" style="background-image:url(img/icons/home.png); " 
		type="text" required pattern="[a-zA-Z0-9., ]*" class="inputFieldK requiredK"  id="address" 
		placeholder="Enter Street" title="Address can only contain letters,numbers, commas, spaces and dots"><br/></br>	
		<!-- the pattern for the above input allows spaces, dots, commas, numbers and letters only -->	
		<label for="address2">Address (Town)</label>
		<input type="text" name="address2" style="background-image:url(img/icons/home.png); " 
		type="text"  pattern="[a-zA-Z0-9., ]*" class="inputFieldK"  id="address2" 
		placeholder="Enter Town" title="Address can only contain letters,numbers, commas, spaces and dots"></textarea><br/></br>						
		<!-- the pattern for the above input allows spaces, dots, commas, numbers and letters only -->
		<label for="address2">Address (County)</label>
		<input type="text" name="address3" style="background-image:url(img/icons/home.png); " 
		type="text"  pattern="[a-zA-Z0-9., ]*" class="inputFieldK"  id="address3" 
		placeholder="Enter County" title="Address can only contain letters,numbers, commas, spaces and dots"></textarea><br/></br>						
		<!-- the pattern for the above input allows spaces, dots, commas, numbers and letters only -->					
		<label for="phone">Phone No</label>
		<input style="background-image:url(img/icons/phone.png);"
		type="tel"required pattern="[()0-9- ]*"name="phone" id="phone" class="inputFieldK requiredK"  
		placeholder="Enter Phone Number" title="Phone number must only contain numbers, dashes, brackets and spaces ie. (087)-6556782"
		/><br/><br/>
		<!-- the pattern for the above input allows brackets, dashes,spaces and numbers only -->
		<label for="email">Email Address</label>
		<input style="background-image:url(img/icons/email.png); " type="email" 
		title="Joe@somewhere.com" name="email" id="email"  class="inputFieldK"  placeholder="joebloggs@hotplace.com"/><br/><br/>
		<!-- email above not required, all other fields are required, if the user starts to enter an email, it must be of the correct format to submit the form -->				
		<fieldset class="fieldsetK"></fieldset>
		<input type="submit" value="Submit" title="Click to Add New Customer" style="margin-bottom:0px;" name ="submit" />
		<!-- once successfully submitted the user is directed to AddCustomer.php -->
		<input type="reset" value="Clear" name ="reset" /></br>
	</form>
</div>
</body>
</html>