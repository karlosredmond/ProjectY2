<!--Name :       Karl Redmond
	Student No.: C00196815
	Course :     KCCOMC-2P
	Description: Print Stock Order Screen
-->
<!-- include home screen and database login data-->
<?php
	include 'home.html.php';
	include 'garagedb.inc.php' ;
	date_default_timezone_set("UTC");
?>
<html>
<head>
<script>
</script>
</head>
<body>
<div class ="main" >
<h1 style="margin:0px;">Reorder Letter</h1>
<form  id="ReorderLetter" autocomplete=off action="ReorderStock.html.php" style="background-color:white ; color:black; " onsubmit="return confirmCheck()" method = "post">
<!-- inline style used to alter form slightly-->	
<!--*******************used <span> and <pre> tags to format letter*******************-->
<pre>					<span style="font-weight:normal;">Ger's Garage,
					High Street,
					Carlow
					<?php echo "" . date("Y/m/d") . "";  ?></pre></span><!--php used to get date and echo to screen -->
<pre><input type="text" class="letterK" value="<?php echo $_POST['name'] ;?>,">
<input type="text" class="letterK" value="<?php echo $_POST['address'] ;?>"></pre>
<input type="hidden" class="letterK" name="stockOrderId" id="stockOrderId"value="<?php $sql = "SELECT MAX(stockOrderID) as maxID FROM StockOrder" ;	
				if(!$result = mysqli_query($con,$sql)){
					die("An Error in the SQL Query:" .mysqli_error("Error") ) ;
				} 
				$row = mysqli_fetch_assoc($result);
				$largestID = $row['maxID'];
				$_SESSION['stockOrderID'] = $largestID + 1;
				$stockOrderID = $_SESSION['stockOrderID'] ;
				echo $_SESSION['stockOrderID']?>"/>
				<!--query used to get max id from stockOrder table, and it is then incremented by one, also assigned to $stockOrderID to be used for inserting into stockOrder table further on-->
<pre>		  Order Number: <input type="text" class="letterK" value="<?php $sql = "SELECT MAX(orderID) as maxID FROM Orders" ;	
				if(!$result = mysqli_query($con,$sql)){
					die("An Error in the SQL Query:" .mysqli_error("Error") ) ;
				} 
				$row = mysqli_fetch_assoc($result);
				$largestID = $row['maxID'];
				$_SESSION['orderID'] = $largestID + 1; 
				$orderID = $_SESSION['orderID']  ;
				echo $_SESSION['orderID']?>"/><br>
				<!--php used to get max order id from order table, it is then incremented by one and assigned to $orderID so it can be used to insert into order table further on in the code-->
<span style="font-weight:normal;">Please supply the following Stock Item(s)</span></pre>
<div  align = 'center'>
<table border = '0'  >
	<tr><th width="20%">Stock</th><th width="20%">Item Description</th><th width="20%">Quantity</th><th width="20%">Price</th></tr></table></div>
			
<?php
					$string = $_POST['stockNeeded'] ;
					/*assigned the string (stock needed) from the last form, so i could isolate strings using explode*/
					$myArray = explode(',', $string);
					/*explode method used to seperate string into an array, using comma as delimiter*/
					$count =  count($myArray);
					/*counted the number of elements in the array*/
					echo "<div align = 'center'>
						<table border = '0' cellpadding = '2' width = '100%' bgcolor = white color=black >";
					/*populate table with required data*/
					$i = 0 ;
					/*while $i is less than size of $myarray*/
					while($i < $count){
						$stockID = $myArray["$i"] ;
						$i++ ;
						$description = $myArray["$i"] ;
						$i++ ;
						$quantity = $myArray["$i"] ;
						$i++ ;
						$price =  $myArray["$i"];
						$i++ ;
						echo "<tr align = 'center'>
						<td width= '20%'>".$stockID."</td>
						<td width= '20%'>".$description."</td>
						<td width= '20%'>".$quantity."</td>
						<td width= '20%'>".$price."</td>
						</tr>"; 
						/*above used to populate table in the letter*/
						$sql = "Insert into StockOrder (stockOrderID,quantity, stockID, orderID)
						VALUES ('$stockOrderID','$quantity','$stockID','$orderID')";
						if(!$result = mysqli_query($con,$sql)){
							die("An Error in the SQL Query:" .mysqli_error() ) ;
						}
					/*above query ran on every iteration of while loop, to insert data into stockOrder table*/
					$stockOrderID++ ;
					/*stockOrderID had to be incremented as it is a primary key in the StockOrder table*/
					}
					echo "</table></div>";
				$date = date("Y/m/d") ;
				/*assign current date to $date to be used in following query*/
				$sql = "Insert into Orders (orderID,dateOrdered, supplierID)
							VALUES ('$orderID','$date','$_POST[supplierID]')";
				if(!$result = mysqli_query($con,$sql)){
					die("An Error in the SQL Query:" .mysqli_error() ) ;
				}
				/*query ran to insert new order into orders table*/
				mysqli_close($con) ; 
				/*close connection to database*/
				?>
				<br>
<pre>		<span style="font-weight:normal; ">   Yours sincerely,
		   Karl Redmond
		   Stock Controller</span>
			
<input type="submit" value="Return" title="Return to Reorder Stock"  name ="submit"  />
</form>
</div>
</body>
</html>