<!--Name :       Karl Redmond
	Student No.: C00196815
	Course :     KCCOMC-2P
	Description: Commencement Of Job Screen
-->
<!-- include home screen and database login data-->
<?php
	include 'home.html.php';
	include 'garagedb.inc.php' ;
?>
<html>
<head>
<script>
	function confirmCheck(){<!--Checks to see if a job has been selected-->
		var response = document.getElementById("customerName").value;
		if(response == ""){
			alert("You must select a Job") ;
			return false ;
		}
		else{
			return true ;
		}
	}
	function getName(allText){<!--Assigns input fields with values depending on which job has been Selected-->
			var info = allText.split('£') ;
			alert("You have selected " + info[0] + ". Please input Job Details.");
			document.getElementById("model").disabled = false;
			document.getElementById("make").disabled = false;
			document.getElementById("regNo").disabled = false;
			document.getElementById("mileage").disabled = false;
			document.getElementById("workNeeded").disabled = false;
			document.getElementById("customerName").value = info[0];
			document.getElementById("customerAddress").value = info[1];
			document.getElementById("bookingID").value = info[2];
			document.getElementById("make").focus() ;//puts cursor in make field
	}
</script>
</head>
<body>
<div class ="main">
	<h1>Commencement Of Job</h1>
	<form  id="CommenceForm" autocomplete=off action="PrintJobCard.php" onsubmit="return confirmCheck()" method = "post">	
	<div  align = 'center'>
		<table border = '0'  bgcolor = '#00000'>
			<tr><th width="28%">Customer Name</th><th width="33%">Address</th></tr></table></div>
		<?php
			$sql = "Select name,address,bookingID From Customers inner join Bookings ON Customers.customerID=Bookings.customerID Where Bookings.date = curdate() and Bookings.markForDeletion = 0 Order By name"  ;
			if(!$result = mysqli_query($con,$sql)){
				die("An Error in the SQL Query:" .mysqli_error("Error") ) ;
			} 
			$j = mysqli_num_rows($result) ; /* Check for number of rows affected*/
			if($j == 0){/*If no rows found, echo no bookings for today*/
				echo "<script>alert(\"No Bookings for Today\")</script>" ;
			}
			echo "<div class='scroll-containerK' align = 'center'>
					<table border = '1' cellpadding = '2' width = '90%' bgcolor = '#00000'>";
			while($row=mysqli_fetch_array($result)){
				$name = $row['name'] ;
				$address = $row['address'] ;
				$bookingID = $row['bookingID'] ;
				$allText = "$name"."£"."$address"."£"."$bookingID";
				echo "<tr align = 'center'>
							<td onclick ='getName(\"" . $allText . "\")' style='cursor:pointer;' width='45%'>".$name."</td>
							<td onclick ='getName(\"" . $allText . "\")' style='cursor:pointer;' width='45%'>".$address."</td>
							</tr>"; /*getName() method is assigned to each table row, depending on which row you click, a different string is sent to getName() and split using this string*/
			}
			echo "</table></div>";
		?>
		<!-- the above sql and php retrieves data and populates table, different strings will be sent to get name method, depending on which table row is clicked-->
		<br>
		<!--input hidden (vv) -->
		<input type="hidden" name="jobID" id="jobID" 
		value="<?php $sql = "SELECT MAX(jobID) as maxID FROM Jobs" ;	
							if(!$result = mysqli_query($con,$sql)){
								die("An Error in the SQL Query:" .mysqli_error("Error") ) ;
							} 
							$row = mysqli_fetch_assoc($result);
							$largestID = $row['maxID'];
							$_SESSION['jobID'] = $largestID + 1; 
							echo $_SESSION['jobID']?>"/>
		<!-- php above used to retrieve the max job Id and increment by one -->
		<!--input hidden as not required on this screen, but is used on next screen-->
		<input type="hidden" name="bookingID" id="bookingID" />
		<!--input hidden as not required on this screen, but is used on next screen-->
		<input type="hidden" name="customerName" id="customerName" />
		<!--input hidden as not required on this screen, but is used on next screen-->
		<input type="hidden" name="customerAddress" id="customerAddress" /><br/>
		<label for="make">Make</label>
		<!-- the pattern for the below input allows spaces dots and letters only, inline style used to place image in input field -->
		<input style="background-image:url(img/icons/car.png);  "
		required  pattern="[a-zA-Z]*" class="inputFieldK requiredK" type="text" name="make" id="make"  
		placeholder="Type Make Of Car here" title="Enter Make Here, only letters permitted" disabled /><br/><br/>
		<label for="model">Model</label>
		<!-- the pattern for the below input allows spaces, numbers and letters only, inline style used to place image in input field -->
		<input style="background-image:url(img/icons/car.png);  "
		required  pattern="[a-zA-Z0-9 ]*" class="inputFieldK requiredK" type="text" name="model" id="model"  
		placeholder="Type Model Of Car here" title="Enter Model Here, only letters,numbers and spaces permitted" disabled  /><br/><br/>
		<label for="regNo">Registration No</label>
		<input style="background-image:url(img/icons/reg.png);  "
		required  pattern="[a-zA-Z0-9-]*" class="inputFieldK requiredK" type="text" name="regNo" id="regNo"  
		placeholder="Type Registration Of Car here" title="Enter Registration of Car Here, only letters,numbers and dashes (-) permitted ie. 01-WX-1001" disabled  /><br/><br/>		
		<!-- the pattern for the above input allows numbers,dashes and letters only -->				
		<label for="mileage">Current Mileage</label>
		<input style="background-image:url(img/icons/notes.png);"
		type="text"required pattern="[0-9]*"name="mileage" id="mileage" class="inputFieldK requiredK"  
		placeholder="Enter Current Mileage Here" title="Mileage must only contain numbers"
		disabled /><br/><br/>
		<!-- the pattern for the above input allows numbers only -->
		<label for="workNeeded">Work Needed</label>
		<textarea name="workNeeded" form="CommenceForm" rows = "3" style="background-image:url(img/icons/notes.png); background-position:4px 3px;" 
		type="text" required pattern="[a-zA-Z0-9., ]*" class="inputFieldK requiredK"  id="workNeeded" 
		placeholder="Enter Instructions" title="Instructions can only contain letters,numbers, commas, spaces and dots" disabled></textarea><br/><br/></br>
		<!-- Pattern above can include letters, commas, numbers and spaces-->				
		<fieldset class="fieldsetK"></fieldset>
		<input type="submit" value="Print Card" style="margin-bottom:0px ; " name ="submit" title = "Print Job Card For Mechanic" />
		<!-- once successfully submitted the user is directed to PrintJobCard.php -->
		<input type="reset" value="Clear" name ="reset" /></br>
	</form>
</div>
</body>
</html>
