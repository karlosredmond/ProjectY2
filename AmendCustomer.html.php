<!--Name :       Karl Redmond
	Student No.: C00196815
	Course :     KCCOMC-2P
	Description: Amend Customer Screen
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
	checkToggle() ;
} 
function checkToggle(){<!--Function used to check if the values of "amendViewbutton" does not equal Amend, toggleLock() is called if true--> 
	if(document.getElementById("amendViewbutton").value != "Amend"){
		toggleLock() ;
	}
}  	
function toggleLock(){<!-- Function used to enable/disable input fields, which will allow/disallow the user to edit data--> 
	if(document.getElementById("customerID").value == ""){<!--Checks to see if a customer has been selected-->
		alert("You must Select a customer") ;
	}
	else{
		if(document.getElementById("amendViewbutton").value == "Amend"){
			document.getElementById("name").disabled = false;
			document.getElementById("address").disabled = false;
			document.getElementById("address2").disabled = false;
			document.getElementById("address3").disabled = false;
			document.getElementById("phone").disabled = false;
			document.getElementById("email").disabled = false;
			document.getElementById("amendViewbutton").value = "View" ;
			document.getElementById("name").focus() ;<!--focus() called to put cursor in name input field-->
		}
		else{
			document.getElementById("name").disabled = true;
			document.getElementById("address").disabled = true;
			document.getElementById("address2").disabled = true;
			document.getElementById("address3").disabled = true;
			document.getElementById("phone").disabled = true;
			document.getElementById("email").disabled = true;
			document.getElementById("amendViewbutton").value = "Amend" ;
		}
	}
}
function confirmCheck(){<!--Function provides the user with an option to cancel or confirm, upon confirm, the form is submitted-->
	if(document.getElementById("customerID").value == ""){<!--Checks to see if a customer has been selected-->
		alert("You must Select a customer") ;
		return false ;
	}
	else{
		var response ; 
		response = confirm('Are you sure you want to save these changes?');<!-- asks the user to confirm or cancel submit click-->
		if(response){
			document.getElementById("name").disabled = false;
			document.getElementById("address").disabled = false;
			document.getElementById("address2").disabled = false;
			document.getElementById("address3").disabled = false;
			document.getElementById("phone").disabled = false;
			document.getElementById("email").disabled = false;
			return true ;
		}
		else{
			populate() ;
			checkToggle() ;
			return false ;
		}
	}
}
</script>
<div class ="main">
	<h1>Amend/View Customer Details</h1>
	<form  id="AmendCustomerForm" autocomplete=off action="AmendCustomer.php"   onsubmit="return confirmCheck()" method = "post">	<!--On form submit user is provided with a confirm message-->
		<label for="selectName">Select Name </label>
		<select style ="background-image:url(img/icons/ID.png); width:225px;" class = "inputFieldK" name = "selectName" id = "selectName" onclick = 'populate()'>
		<!--Populate is called to put results into input fields upon selection, inline style used to put image in input field-->
		<?PHP
			$sql = "SELECT customerID, name, address ,addressTwo, addressThree,phone, email FROM Customers WHERE markForDeletion = 0 Order By name" ;

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
		<br/><br/>
		<label for="customerID">Customer ID</label>
		<input readonly class="inputFieldR" type="text" style="width:225px;"name="customerID" id="customerID" /><br/><br/>
		<!--readonly ^^ provided so user cannot edit id-->
		<label for="name">Name:</label>
		<!-- the pattern for the below input allows spaces dots and letters only, inline style used to place image in input field -->
		<input style="background-image:url(img/icons/User.png);  "
		required autofocus pattern="[a-zA-Z. ]*" class="inputFieldK requiredK" type="text" name="name" id="name"  
		placeholder="Type First & Last Name" title="Enter Name Here, only letters, spaces and dots permitted" disabled /><br/><br/>
		<label for="address">Address (Street)</label>
		<input type="text" name="address" style="background-image:url(img/icons/home.png); " 
		type="text" required pattern="[a-zA-Z0-9., ]*" class="inputFieldK requiredK"  id="address" 
		placeholder="Enter Street" title="Address can only contain letters,numbers, commas, spaces and dots" disabled><br/></br>	
		<!-- the pattern for the above input allows spaces, dots, commas, numbers and letters only -->	
		<label for="address2">Address (Town)</label>
		<input type="text" name="address2" style="background-image:url(img/icons/home.png); " 
		type="text"  pattern="[a-zA-Z0-9., ]*" class="inputFieldK"  id="address2" 
		placeholder="Enter Town" title="Address can only contain letters,numbers, commas, spaces and dots" disabled><br/></br>						
		<!-- the pattern for the above input allows spaces, dots, commas, numbers and letters only -->
		<label for="address2">Address (County)</label>
		<input type="text" name="address3" style="background-image:url(img/icons/home.png); " 
		type="text"  pattern="[a-zA-Z0-9., ]*" class="inputFieldK"  id="address3" 
		placeholder="Enter County" title="Address can only contain letters,numbers, commas, spaces and dots" disabled><br/></br>						
		<!-- the pattern for the above input allows spaces, dots, commas, numbers and letters only -->						
		<label for="phone">Phone No.</label>
		<!-- the pattern for the below input allows brackets, dashes,spaces and numbers only -->
		<input style="background-image:url(img/icons/phone.png);"
		type="tel"required pattern="[()0-9- ]*"name="phone" id="phone" class="inputFieldK requiredK" 
		placeholder="Enter Phone Number here"
		title="Phone number must only contain numbers, dashes, brackets and spaces ie. (087)-6556782"
		disabled /><br/><br/>
		<label for="email">Email Address:</label>
		<!-- email below not required, all other fields are required, if the user starts to enter an email, it must be of the correct format to submit the form -->		
		<input style="background-image:url(img/icons/email.png); " type="email" 
		title="Joe@somewhere.com" name="email" id="email"  class="inputFieldK"  placeholder="joebloggs@hotplace.com" disabled /><br/><br/>	
		<fieldset class="fieldsetK" readonly></fieldset>
		<input type="submit" value="Save" name ="submit" title="Click to Save Changes" />
		<!-- On Submit and confirmation, the user is redirected to AmendCustomer.php-->
		<input type="button" class="amend" value = "Amend" id = "amendViewbutton" title="Click to edit Details of Customer" onclick = "toggleLock()">
		<!-- On button click the input fields will be disabled/enabled-->
		<input type="reset" value="Clear" name ="reset" title="Click to clear fields" /></br>
	</form>
</div>
</body>
</html>