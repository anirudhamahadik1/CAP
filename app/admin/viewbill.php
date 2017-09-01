<?php
	require_once("common.php");
	
	class ViewBill{
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
		<title>Dashboard > Admin > Bill</title>
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
				<label style="font-size:1.6em;">TAX INVOICE</label>
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
					<label>Invoice No:</label> <?php echo $_result[0]["sr_no"]." / ".date("Y")."-".(date("y") + 1); ?><br>
					<label>Invoice Date:</label> <?php echo $_result[0]["bill_date"]; ?>
				</div>
			</div>
			<hr>
			<div class="row">
				<div class="col-xs-6">
					<h4>Billing Details</h4>
					<?php
						$_addressArray = explode(",", $_result[0]["client_id"]);
						foreach($_addressArray as $_v){
							echo $_v."<br>";
						}
					?>
				</div>
				<div class="col-xs-6">
					<h4>Shipping Details</h4>
					<?php
						foreach($_addressArray as $_v){
							echo $_v."<br>";
						}
					?>
				</div>
			</div>
			<br>
			<div class="row">
				<table class="table table-condensed table-striped">
					<tr>
						<th>#</th>
						<th>Particulars</th>
						<th>HSN</th>
						<th>Sq. Ft.</th>
						<th>Quantity</th>
						<th>Rate/Sq. Ft.</th>
						<th>Amount</th>
					</tr>
					
<?php
		foreach($_result as $k => $v){
?>
					<tr>
						<td><?php echo ($k + 1); ?></td>
						<td><?php echo $v["description"].": ".$v["size"]."mm ".$v["type"].", Colour:".$v["cc_id"]; ?></td>
						<td>...</td>
						<td><?php echo $v["sq_ft"]; ?></td>
						<td><?php echo $v["qty"]; ?></td>
						<td><?php echo $v["amount_per_sqft"]."/-"; ?></td>
						<td><?php echo $v["amount"]."/-"; ?></td>
					</tr>
<?php
		}
?>
					<tr>
						<td colspan="6" class="text-right"><strong>Cap:</strong></td>
						<td><?php echo $_result[0]["cap"]."/-"; ?></td>
					</tr>
					<tr>
						<td colspan="6" class="text-right"><strong>Concil Handle:</strong></td>
						<td><?php echo $_result[0]["concil_handle"]."/-"; ?></td>
					</tr>
					<tr>
						<td colspan="6" class="text-right"><strong>Total Amount:</strong></td>
						<td><?php echo round($_result[0]["total_amount"])."/-"; ?></td>
					</tr>
					<tr>
						<td colspan="5" class="text-right"><strong>Tax:</strong></td>
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
						<td colspan="6" class="text-right"><strong>Labour:</strong></td>
						<td><?php echo $_result[0]["labour"]."/-"; ?></td>
					</tr>
					<tr>
						<td colspan="3"><strong>In Words:</strong> <?php echo $this->convert_number_to_words(round($_result[0]["net_amount"]))." Only."; ?></td>
						<td colspan="3" class="text-right"><strong>Net Amount:</strong></td>
						<td><?php echo round($_result[0]["net_amount"])."/-"; ?></td>
					</tr>
				</table>
			</div>
			<div class="row">
				<div class="col-xs-8">
					<!-- <h4>Terms and Conditions</h4> -->
				</div>
				<div class="col-xs-4 text-right">
					<p><strong>For CAP Furniture Industries</strong></p>
					<p style="margin-top:75px;"><strong>Partner</strong></p>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12 text-center" style="margin-top:50px;">
					This is Computer Generated Invoice.
				</div>
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
				$_stmt = $_conn->prepare("SELECT bt.sr_no, b.description, b.sq_ft, b.size, b.type, b.cc_id, b.qty, b.amount_per_sqft, b.amount, bt.bill_date, bt.client_id, bt.tax, bt.tax_amount, bt.total_amount, bt.net_amount, bt.cap, bt.concil_handle, bt.labour FROM billing AS b INNER JOIN billing_transactions AS bt ON b.bill_id = bt.bill_id WHERE bt.bill_id = :bill_id");
				$_stmt->bindParam(":bill_id", $_billId);
				
				$_billId = $_REQUEST["billid"];
				$_stmt->execute();
				$_stmt->setFetchMode(PDO::FETCH_ASSOC);
				$_result = $_stmt->fetchAll();
				
				return $_result;
			}
			catch(PDOException $_e){
				echo "Error! ".$_e->getMessage();
			}
		}
		
		public function convert_number_to_words($number) {
			$hyphen      = '-';
			$conjunction = ' and ';
			$separator   = ', ';
			$negative    = 'negative ';
			$decimal     = ' point ';
			$dictionary  = array(
				0                   => 'Zero',
				1                   => 'One',
				2                   => 'Two',
				3                   => 'Three',
				4                   => 'Four',
				5                   => 'Five',
				6                   => 'Six',
				7                   => 'Seven',
				8                   => 'Eight',
				9                   => 'Nine',
				10                  => 'Ten',
				11                  => 'Eleven',
				12                  => 'Twelve',
				13                  => 'Thirteen',
				14                  => 'Fourteen',
				15                  => 'Fifteen',
				16                  => 'Sixteen',
				17                  => 'Seventeen',
				18                  => 'Eighteen',
				19                  => 'Nineteen',
				20                  => 'Twenty',
				30                  => 'Thirty',
				40                  => 'Forty',
				50                  => 'Fifty',
				60                  => 'Sixty',
				70                  => 'Seventy',
				80                  => 'Eighty',
				90                  => 'Ninety',
				100                 => 'Hundred',
				1000                => 'Thousand',
				1000000             => 'Million',
				1000000000          => 'Billion',
				1000000000000       => 'Trillion',
				1000000000000000    => 'Quadrillion',
				1000000000000000000 => 'Quintillion'
			);

			if (!is_numeric($number)) {
				return false;
			}

			if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
				// overflow
				trigger_error(
					'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
					E_USER_WARNING
				);
				return false;
			}

			if ($number < 0) {
				return $negative . convert_number_to_words(abs($number));
			}

			$string = $fraction = null;

			if (strpos($number, '.') !== false) {
				list($number, $fraction) = explode('.', $number);
			}

			switch (true) {
				case $number < 21:
					$string = $dictionary[$number];
					break;
				case $number < 100:
					$tens   = ((int) ($number / 10)) * 10;
					$units  = $number % 10;
					$string = $dictionary[$tens];
					if ($units) {
						$string .= $hyphen . $dictionary[$units];
					}
					break;
				case $number < 1000:
					$hundreds  = $number / 100;
					$remainder = $number % 100;
					$string = $dictionary[$hundreds] . ' ' . $dictionary[100];
					if ($remainder) {
						$string .= $conjunction . $this->convert_number_to_words($remainder);
					}
					break;
				default:
					$baseUnit = pow(1000, floor(log($number, 1000)));
					$numBaseUnits = (int) ($number / $baseUnit);
					$remainder = $number % $baseUnit;
					$string = $this->convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
					if ($remainder) {
						$string .= $remainder < 100 ? $conjunction : $separator;
						$string .= $this->convert_number_to_words($remainder);
					}
					break;
			}

			if (null !== $fraction && is_numeric($fraction)) {
				$string .= $decimal;
				$words = array();
				foreach (str_split((string) $fraction) as $number) {
					$words[] = $dictionary[$number];
				}
				$string .= implode(' ', $words);
			}

			return $string;
		}
	}
	
	session_start();
	if(isset($_SESSION["_usertype"]) && $_SESSION["_usertype"] == "admin"){
		$_viewBill = new ViewBill();
		$_viewBill->_displayReport();
	}
	else{
		header("location:../?alert=Warning! Unauthorised Access.");
	}
?>