<?php
	require_once("common.php");
	
	class ViewBillReg{
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
		<title>Dashboard > Admin > Billing Register</title>
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
				<label>BILLING REGISTER</label>
				<h1>CAP Furniture Industries</h1>
				<p>
					Manufacturer of Marine Shutter, Bed, Wardrobe, Office Table and all Kitchen Furniture.<br>
					P - 8 M.I.D.C. Gokul Shirgaon, Kolhapur - 416 234<br>
					<label>Contact:</label> 9960688464 / 9011294466 / 9975207172, <label>Email:</label> cappns10@gmail.com
				</p> 
			</div>
			<div class="row">
				<table class="table table-condensed table-striped">
					<tr>
						<th>#</th>
						<th>Date</th>
						<th>Client</th>
						<th>Tax</th>
						<th>SGST (14%)</th>
						<th>CGST (14%)</th>
						<th>Net Amount</th>
					</tr>
					
<?php
		$_taxAmount = 0;
		$_totalAmount = 0;
		$_netAmount = 0;
		foreach($_result as $k => $v){
?>
					<tr>
						<td><?php echo ($k + 1); ?></td>
						<td><?php echo $v["bill_date"]; ?></td>
						<td><?php echo $v["client_id"]; ?></td>
						<td><?php echo $v["tax"]."%"; ?></td>
						<td><?php echo round($v["tax_amount"] / 2)."/-"; ?></td>
						<td><?php echo round($v["tax_amount"] / 2)."/-"; ?></td>
						<td><?php echo round($v["net_amount"])."/-"; ?></td>
					</tr>
<?php
			$_taxAmount += $v["tax_amount"];
			$_totalAmount += $v["total_amount"];
			$_netAmount += $v["net_amount"];
		}
?>
					<tr>
						<td colspan="4"></td>
						<td><strong><?php echo round($_taxAmount / 2)."/-"; ?></strong></td>
						<td><strong><?php echo round($_taxAmount / 2)."/-"; ?></strong></td>
						<td><strong><?php echo round($_netAmount)."/-"; ?></strong></td>
					</tr>
				</table>
			</div>
		</div>
	</body>
</html>
<?php
		}
		
		public function _getResult(){
			$_month = date("m");
			if(isset($_REQUEST["month"])){
				$_month = $_REQUEST["month"];
			}
			$_databaseConnection = new DatabaseConnection();
			$_databaseConnection->_getDatabaseConnection();
			global $_conn;
			try{
				$_stmt = $_conn->prepare("SELECT * FROM billing_transactions WHERE bill_date >= :start_date AND bill_date <= :end_date");
				$_stmt->bindParam(":start_date", $_startDate);
				$_stmt->bindParam(":end_date", $_endDate);
				
				$_startDate = date("Y-".$_month."-01");
				$_endDate = date("Y-".$_month."-31");
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
		$_viewBillReg = new ViewBillReg();
		$_viewBillReg->_displayReport();
	}
	else{
		header("location:../?alert=Warning! Unauthorised Access.");
	}
?>