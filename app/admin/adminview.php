<?php
	class AdminView{
		private $_nav;
		private $_size;
		private $_type;
		private $_colourCodes;
		private $_clientId;
		private $_action;
		private $_lessStock;
		private $_allStock;
		private $_stmt;
		private $_bill;
		private $_price;
		private $_suppId;
		private $_purTrans;
		private $_msg;
		private $_msgObj;
		
		public function _loadGUI(){
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="keywords" content="">
		<meta name="description" content="">
		<meta name="author" content="Anirudha Anil Mahadik">
		<title>Dashboard > Admin</title>
		<link rel="shortcut icon" href="../../images/favicon.png" type="image/x-icon" />
		
		<!-- CSS -->
		<link href="../../bootstrap/css/bootstrap.min.css" rel="stylesheet">
		<link href="../../css/dashboard.css" rel="stylesheet">
		<link href="../../css/scroll.css" rel="stylesheet">
		<link href="../../css/messagebox.css" rel="stylesheet">
		
		<!-- Javascript -->
		<script src="../../bootstrap/js/jquery.min.js"></script>
		<script src="../../bootstrap/js/bootstrap.min.js"></script>
		<script src="../../js/messagebox.js"></script>
		<script src="../../js/forms.js"></script>
	</head>
	<body>
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-3 dash-sidebar">
					<h1>Dashboard</h1>
<?php
			$this->_getNavBar();
?>
				</div>
				<div class="col-md-9 dash-content">
<?php
			$this->_getPage();
?>
				</div>
			</div>
		</div>
<?php
			if(isset($this->_msg)){
				$this->_msgObj->_showMsgDialog($this->_msg);
			}
?>
	</body>
</html>
<?php
		}
		
		public function _setNav($_nav){
			$this->_nav = $_nav;
		}
		
		public function _getNavBar(){
			switch($this->_nav){
				case "home":
?>
					<ul class="nav">
						<li class="active"><a href="?nav=home">Home</a></li>
						<li><a href="?nav=purchase&flag=true">Purchase</a></li>
						<li><a href="?nav=payment">Payment</a></li>
						<li><a href="?nav=stmt&flag=true">Statement</a></li>
						<li><a href="?nav=billing&flag=true">Billing</a></li>
						<li><a href="?nav=pricing">Pricing</a></li>
						<li><a href="?nav=reports">Reports</a></li>
						<li><a href="?nav=signout">Sign Out</a></li>
					</ul>
<?php
				break;
				case "purchase":
?>
					<ul class="nav">
						<li><a href="?nav=home">Home</a></li>
						<li class="active"><a href="?nav=purchase&flag=true">Purchase</a></li>
						<li><a href="?nav=payment">Payment</a></li>
						<li><a href="?nav=stmt&flag=true">Statement</a></li>
						<li><a href="?nav=billing&flag=true">Billing</a></li>
						<li><a href="?nav=pricing">Pricing</a></li>
						<li><a href="?nav=reports">Reports</a></li>
						<li><a href="?nav=signout">Sign Out</a></li>
					</ul>
<?php
				break;
				case "payment":
?>
					<ul class="nav">
						<li><a href="?nav=home">Home</a></li>
						<li><a href="?nav=purchase&flag=true">Purchase</a></li>
						<li class="active"><a href="?nav=payment">Payment</a></li>
						<li><a href="?nav=stmt&flag=true">Statement</a></li>
						<li><a href="?nav=billing&flag=true">Billing</a></li>
						<li><a href="?nav=pricing">Pricing</a></li>
						<li><a href="?nav=reports">Reports</a></li>
						<li><a href="?nav=signout">Sign Out</a></li>
					</ul>
<?php
				break;
				case "stmt":
?>
					<ul class="nav">
						<li><a href="?nav=home">Home</a></li>
						<li><a href="?nav=purchase&flag=true">Purchase</a></li>
						<li><a href="?nav=payment">Payment</a></li>
						<li class="active"><a href="?nav=stmt&flag=true">Statement</a></li>
						<li><a href="?nav=billing&flag=true">Billing</a></li>
						<li><a href="?nav=pricing">Pricing</a></li>
						<li><a href="?nav=reports">Reports</a></li>
						<li><a href="?nav=signout">Sign Out</a></li>
					</ul>
<?php
				break;
				case "billing":
?>
					<ul class="nav">
						<li><a href="?nav=home">Home</a></li>
						<li><a href="?nav=purchase&flag=true">Purchase</a></li>
						<li><a href="?nav=payment">Payment</a></li>
						<li><a href="?nav=stmt&flag=true">Statement</a></li>
						<li class="active"><a href="?nav=billing&flag=true">Billing</a></li>
						<li><a href="?nav=pricing">Pricing</a></li>
						<li><a href="?nav=reports">Reports</a></li>
						<li><a href="?nav=signout">Sign Out</a></li>
					</ul>
<?php
				break;
				/*
				case "stock":
?>
					<ul class="nav">
						<li><a href="?nav=home">Home</a></li>
						<li><a href="?nav=purchase&flag=true">Purchase</a></li>
						<li><a href="?nav=payment">Payment</a></li>
						<li><a href="?nav=stmt&flag=true">Statement</a></li>
						<li><a href="?nav=billing&flag=true">Billing</a></li>
						<li class="active"><a href="?nav=stock">Stock</a></li>
						<li><a href="?nav=pricing">Pricing</a></li>
						<li><a href="?nav=client">Client</a></li>
						<li><a href="?nav=reports">Reports</a></li>
						<li><a href="?nav=signout">Sign Out</a></li>
					</ul>
<?php
				break;
				*/
				case "pricing":
?>
					<ul class="nav">
						<li><a href="?nav=home">Home</a></li>
						<li><a href="?nav=purchase&flag=true">Purchase</a></li>
						<li><a href="?nav=payment">Payment</a></li>
						<li><a href="?nav=stmt&flag=true">Statement</a></li>
						<li><a href="?nav=billing&flag=true">Billing</a></li>
						<li class="active"><a href="?nav=pricing">Pricing</a></li>
						<li><a href="?nav=reports">Reports</a></li>
						<li><a href="?nav=signout">Sign Out</a></li>
					</ul>
<?php
				break;
				/*
				case "client":
?>
					<ul class="nav">
						<li><a href="?nav=home">Home</a></li>
						<li><a href="?nav=purchase&flag=true">Purchase</a></li>
						<li><a href="?nav=payment">Payment</a></li>
						<li><a href="?nav=stmt&flag=true">Statement</a></li>
						<li><a href="?nav=billing&flag=true">Billing</a></li>
						<li><a href="?nav=stock">Stock</a></li>
						<li><a href="?nav=pricing">Pricing</a></li>
						<li class="active"><a href="?nav=client">Client</a></li>
						<li><a href="?nav=reports">Reports</a></li>
						<li><a href="?nav=signout">Sign Out</a></li>
					</ul>
<?php
				break;
				*/
				case "reports":
?>
					<ul class="nav">
						<li><a href="?nav=home">Home</a></li>
						<li><a href="?nav=purchase&flag=true">Purchase</a></li>
						<li><a href="?nav=payment">Payment</a></li>
						<li><a href="?nav=stmt&flag=true">Statement</a></li>
						<li><a href="?nav=billing&flag=true">Billing</a></li>
						<li><a href="?nav=pricing">Pricing</a></li>
						<li class="active"><a href="?nav=reports">Reports</a></li>
						<li><a href="?nav=signout">Sign Out</a></li>
					</ul>
<?php
				break;
				default:
?>
					<ul class="nav">
						<li class="active"><a href="?nav=home">Home</a></li>
						<li><a href="?nav=purchase&flag=true">Purchase</a></li>
						<li><a href="?nav=payment">Payment</a></li>
						<li><a href="?nav=stmt&flag=true">Statement</a></li>
						<li><a href="?nav=billing&flag=true">Billing</a></li>
						<li><a href="?nav=pricing">Pricing</a></li>
						<li><a href="?nav=reports">Reports</a></li>
						<li><a href="?nav=signout">Sign Out</a></li>
					</ul>
<?php
				break;
			}
		}
		
		public function _getPage(){
			switch($this->_nav){
				case "home":
					require_once("greetings.php");
					$_greetings = new Greetings();
					$_greetings->_getPage();
				break;
				case "purchase":
					require_once("purchase.php");
					$_purchase = new Purchase($this->_suppId);
					$_purchase->_getPage();
				break;
				case "payment":
					require_once("payment.php");
					$_payment = new Payment($this->_suppId, $this->_clientId);
					$_payment->_getPage();
				break;
				case "stmt":
					require_once("statements.php");
					$_statements = new Statements($this->_size, $this->_type, $this->_colourCodes, $this->_clientId);
					$_statements->_getPage();
				break;
				case "billing":
					require_once("billing.php");
					$_billing = new Billing($this->_size, $this->_type, $this->_colourCodes, $this->_clientId);
					$_billing->_getPage();
				break;
				/*
				case "stock":
					require_once("stock.php");
					$_stock = new Stock($this->_action, $this->_lessStock, $this->_allStock);
					$_stock->_getPage();
				break;
				*/
				case "pricing":
					require_once("pricing.php");
					$_pricing = new Pricing($this->_price);
					$_pricing->_getPage();
				break;
				/*
				case "client":
					echo $this->_nav;
				break;
				*/
				case "reports":
					require_once("reports.php");
					$_reports = new Reports($this->_action, $this->_stmt, $this->_bill, $this->_purTrans, $this->_suppId, $this->_clientId);
					$_reports->_getPage();
				break;
				default:
					require_once("greetings.php");
					$_greetings = new Greetings();
					$_greetings->_getPage();
				break;
			}
		}
		
		public function _setSize($_size){
			$this->_size = $_size;
		}
		
		public function _setType($_type){
			$this->_type = $_type;
		}
		
		public function _setColourCodes($_colourCodes){
			$this->_colourCodes = $_colourCodes;
		}
		
		public function _setClientId($_clientId){
			$this->_clientId = $_clientId;
		}
		/*
		public function _setStockAction($_action){
			$this->_action = $_action;
		}
		
		public function _setLessStock($_lessStock){
			$this->_lessStock = $_lessStock;
		}
		
		public function _setAllStock($_allStock){
			$this->_allStock = $_allStock;
		}
		*/
		public function _setReportAction($_action){
			$this->_action = $_action;
		}
		
		public function _setStmt($_stmt){
			$this->_stmt = $_stmt;
		}
		
		public function _setBill($_bill){
			$this->_bill = $_bill;
		}
		
		public function _setPricing($_price){
			$this->_price = $_price;
		}
		
		public function _setSuppId($_suppId){
			$this->_suppId = $_suppId;
		}
		
		public function _setPurTrans($_purTrans){
			$this->_purTrans = $_purTrans;
		}
		
		public function _setMsgObj($_msg, $_msgObj){
			$this->_msg = $_msg;
			$this->_msgObj = $_msgObj;
		}
	}
?>