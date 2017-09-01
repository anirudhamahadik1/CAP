<?php
	require_once("common.php");
	require_once("commonclass.php");
	require_once("statementdatabase.php");
	require_once("billingdatabase.php");
	require_once("stockdatabase.php");
	require_once("reportsdatabase.php");
	require_once("pricingdatabase.php");
	require_once("purchasedatabase.php");
	
	class AdminController{
		private $_adminModel;
		private $_adminView;
		
		public function __construct($_adminModel, $_adminView){
			$this->_adminModel = $_adminModel;
			$this->_adminView = $_adminView;
		}
		
		public function _loadAdminGUI(){
			$this->_adminView->_loadGUI();
		}
		
		public function _getNavPage(){
			$_nav = $_REQUEST["nav"];
			$this->_adminView->_setNav($_nav);
			switch($_nav){
				case "home":
					
				break;
				case "purchase":
					if(isset($_REQUEST["flag"])){
						$_SESSION["_tempPur"] = null;
					}
					
					$_commonClass = new CommonClass();
					$this->_adminModel = $_commonClass->_getSuppIdObject();
					$_suppId = $this->_adminModel->_getSuppId();
					$this->_adminView->_setSuppId($_suppId);
				break;
				case "payment":
					$_commonClass = new CommonClass();
					$this->_adminModel = $_commonClass->_getSuppIdObject();
					$_suppId = $this->_adminModel->_getSuppId();
					$this->_adminView->_setSuppId($_suppId);
					
					$this->_adminModel = $_commonClass->_getClientIdObject();
					$_clientId = $this->_adminModel->_getClientId();
					$this->_adminView->_setClientId($_clientId);
				break;
				case "stmt":
					if(isset($_REQUEST["flag"])){
						$_SESSION["_tempStmt"] = null;
					}
					
					$_commonClass = new CommonClass();
					$this->_adminModel = $_commonClass->_getSizeObject();
					$_size = $this->_adminModel->_getSize();
					$this->_adminView->_setSize($_size);
					
					$this->_adminModel = $_commonClass->_getTypeObject();
					$_type = $this->_adminModel->_getType();
					$this->_adminView->_setType($_type);
					
					$this->_adminModel = $_commonClass->_getColourCodesObject();
					$_colourCodes = $this->_adminModel->_getColourCodes();
					$this->_adminView->_setColourCodes($_colourCodes);
					
					$this->_adminModel = $_commonClass->_getClientIdObject();
					$_clientId = $this->_adminModel->_getClientId();
					$this->_adminView->_setClientId($_clientId);
				break;
				case "billing":
					if(isset($_REQUEST["flag"])){
						$_SESSION["_tempBill"] = null;
					}
					
					$_commonClass = new CommonClass();
					$this->_adminModel = $_commonClass->_getSizeObject();
					$_size = $this->_adminModel->_getSize();
					$this->_adminView->_setSize($_size);
					
					$this->_adminModel = $_commonClass->_getTypeObject();
					$_type = $this->_adminModel->_getType();
					$this->_adminView->_setType($_type);
					
					$this->_adminModel = $_commonClass->_getColourCodesObject();
					$_colourCodes = $this->_adminModel->_getColourCodes();
					$this->_adminView->_setColourCodes($_colourCodes);
					
					$this->_adminModel = $_commonClass->_getCustIdObject();
					$_clientId = $this->_adminModel->_getClientId();
					$this->_adminView->_setClientId($_clientId);
				break;
				/*
				case "stock":
					$_action = null;
					if(isset($_REQUEST["action"])){
						$_action = $_REQUEST["action"];
					}
					$this->_adminView->_setStockAction($_action);
					
					$_stockDatabase = new StockDatabase();
					$this->_adminModel = $_stockDatabase->_getLessStockObject();
					$_lessStock = $this->_adminModel->_getLessStock();
					$this->_adminView->_setLessStock($_lessStock);
					
					$this->_adminModel = $_stockDatabase->_getAllStockObject();
					$_allStock = $this->_adminModel->_getAllStock();
					$this->_adminView->_setAllStock($_allStock);
				break;
				*/
				case "pricing":
					$_pricingDatabase = new PricingDatabase();
					$this->_adminModel = $_pricingDatabase->_getPricingObject();
					$_pricing = $this->_adminModel->_getPricing();
					$this->_adminView->_setPricing($_pricing);
				break;
				/*
				case "client":
					
				break;
				*/
				case "reports":
					$_action = null;
					if(isset($_REQUEST["action"])){
						$_action = $_REQUEST["action"];
					}
					$this->_adminView->_setReportAction($_action);
					
					$_reportsDatabase = new ReportsDatabase();
					$this->_adminModel = $_reportsDatabase->_getStmtTransObject();
					$_stmt = $this->_adminModel->_getStmtTrans();
					$this->_adminView->_setStmt($_stmt);
					
					$this->_adminModel = $_reportsDatabase->_getBillTransObject();
					$_bill = $this->_adminModel->_getBillTrans();
					$this->_adminView->_setBill($_bill);
					
					$this->_adminModel = $_reportsDatabase->_getPurchaseTransObject();
					$_purTrans = $this->_adminModel->_getPurTrans();
					$this->_adminView->_setPurTrans($_purTrans);
					
					$_commonClass = new CommonClass();
					$this->_adminModel = $_commonClass->_getSuppIdObject();
					$_suppId = $this->_adminModel->_getSuppId();
					$this->_adminView->_setSuppId($_suppId);
					
					$this->_adminModel = $_commonClass->_getClientIdObject();
					$_clientId = $this->_adminModel->_getClientId();
					$this->_adminView->_setClientId($_clientId);
				break;
				case "signout":
					session_unset();
					session_destroy();
					header("location:..");
				break;
				default:
					
				break;
			}
			if(isset($_REQUEST["msg"])){
				require_once("messagebox.php");
				$_messageBox = new MessageBox();
				$this->_adminView->_setMsgObj($_REQUEST["msg"], $_messageBox);
			}
			$this->_adminView->_loadGUI();
		}
		
		public function _getSubmitEvent(){
			$_submit = $_REQUEST["submit"];
			$_commonClass = new CommonClass();
			$_statementDatabase = new StatementDatabase();
			$_billingDatabase = new BillingDatabase();
			$_pricingDatabase = new PricingDatabase();
			$_purchaseDatabase = new PurchaseDatabase();
			switch($_submit){
				case "addtempstmt":
					$this->_adminModel = $_commonClass->_getPricing();
					$_statementDatabase->_setTempStmt($this->_adminModel->_getPricing());
				break;
				case "deltempstmt":
					$_statementDatabase->_delTempStmt();
					header("location:?nav=stmt");
				break;
				case "submitstmt":
					if(empty($_SESSION["_tempStmt"])){
						header("location:?nav=stmt&msg=Please add statment records.");
					}
					else{
						$_statementDatabase->_insertStmtTrans();
						header("location:?nav=reports&action=stmt&msg=Successfully added transaction.");
					}
				break;
				case "addtempbill":
					$this->_adminModel = $_commonClass->_getPricing();
					$_billingDatabase->_setTempBill($this->_adminModel->_getPricing());
				break;
				case "deltempbill":
					$_billingDatabase->_delTempBill();
					header("location:?nav=billing");
				break;
				case "submitbill":
					if(empty($_SESSION["_tempBill"])){
						header("location:?nav=billing&msg=Please add billing records.");
					}
					else{
						$_billingDatabase->_insertBillTrans();
						header("location:?nav=reports&action=billing&msg=Successfully added transaction.");
					}
				break;
				case "addpricing":
					$_pricingDatabase->_insertPricing();
					header("location:?nav=pricing");
				break;
				case "delpricing":
					$_pricingDatabase->_deletePricing();
					header("location:?nav=pricing");
				break;
				case "addtemppur":
					$_purchaseDatabase->_setTempPur();
					header("location:?nav=purchase");
				break;
				case "deltemppur":
					$_purchaseDatabase->_delTempPur();
					header("location:?nav=purchase");
				break;
				case "subpurtrans":
					if(empty($_SESSION["_tempPur"])){
						header("location:?nav=purchase&msg=Please add purchase records.");
					}
					else{
						$_purchaseDatabase->_insertPurTrans();
						header("location:?nav=purchase&msg=Successfully added purchase record.");
					}
				break;
				case "subpayment":
					$_commonClass->_insertJournal("Payment", "Payment", $_REQUEST["amountpaid"]);
					header("location:?nav=payment&msg=Successfully added payment record.");
				break;
				default:
					
				break;
			}
		}
	}
?>