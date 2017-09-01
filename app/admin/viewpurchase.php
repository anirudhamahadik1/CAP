<?php
	require_once("common.php");
	
	class ViewPurchase{
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
		<title>Dashboard > Admin > Purchase</title>
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
				<label>PURCHASE</label>
				<h1>CAP Furniture Industries</h1>
				<p>
					Manufacturer of Marine Shutter, Bed, Wardrobe, Office Table and all Kitchen Furniture.<br>
					Plot no: 8 M.I.D.C. Gokul Shirgaon, Kolhapur - 416 234<br>
					<label>Contact:</label> 9960688464 / 9011294466 / 9975207172, <label>Email:</label> cappns10@gmail.com
				</p>
			</div>
			<hr>
			<div class="row">
				<div class="col-xs-6">
					<label>Supplier Name:</label> <?php echo $_result[0]["supp_id"]; ?>
				</div>
				<div class="col-xs-6">
					<label>Purchase No:</label> <?php echo $_result[0]["sr_no"]; ?><br>
					<label>Purchase Id:</label> <?php echo $_REQUEST["purid"]; ?><br>
					<label>Date:</label> <?php echo $_result[0]["purchase_date"]; ?>
				</div>
			</div>
			<br>
			<div class="row">
				<table class="table table-condensed table-striped">
					<tr>
						<th>Description</th>
						<th>Quantity</th>
						<th>Amount</th>
					</tr>
					
<?php
		foreach($_result as $k => $v){
?>
					<tr>
						<td><?php echo $v["description"]; ?></td>
						<td><?php echo $v["qty"]; ?></td>
						<td><?php echo $v["amount"]."/-"; ?></td>
					</tr>
<?php
		}
?>
					<tr>
						<td colspan="2" class="text-right"><label>Net Amount:</label></td>
						<td><?php echo $_result[0]["net_amount"]."/-"; ?></td>
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
				$_stmt = $_conn->prepare("SELECT p.description, p.qty, p.amount, pt.purchase_date, pt.sr_no, pt.supp_id, pt.net_amount FROM purchase AS p INNER JOIN purchase_transactions AS pt ON p.purchase_id = pt.purchase_id WHERE pt.purchase_id = :purchase_id");
				$_stmt->bindParam(":purchase_id", $_purchaseId);
				
				$_purchaseId = $_REQUEST["purid"];
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
		$_viewPurchase = new ViewPurchase();
		$_viewPurchase->_displayReport();
	}
	else{
		header("location:../?alert=Warning! Unauthorised Access.");
	}
?>