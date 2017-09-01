<?php
	require_once("common.php");
	
	class ViewLedger{
		public function _displayReport(){
			$_balanceResult = $this->_getBalanceResult();
			$_balance = 0;
			$_debit = 0;
			$_credit = 0;
			if(!empty($_balanceResult)){
				foreach($_balanceResult as $k => $v){
					if($v["trans_type"] == "Purchase"){
						$_debit += $v["amount"];
					}
					else{
						$_credit += $v["amount"];
					}
				}
			}
			$_balance = ($_debit - $_credit);
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
		<title>Dashboard > Admin > Ledger</title>
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
				<label>LEDGER</label>
				<h1>CAP Furniture Industries</h1>
				<p>
					Manufacturer of Marine Shutter, Bed, Wardrobe, Office Table and all Kitchen Furniture.<br>
					Plot no: 8 M.I.D.C. Gokul Shirgaon, Kolhapur - 416 234<br>
					<label>Contact:</label> 9960688464 / 9011294466 / 9975207172, <label>Email:</label> cappns10@gmail.com
				</p>
			</div>
			<hr>
			<div class="row">
				<div class="col-xs-12">
					<label>Supplier Name:</label>
<?php
			if(!empty($_result)){
				echo $_result[0]["supp_id"];
			}
			else{
				echo $_REQUEST["suppid"];
			}
?>
				</div>
			</div>
			<br>
			<div class="row">
				<table class="table table-condensed table-striped">
					<tr>
						<th>#</th>
						<th>Transaction Date</th>
						<th>Description</th>
						<th>Debit</th>
						<th>Credit</th>
						<th>Balance</th>
					</tr>
					<tr>
						<td>1</td>
						<td>&lt; <?php echo date("Y-m-1"); ?></td>
						<td>Previous Balance</td>
						<td><?php echo $_debit."/-"; ?></td>
						<td><?php echo $_credit."/-"; ?></td>
						<td><?php echo $_balance."/-"; ?></td>
					</tr>
					
<?php
		$_currentDebit = 0;
		$_currentCredit = 0;
		$_currentBalance = 0;
		if(!empty($_result)){
		foreach($_result as $k => $v){
?>
					<tr>
						<td><?php echo ($k + 2); ?></td>
						<td><?php echo $v["trans_date"]; ?></td>
						<td><?php echo $v["description"]; ?></td>
<?php
			if($v["trans_type"] == "Purchase"){
				$_debit += $v["amount"];
				$_currentDebit += $v["amount"];
?>
						<td><?php echo $v["amount"]."/-"; ?></td>
						<td></td>
<?php
			}
			else{
				$_credit += $v["amount"];
				$_currentCredit += $v["amount"];
?>
						<td></td>
						<td><?php echo $v["amount"]."/-"; ?></td>
<?php
			}
			$_currentBalance = ($_currentDebit - $_currentCredit);
?>
						<td><?php echo $_currentBalance."/-"; ?></td>
					</tr>
<?php
		}
		}
?>
					<tr>
						<td colspan="3" class="text-right"><label>Total Amount:</label></td>
						<td><?php echo $_debit."/-"; ?></td>
						<td><?php echo $_credit."/-"; ?></td>
						<td><?php echo ($_debit - $_credit)."/-"; ?></td>
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
				$_stmt = $_conn->prepare("SELECT * FROM journal WHERE supp_id = :supp_id AND trans_date > :start_date AND trans_date < :end_date");
				$_stmt->bindParam(":supp_id", $_suppId);
				$_stmt->bindParam(":start_date", $_startDate);
				$_stmt->bindParam(":end_date", $_endDate);
				
				$_suppId = $_REQUEST["suppid"];
				$_startDate = date("Y-".$_REQUEST["month"]."-1");
				$_endDate = date("Y-".$_REQUEST["month"]."-31");
				$_stmt->execute();
				$_stmt->setFetchMode(PDO::FETCH_ASSOC);
				$_result = $_stmt->fetchAll();
				
				return $_result;
			}
			catch(PDOException $_e){
				echo "Error! ".$_e->getMessage();
			}
		}
		
		public function _getBalanceResult(){
			$_databaseConnection = new DatabaseConnection();
			$_databaseConnection->_getDatabaseConnection();
			global $_conn;
			try{
				$_stmt = $_conn->prepare("SELECT * FROM journal WHERE supp_id = :supp_id AND trans_date < :end_date");
				$_stmt->bindParam(":supp_id", $_suppId);
				$_stmt->bindParam(":end_date", $_endDate);
				
				$_suppId = $_REQUEST["suppid"];
				$_endDate = date("Y-".$_REQUEST["month"]."-1");
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
		$_viewLedger = new ViewLedger();
		$_viewLedger->_displayReport();
	}
	else{
		header("location:../?alert=Warning! Unauthorised Access.");
	}
?>