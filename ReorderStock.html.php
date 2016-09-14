<!--Name :       Karl Redmond
	Student No.: C00196815
	Course :     KCCOMC-2P
	Description: Reorder Stock Screen
-->
<!-- include home screen and database login data-->
<?php
	include 'home.html.php';
	include 'garagedb.inc.php' ;
?>
<html>
<head>
<script>
	function checkQuantity(){/*checks to see if you selected an item of stock*/
		var value = document.getElementById("quantity").value;
		if(value == ""){
			alert("You must select at least 1 item of Stock") ;
			return false ;
		}
	}
	function relocate(allText){<!--Assigns input fields with values depending on which Stock has been Selected-->
			var info = allText.split('£') ;
			document.getElementById("supplierID").value = info[9];<!--Set supplierID so it can be used on next screen to display only stock from this supplier-->
			document.getElementById("ReorderStockForm").submit(); <!--submits the form when an item of stock is selected, the following screen displays only items of stock that are available from the supplier that the user selected-->
	}
</script>
</head>
<body>
<div class ="main2">
	<h1>Reorder Stock </h1>
	<form  id="ReorderStockForm" autocomplete=off action="ReorderStockCont.html.php"  method = "post">	
		<h2>Select Stock and Supplier</h2>
						<div  align = 'center'>
							<table border = '0'  bgcolor = '#00000'>
							<tr><th width="10%">Stock No</th><th width="20%">Stock Description</th><th width="10%">Qty in Stock</th><th width="10%">Qty on Order</th><th width="10%">Reorder Level</th><th width="10%">Reorder Qty</th><th width="20%">Suppliers Name</th></tr></table></div>
						<?php
						$sql = "Select stockID,Supplier.supplierID,Supplier.address,description,quantityInStock,reOrderLevel,reOrderQty,name,costPrice From Stock inner join Supplier ON Stock.supplierID=Supplier.supplierID Where Stock.markForDeletion = 0 Order by stockID"  ;
						/*query to retrieve information from stock table, joined with supplier table*/
						if(!$result = mysqli_query($con,$sql)){
										die("An Error in the SQL Query:" .mysqli_error("Error") ) ;
									} 
						echo "<div class='scroll-containerK' align = 'center'>
							<table border = '1' cellpadding = '2' width = '100%' bgcolor = '#00000'>";
						/*populate table with required data*/
						while($row=mysqli_fetch_array($result)){
							$stockID = $row['stockID'] ;
							$description = $row['description'] ;
							$supplierID = $row['supplierID'] ;
							$address = $row['address'] ;
							$qtyInStock = $row['quantityInStock'] ;
							$reOrderLevel = $row['reOrderLevel'] ;
							$reOrderQty = $row['reOrderQty'] ;
							$name = $row['name'] ;
							$price = $row['costPrice'] ;
							$sql2 = "SELECT SUM(quantity) AS QtyOnOrder FROM StockOrder Where stockID = '$stockID' and markForDeletion = 0 " ;
							/*counts the total quantity on order of a stock item using the current $stockID, query runs on every iteration through loop*/
							if(!$result2 = mysqli_query($con,$sql2)){
									die("An Error in the SQL Query:" .mysqli_error("Error") ) ;
							}
							$row2=mysqli_fetch_array($result2) ;
							/*gets the result of query (row2)*/
							$qtyOnOrder = $row2['QtyOnOrder'] ;
							$allText = "$stockID"."£"."$description"."£"."$qtyInStock"."£"."$qtyOnOrder"."£"."$reOrderLevel"."£"."$reOrderQty"."£"."$name"."£"."$price"."£"."$address"."£"."$supplierID";
							echo "<tr align = 'center'>
							<td onclick ='relocate(\"" . $allText . "\")' style='cursor:pointer;' width='12%'>".$stockID."</td>
							<td onclick ='relocate(\"" . $allText . "\")' style='cursor:pointer;' width='22%'>".$description."</td>
							<td onclick ='relocate(\"" . $allText . "\")' style='cursor:pointer;' width='11%'>".$qtyInStock."</td>
							<td onclick ='relocate(\"" . $allText . "\")' style='cursor:pointer;' width='12%'>".$qtyOnOrder."</td>
							<td onclick ='relocate(\"" . $allText . "\")' style='cursor:pointer;' width='11%'>".$reOrderLevel."</td>
							<td onclick ='relocate(\"" . $allText . "\")' style='cursor:pointer;' width='11%'>".$reOrderQty."</td>
							<td onclick ='relocate(\"" . $allText . "\")' style='cursor:pointer;' width='0%'>".$name."</td>
							</tr>"; /*getName() method is assigned to each table row, depending on which row you click, a different string is sent to getName() and split using this string*/
						}
						echo "</table></div>";
					?>
					<br>
					<input type="hidden" id="supplierID" name ="supplierID">
					<label for="stockID">Stock ID</label>
					<input required class="inputFieldR" type="text" name="stockID" id="stockID" readonly /><br/><br/>
					<label for="description">Description</label>
					<input required class="inputFieldR" type="text" name="description" id="description" readonly  /><br/><br/>
					<fieldset class="fieldsetK"></fieldset>
					<label for="quantity">Enter Quantity</label>
					<input style="background-image:url(img/icons/amount.png); width:50px; " required  pattern="[0-9]*" class="inputFieldK requiredK" type="number" 
					min="1" max="100" name="quantity" id="quantity" title="Enter Desired quantity of Stock Here, only numbers permitted" disabled  /><br/><br/>		
					<!--Pattern above only allows numbers inline style used for icon image and slight adjustment to width-->
					<fieldset class="fieldsetK"></fieldset>
					<label>Stock to be Ordered</label>
					<textarea name="workNeeded" rows = "3" style="background-image:url(img/icons/notes.png); background-position:4px 3px;" 
					type="text"  class="inputFieldK requiredK"  id="stockToBeOrdered" name ="stockToBeOrdered"
					 readonly></textarea><br/><br/><br>
					 <!--inline style used above to place icon in textarea-->
					<fieldset class ="fieldsetK"></fieldset>				
					<input type="submit" value="Print"  name ="mysubmit" onclick="return checkQuantity()" title="Click to Make an Order"/>
					<input type="button" class="amend" style="margin-left:340px ;" value = "Add to Order" title="Click to Add Details to Order" onclick="return checkQuantity()" >
					<!-- once successfully submitted the user is directed to ReorderStockCont.html.php -->
					<input type="reset" value="Clear" name ="reset"  /></br>
	</form>
</div>
</body>
</html>