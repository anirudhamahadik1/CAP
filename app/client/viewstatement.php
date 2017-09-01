<?php
	define("DS", DIRECTORY_SEPARATOR);
	
	session_start();
	if(isset($_SESSION["_usertype"]) && $_SESSION["_usertype"] == "client"){
		require_once("..".DS."common.php");
		$_result = _getStatements();
		
?>
<html>
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="keywords" content="">
		<meta name="description" content="">
		<meta name="author" content="Anirudha Anil Mahadik">
		<title>Dashboard > Client > Statement</title>
		<link rel="shortcut icon" href="../../images/favicon.jpg" type="image/x-icon" />
		
		<!-- CSS -->
		<link href="../../bootstrap/css/bootstrap.min.css" rel="stylesheet">
		
		<!-- Javascript -->
		<script src="../../bootstrap/js/jquery.min.js"></script>
		<script src="../../bootstrap/js/bootstrap.min.js"></script>
	</head>
	<body>
		<div class="container">
			<div class="row text-center">
				<h1>CAP Furniture Industries</h1>
				<hr>
				<label>Statement Id:</label> <?php echo $_REQUEST["stmtid"]; ?> | <label>Date:</label> <?php echo $_result[0]["stmt_date"]; ?>
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
						<td><?php echo $v["amount"]."/-"; ?></td>
					</tr>
<?php
		}
?>
				</table>
				<label>Total Amount:</label> <?php echo $_result[0]["total_amount"]."/-"; ?><br>
				<p><label>T &amp; C:</label> 13.5% TAX apply on every bill.</p>
			</div>
		</div>
	</body>
</html>
<?php
	}
	else{
		header("location:../?alert=Warning! Unauthorised Access.");
	}
	
	function _getStatements(){
		_databaseConnect();
		global $_conn;
		try{
			$_stmt = $_conn->prepare("SELECT s.length, s.breadth, s.size, s.type, s.cc_id, s.qty, s.amount, st.stmt_date, st.total_amount FROM statements AS s INNER JOIN statement_transactions AS st ON s.stmt_id = st.stmt_id WHERE st.stmt_id = :stmt_id");
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
?>