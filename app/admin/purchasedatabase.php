<?php
	class PurchaseDatabase{
		public function _setTempPur(){
			$_tempArr = array($_REQUEST["desc"], $_REQUEST["qty"], $_REQUEST["amount"]);
			$_SESSION["_tempPur"][] = $_tempArr;
		}
		
		public function _delTempPur(){
			unset($_SESSION["_tempPur"][$_REQUEST["token"]]);
			$_SESSION["_tempPur"] = array_values($_SESSION["_tempPur"]);
		}
		
		public function _insertPurTrans(){
			if($_REQUEST["paytype"] == "cheque" && empty($_REQUEST["amountpaid"])){
				header("location:?nav=purchase&msg=Please enter cheque amount.");
			}
			else{
				$_purchaseId = "PUR".date("YmdhisA");
			
				$_databaseConnection = new DatabaseConnection();
				$_databaseConnection->_getDatabaseConnection();
				global $_conn;
				try{
					$_stmt = $_conn->prepare("INSERT INTO purchase (description, qty, amount, purchase_id) VALUES (:description, :qty, :amount, :purchase_id)");
					$_stmt->bindParam(":description", $_description);
					$_stmt->bindParam(":qty", $_qty);
					$_stmt->bindParam(":amount", $_amount);
					$_stmt->bindParam(":purchase_id", $_purchaseId);
					
					$_netAmount = 0;
					foreach($_SESSION["_tempPur"] as $_k => $_v){
						$_description = $_v[0];
						$_qty = $_v[1];
						$_amount = $_v[2];
						$_stmt->execute();
						
						$_netAmount += $_v[2];
					}
					
					$_stmt = $_conn->prepare("INSERT INTO purchase_transactions (purchase_id, purchase_date, supp_id, pay_type, net_amount) VALUES (:purchase_id, :purchase_date, :supp_id, :pay_type, :net_amount)");
					$_stmt->bindParam(":purchase_id", $_purchaseId);
					$_stmt->bindParam(":purchase_date", $_purchaseDate);
					$_stmt->bindParam(":supp_id", $_suppId);
					$_stmt->bindParam(":pay_type", $_payType);
					$_stmt->bindParam(":net_amount", $_netAmount);
					
					$_purchaseDate = date("Y-m-d");
					$_suppId = $_REQUEST["suppid"];
					$_payType = $_REQUEST["paytype"];
					$_stmt->execute();
					
					$_commonClass = new CommonClass();
					if($_REQUEST["paytype"] == "credit"){
						$_commonClass->_insertJournal("Purchase", "Purchase Goods", $_netAmount);
					}
					else{
						$_commonClass->_insertJournal("Purchase", "Purchase Goods", $_netAmount);
						$_commonClass->_insertJournal("Payment", "Payment", $_REQUEST["amountpaid"]);
					}
					
					$_SESSION["_tempPur"] = null;
				}
				catch(PDOException $_e){
					echo "Error! ".$_e->getMessage();
				}
			}
			
		}
	}
?>