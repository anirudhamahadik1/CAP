<?php
	require_once("common.php");
	
	class ViewStatement{
		public function _displayReport(){
			$_result = $this->_getResult();
?>
<html>
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="keywords" content="">
		<meta name="description" content="">
		<meta name="author" content="Anirudha Anil Mahadik">
		<title>Dashboard > Admin > Statement</title>
		<link rel="shortcut icon" href="../../images/favicon.png" type="image/x-icon" />
		
		<!-- CSS -->
		<link href="../../bootstrap/css/bootstrap.min.css" rel="stylesheet">
		
		<!-- Javascript -->
		<script src="../../bootstrap/js/jquery.min.js"></script>
		<script src="../../bootstrap/js/bootstrap.min.js"></script>
	</head>
	<body>
		<div class="container">
			<div class="row text-center">
				<label style="font-size:1.6em;">STATEMENT</label>
				<h1>CAP Furniture Industries</h1>
				<p>
					Manufacturer of Marine Shutter, Bed, Wardrobe, Office Table and all Kitchen Furniture.<br>
					P - 8 M.I.D.C. Gokul Shirgaon, Kolhapur - 416 234<br>
					<label>Contact:</label> 9960688464 / 9011294466 / 9975207172, <label>Email:</label> cappns10@gmail.com
				</p>
			</div>
			<hr>
			<div class="row">
				<div class="col-xs-6">
					<label>GSTIN:</label> 27AAJFC6002D1ZX<br>
					<label>PAN:</label> AAJFC6002D<br>
					<label>State Code:</label> 27<br>
				</div>
				<div class="col-xs-6">
					<label>Statement No:</label> <?php echo $_result[0]["sr_no"]." / ".date("Y")."-".(date("y") + 1); ?><br>
					<label>Date:</label> <?php echo $_result[0]["stmt_date"]; ?><br>
					<label>Client Name:</label> <?php echo $_result[0]["client_id"]; ?>
				</div>
			</div>
			<br>
			<div class="row">
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
					</tr>
					
<?php
		foreach($_result as $k => $v){
?>
					<tr>
						<td><?php echo $v["length"]; ?></td>
						<td><?php echo $v["breadth"]; ?></td>
						<td><?php echo $v["size"]; ?></td>
						<td><?php echo $v["type"]; ?></td>
						<td><?php echo $v["cc_id"]; ?></td>
						<td><?php echo $v["qty"]; ?></td>
						<td><?php echo $v["sq_ft"]; ?></td>
						<td><?php echo $v["amount_per_sqft"]; ?></td>
						<td><?php echo $v["amount"]."/-"; ?></td>
					</tr>
<?php
		}
?>
					<tr>
						<td colspan="8" class="text-right"><strong>Cap:</strong></td>
						<td><?php echo $_result[0]["cap"]."/-"; ?></td>
					</tr>
					<tr>
						<td colspan="8" class="text-right"><strong>Concil Handle:</strong></td>
						<td><?php echo $_result[0]["concil_handle"]."/-"; ?></td>
					</tr>
					<tr>
						<td colspan="8" class="text-right"><strong>Total Amount:</strong></td>
						<td><?php echo round($_result[0]["total_amount"])."/-"; ?></td>
					</tr>
					<tr>
						<td colspan="7" class="text-right"><strong>Tax:</strong></td>
						<td class="text-right">
							<strong>SGST (<?php echo ($_result[0]["tax"] / 2)."%"; ?>):</strong><br>
							<strong>CGST (<?php echo ($_result[0]["tax"] / 2)."%"; ?>):</strong>
						</td>
						<td>
							<?php echo round($_result[0]["tax_amount"] / 2)."/-"; ?><br>
							<?php echo round($_result[0]["tax_amount"] / 2)."/-"; ?>
						</td>
					</tr>
					<tr>
						<td colspan="8" class="text-right"><strong>Labour:</strong></td>
						<td><?php echo $_result[0]["labour"]."/-"; ?></td>
					</tr>
					<tr>
						<td colspan="8" class="text-right"><strong>Net Amount:</strong></td>
						<td><?php echo round($_result[0]["net_amount"])."/-"; ?></td>
					</tr>
				</table>
			</div>
		</div>
	</body>
</html>
<?php
		}
		
		public function _getResult(){
			$_databaseConnection = new DatabaseConnection();
			$_databaseConnection->_getDatabaseConnection();
			global $_conn;
			try{
				$_stmt = $_conn->prepare("SELECT st.sr_no, s.length, s.breadth, s.size, s.type, s.cc_id, s.qty, s.sq_ft, s.amount_per_sqft, s.amount, st.stmt_date, st.client_id, st.tax, st.tax_amount, st.total_amount, st.net_amount, st.cap, st.concil_handle, st.labour FROM statements AS s INNER JOIN statement_transactions AS st ON s.stmt_id = st.stmt_id WHERE st.stmt_id = :stmt_id");
				$_stmt->bindParam(":stmt_id", $_stmtId);
				
				$_stmtId = $_REQUEST["stmtid"];
				$_stmt->execute();
				$_stmt->setFetchMode(PDO::FETCH_ASSOC);
				$_result = $_stmt->fetchAll();
				
				return $_result;
			}
			catch(PDOException $_e){
				echo "Error! ".$_e->getMessage();
			}
		}
	}
	
	session_start();
	if(isset($_SESSION["_usertype"]) && $_SESSION["_usertype"] == "admin"){
		$_viewStatement = new ViewStatement();
		$_viewStatement->_displayReport();
	}
	else{
		header("location:../?alert=Warning! Unauthorised Access.");
	}
?>