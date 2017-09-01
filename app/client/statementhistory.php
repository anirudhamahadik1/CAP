<?php
	function _statementHistoryForm(){
?>
			<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
				<div class="row">
					<div class="col-md-2">
						<select name="month" class="form-control" required>
							<option value="-1">Select Month</option>
							<option value="1">January</option>
							<option value="2">February</option>
							<option value="3">March</option>
							<option value="4">April</option>
							<option value="5">May</option>
							<option value="6">June</option>
							<option value="7">July</option>
							<option value="8">August</option>
							<option value="9">September</option>
							<option value="10">October</option>
							<option value="11">November</option>
							<option value="12">December</option>
						</select>
					</div>
					<div class="col-md-10">
						<input type="hidden" name="nav" value="stmthis">
						<button type="submit" class="btn btn-primary" name="filterstmt" value="true">Filer</button>
					</div>
				</div>
			</form>
			<br>
			<div class="scroll-div">
				<table class="table table-condensed table-striped">
					<tr>
						<th>#</th>
						<th>Statement Id</th>
						<th>Date</th>
						<th>Amount</th>
						<th>Status</th>
						<th>Action</th>
					</tr>
<?php
		if(isset($_REQUEST["filterstmt"])){
			_displayStmtTrans($_REQUEST["month"]);
		}
		else{
			_displayStmtTrans(date("m"));
		}
?>
				</table>
			</div>
<?php
	}
	
	function _displayStmtTrans($month){
		if($month == -1){
			$month = date("m");
		}
		_databaseConnect();
		global $_conn;
		try{
			$_stmt = $_conn->prepare("SELECT * FROM statement_transactions WHERE stmt_date >= :start_date AND stmt_date <= :end_date AND client_id = :client_id ORDER BY stmt_date DESC");
			$_stmt->bindParam(":start_date", $_startDate);
			$_stmt->bindParam(":end_date", $_endDate);
			$_stmt->bindParam(":client_id", $_clientId);
			
			$_startDate = date("Y-").$month."-1";
			$_endDate = date("Y-").$month."-31";
			$_clientId = $_SESSION["_userid"];
			
			$_stmt->execute();
			$_stmt->setFetchMode(PDO::FETCH_ASSOC);
			$_result = $_stmt->fetchAll();
			if(!empty($_result)){
				foreach($_result as $k => $v){
?>
					<tr>
						<td><?php echo ($k + 1); ?></td>
						<td><?php echo $v["stmt_id"]; ?></td>
						<td><?php echo $v["stmt_date"]; ?></td>
						<td><?php echo $v["total_amount"]."/-"; ?></td>
						<td><?php echo $v["status"]; ?></td>
						<td>
							<a href="viewstatement.php?stmtid=<?php echo $v["stmt_id"]; ?>" target="_blank">View</a> |
<?php
					if($v["status"] == "Placed"){
?>
							<a href="?submit=delstmt&stmtid=<?php echo $v["stmt_id"]; ?>">Delete</a>
<?php
					}
?>
						</td>
					</tr>
<?php
				}
			}
		}
		catch(PDOException $_e){
			echo "Error! ".$_e->getMessage();
		}
	}
?>