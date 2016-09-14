<!--Name :       Karl Redmond
	Student No.: C00196815
	Course :     KCCOMC-2P
	Description: Print Job Card
-->
<!-- include home screen and database login data-->
<?php
	include 'home.html.php';
	include 'garagedb.inc.php';

	date_default_timezone_set("UTC");
	
	$sql = "Insert into Jobs (jobID,workNeeded, carReg, bookingID)
				VALUES ('$_POST[jobID]','$_POST[workNeeded]','$_POST[regNo]','$_POST[bookingID]')";
	if(!$result = mysqli_query($con,$sql)){/*Insert new Record into Jobs Table*/
		die("An Error in the SQL Query:" .mysqli_error() ) ;
	}
	
	$sql = "UPDATE Bookings SET markForDeletion = 1
				WHERE bookingID = '$_POST[bookingID]' ";
	if(!$result = mysqli_query($con,$sql)){/*Mark Booking for Deletion so it doesnt appear in the Commencement Of Job Screen again*/
		die("An Error in the SQL Query:" .mysqli_error() ) ;
	}
	$sql = "Select * From Cars
				WHERE carReg = '$_POST[regNo]' ";
	if(!$result = mysqli_query($con,$sql)){/*Check to see if the car is in the database*/
		die("An Error in the SQL Query:" .mysqli_error() ) ;
	}
	$rowcount=mysqli_num_rows($result);/*count rows affected by last query(Check to see if car is in database)*/
	if($rowcount > 0 ){/*If the Car is in the database, update the mileage */
			$sql = "UPDATE Cars SET Cars.mileage = '$_POST[mileage]'
						WHERE Cars.carReg = '$_POST[regNo]' ";
			if(!$result = mysqli_query($con,$sql)){
				die("An Error in the SQL Query:" .mysqli_error() ) ;
			}
	}
	else{/*If the car is not in the database, add a new record*/
			$sql = "Insert into Cars (carReg,make, model, mileage)
						VALUES ('$_POST[regNo]','$_POST[make]','$_POST[model]','$_POST[mileage]')";
			if(!$result = mysqli_query($con,$sql)){
				die("An Error in the SQL Query:" .mysqli_error() ) ;
			}
	}

	mysqli_close($con) ; 
?>
<div class ="main">
	<h1>Job Card</h1>
	<form id="printJobCard" action = "CommencementOfJob.html.php" method="POST">
		<label> Job ID </label> 
		<input type="text" class="inputFieldR"  readonly
		value ="<?php echo $_POST['jobID']; ?>"></br><br>
		<label> Make </label> 
		<input type="text" class="inputFieldR" readonly
		value ="<?php echo $_POST['make']; ?>"></br><br>
		<label> Model </label> 
		<input type="text" class="inputFieldR" readonly
		value ="<?php echo $_POST['model']; ?>"></br><br>
		<label> Reg No </label> 
		<input type="text" class="inputFieldR" readonly
		value ="<?php echo $_POST['regNo']; ?>"></br><br>
		<fieldset class="fieldsetK"><legend>Job Instructions</legend></fieldset>
		<textarea  form="printJobCard" rows = "4" style="width:82%; background-image:url(img/icons/car.png); background-position:4px 3px;" 
		class="inputFieldK requiredK"   
		readonly ><?php echo $_POST['workNeeded']; ?></textarea></br></br></br></br>
		<!--inline style used to insert icon in textarea above, also to make an adjustment to the width-->
		<fieldset class="fieldsetK"><legend>Details of Work Carried Out to be filled in by Mechanic</legend></fieldset>
		<textarea form = "printJobCard" rows="4" class="inputFieldK requiredK"   
		style="width:82%; background-image:url(img/icons/notes.png); background-position:4px 3px; margin:auto;" readonly 
		>Parts used and quantity(if any) : &#09; &#09; Time taken: &#09; &#13;&#10; Work Done:</textarea></br><br><br><br>
		<!--inline style used to insert icon in textarea above, also to make an adjustment to the width. &#09; is the ascii code for a tab, &#13;&#10; is the ascii for a linefeed and carriage return-->
		<fieldset class="fieldsetK"></fieldset>
		</br><br>
		<input type="submit" value = "Return" title="Return to Commencement Of Job  Screen">
		<!-- On Clicking return the user is redirected to AddCustomer.html.php -->
	</form>
</div>