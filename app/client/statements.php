<?php
	function _statementForm(){
?>
			<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
				<div class="row">
					<div class="col-md-2">
						<label>Length:</label>
						<input type="text" name="width" placeholder="Sq. Ft." class="form-control" required>
					</div>
					<div class="col-md-2">
						<label>Breadth:</label>
						<input type="text" name="height" placeholder="Sq. Ft." class="form-control" required>
					</div>
					<div class="col-md-2">
						<label>Size:</label>
						<select name="size" class="form-control">
							<option value="18">18 mm.</option>
							<option value="25">25 mm.</option>
						</select>
					</div>
					<div class="col-md-2">
						<label>Type:</label>
						<select name="type" class="form-control">
							<option value="matt">Matt</option>
							<option value="gloss">Gloss</option>
						</select>
					</div>
					<div class="col-md-2">
						<label>Colour:</label>
						<input list="colour-code" name="colour" placeholder="Colour Code" class="form-control" required>
						<datalist id="colour-code">
							<?php _getColourCodeList(); ?>
						</datalist>
					</div>
					<div class="col-md-2">
						<label>Quantity:</label>
						<input type="text" name="qty" placeholder="Quantity" class="form-control" required>
						<button type="submit" class="btn btn-primary" name="submit" value="add" style="display:none;">Add</button>
					</div>
				</div>
			</form>
			<br>
			<div class="scroll-div">
				<table class="table table-condensed table-striped">
					<tr>
						<th>Length</th>
						<th>Breadth</th>
						<th>Size</th>
						<th>Type</th>
						<th>Colour Code</th>
						<th>Quantity</th>
						<th>Sq. Ft.</th>
						<th>Amount/Sq. Ft.</th>
						<th>Amount</th>
						<th>Action</th>
					</tr>
<?php
		$totalamount = 0;
		if(isset($_SESSION["_tempstmt"])){
			foreach($_SESSION["_tempstmt"] as $k =>$v){
				$totalamount += $v[8];
?>
						<tr>
							<td><?php echo $v[0]; ?></td>
							<td><?php echo $v[1]; ?></td>
							<td><?php echo $v[2]; ?></td>
							<td><?php echo $v[3]; ?></td>
							<td><?php echo $v[4]; ?></td>
							<td><?php echo $v[5]; ?></td>
							<td><?php echo $v[6]; ?></td>
							<td><?php echo $v[7]; ?></td>
							<td><?php echo $v[8]."/-"; ?></td>
							<td><a href="?submit=deltempstmt&token=<?php echo $k; ?>">Delete</a></td>
						</tr>
<?php
			}
		}
		
?>
				</table>
			</div>
			<label>Total Amount:</label>
			<?php echo $totalamount."/-"; ?><br>
			<label>*Note: T &amp; C apply:</label> Refer <a href="?nav=home">Homepage</a> for more details.<br>
			<a href="?submit=submitstmt" class="btn btn-primary">Submit Statement</a>
<?php
	}
	
	function _addTempStmt(){
		$_sqft = $_REQUEST["width"] * $_REQUEST["height"];
		$_qty = $_REQUEST["qty"];
		$_pricing = _getPricing();
		$_amount = ($_sqft * $_pricing) * $_qty;
		$temparr = array($_REQUEST["width"], $_REQUEST["height"], $_REQUEST["size"], $_REQUEST["type"], $_REQUEST["colour"], $_qty, $_sqft, $_pricing, $_amount);
		$_SESSION["_tempstmt"][] = $temparr;
		header("location:?nav=newstmt");
	}
	
	function _getColourCodeList(){
		_databaseConnect();
		global $_conn;
		try{
			$_stmt = $_conn->prepare("SELECT * FROM colour_code");
			$_stmt->execute();
			$_stmt->setFetchMode(PDO::FETCH_ASSOC);
			$_result = $_stmt->fetchAll();
			if(!empty($_result)){
				foreach($_result as $k => $v){
?>
							<option value="<?php echo $_result[$k]["cc_id"]; ?>"><?php echo $_result[$k]["cc_name"]; ?></option>
<?php
				}
			}
		}
		catch(PDOException $_e){
			echo "Error! ".$_e->getMessage();
		}
	}
	
	function _getPricing(){
		_databaseConnect();
		global $_conn;
		try{
			$_stmt = $_conn->prepare("SELECT * FROM pricing WHERE size = :size AND type = :type");
			$_stmt->bindParam(":size", $_size);
			$_stmt->bindParam(":type", $_type);
			$_size = $_REQUEST["size"];
			$_type = $_REQUEST["type"];
			$_stmt->execute();
			$_stmt->setFetchMode(PDO::FETCH_ASSOC);
			$_result = $_stmt->fetchAll();
			if(!empty($_result)){
				return $_result[0]["price"];
			}
		}
		catch(PDOException $_e){
			echo "Error! ".$_e->getMessage();
		}
	}
	
	function _delTempStmt(){
		unset($_SESSION["_tempstmt"][$_REQUEST["token"]]);
		sort($_SESSION["_tempstmt"]);
		header("location:?nav=newstmt");
	}
	
	function _insertStatements(){
		$_stmtId = "STMT".date("YmdhisA");
		_databaseConnect();
		global $_conn;
		try{
			$_stmt = $_conn->prepare("INSERT INTO statements (length, breadth, size, type, cc_id, qty, amount, stmt_id) VALUES (:length, :breadth, :size, :type, :cc_id, :qty, :amount, :stmt_id)");
			$_stmt->bindParam(":length", $_length);
			$_stmt->bindParam(":breadth", $_breadth);
			$_stmt->bindParam(":size", $_size);
			$_stmt->bindParam(":type", $_type);
			$_stmt->bindParam(":cc_id", $_ccId);
			$_stmt->bindParam(":qty", $_qty);
			$_stmt->bindParam(":amount", $_amount);
			$_stmt->bindParam(":stmt_id", $_stmtId);
			
			$_totalAmount = 0;
			
			foreach($_SESSION["_tempstmt"] as $k => $v){
				$_length = $v[0];
				$_breadth = $v[1];
				$_size = $v[2];
				$_type = $v[3];
				$_ccId = $v[4];
				$_qty = $v[5];
				$_amount = $v[8];
				$_stmt->execute();
				
				$_totalAmount += $v[8];
			}
			
			$_stmt = $_conn->prepare("INSERT INTO statement_transactions (stmt_id, stmt_date, client_id, total_amount, status) VALUES (:stmt_id, :stmt_date, :client_id, :total_amount, :status)");
			$_stmt->bindParam(":stmt_id", $_stmtId);
			$_stmt->bindParam(":stmt_date", $_stmtDate);
			$_stmt->bindParam(":client_id", $_clientId);
			$_stmt->bindParam(":total_amount", $_totalAmount);
			$_stmt->bindParam(":status", $_status);
			
			$_stmtDate = date("Y-m-d");
			$_clientId = $_SESSION["_userid"];
			$_status = "Placed";
			$_stmt->execute();
			
			
			$_SESSION["_tempstmt"] = null;
			header("location:?nav=stmthis");
		}
		catch(PDOException $_e){
			echo "Error! ".$_e->getMessage();
		}
		
	}
?>