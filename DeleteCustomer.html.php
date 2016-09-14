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
<html>
<body>
<script>
function populate(){<!--Function used to populate drop down box, results are split on '£' to allow for commas which may be in address-->
	var sel = document.getElementById("selectName") ;
	var result ;
	result = sel.options[sel.selectedIndex].value ;
	var personDetails = result.split('£') ;
	document.getElementById("customerID").value = personDetails[0] ;
	document.getElementById("name").value= personDetails[1] ;
	document.getElementById("address").value= personDetails[2] ;
	document.getElementById("address2").value= personDetails[3] ;
	document.getElementById("address3").value= personDetails[4] ;
	document.getElementById("phone").value= personDetails[5] ;
	document.getElementById("email").value= personDetails[6] ;
} 	
function confirmCheck(){<!--Function used to check if user has selected a customer to delete, if they havent, they cannot move forward-->
	var response = document.getElementById("name").value;
	if(response == ""){
		document.getElementById("name").disabled = true;
		alert("You must select a customer") ;
		return false ;
	}
	else{
		document.getElementById("name").disabled = false;
		return true ;
	}
}
</script>
<div class ="main">
	<h1>Delete Customer</h1>
	<form  id="DeleteCustomerForm" autocomplete=off action="DeleteCustomer.php" onsubmit="return confirmCheck()" method = "post">	<!--On form submit confirmCheck() is called to check if a customer has been selected-->
					<label for="selectName">Select Name </label>
					<select style ="background-image:url(img/icons/ID.png); width:225px;" class = "inputFieldK" name = "selectName" id = "selectName" onclick = 'populate()'>
					<!--Populate is called to put results into input fields upon selection, inline style used to put image in input field-->
					<?PHP
						$sql = "SELECT customerID, name, address ,addressTwo,addressThree,phone, email FROM Customers WHERE markForDeletion = 0 Order By name" ;

						if(!$result = mysqli_query($con, $sql)){
							die('Error in querying the database'.mysqli_error($con));
						}
						while ($row = mysqli_fetch_array($result)){
							$customerID = $row['customerID'] ;
							$name = $row['name'] ;
							$address = $row['address'] ;
							$address2 = $row['addressTwo'] ;
							$address3 = $row['addressThree'] ;
							$phone = $row['phone'] ;
							$email = $row['email'] ;
							$allText = "$customerID"."£"."$name"."£"."$address"."£"."$address2"."£"."$address3"."£"."$phone"."£"."$email";
							echo "<option value = '$allText'> $name</option>" ;
						}
						mysqli_close($con) ;					
					?>
					<!--The sql and php above retrieves information from the Customers table, where customers are not marked for deletion, and places a "£" between fields to allow the result to be split in populate() function--> 	
					</select>
					<input readonly hidden name="customerID" id="customerID" /><br/><br/>
					<!-- Input field above is hidden as not required on specification, but customerId will be required for further queries-->
					<label for="name">Name</label>
					<!-- inline style used below to place image in input field -->
					<input style="background-image:url(img/icons/User.png);  "class="inputFieldK requiredK" type="text" name="name" id="name"  readonly /><br/><br/>
					<label for="address">Address (Street)</label>
					<!-- inline style used below to place image in input field-->
					<input type="text" name="address" style="background-image:url(img/icons/home.png);" 
					type="text" class="inputFieldK"  id="address" readonly></textarea><br/></br>			
					<label for="address2">Address (Town)</label>
					<!-- inline style used below to place image in input field-->
					<input type="text" name="address2" style="background-image:url(img/icons/home.png);" 
					type="text" class="inputFieldK"  id="address2" readonly><br/></br>
					<label for="address3">Address (County)</label>
					<!-- inline style used below to place image in input field-->
					<input type="text" name="address3" style="background-image:url(img/icons/home.png);" 
					type="text" class="inputFieldK"  id="address3" readonly><br/></br>
					<label for="phone">Phone No.</label>
					<!-- inline style used below to place image in input field-->
					<input style="background-image:url(img/icons/phone.png);" type="tel"name="phone" id="phone" class="inputFieldK requiredK"  readonly /><br/><br/>
					<label for="email">Email Address</label>
					<!-- inline style used below to place image in input field-->
					<input style="background-image:url(img/icons/email.png); " type="email" name="email" id="email"  class="inputFieldK"readonly /><br/><br/>	
					<fieldset class="fieldsetK" ></fieldset>
					<input type="submit" value="Delete" style="margin-bottom:0px;" title="Click To Delete Customer" name ="submit"  />
					<!-- On submit the user is redirected to DeleteCustomer.php, providing a customer has been selected-->
					<input type="reset" value="Clear" name ="reset" /></br>
	</form>
</div>
</body>
</html>
