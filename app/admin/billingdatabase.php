<?php
	class BillingDatabase{
		public function _setTempBill($_pricing){
			if(isset($_pricing)){
				$_qty = $_REQUEST["qty"];
				$_amount = ($_REQUEST["sqft"] * $_pricing) * $_qty;
				$temparr = array($_REQUEST["desc"], $_REQUEST["sqft"], $_REQUEST["size"], $_REQUEST["type"], $_REQUEST["colour"], $_qty, $_pricing, $_amount);
				$_SESSION["_tempBill"][] = $temparr;
				header("location:?nav=billing");
			}
			else{
				header("location:?nav=billing&msg=Please check your pricing details");
			}
		}
		
		public function _delTempBill(){
			unset($_SESSION["_tempBill"][$_REQUEST["token"]]);
			$_SESSION["_tempBill"] = array_values($_SESSION["_tempBill"]);
		}
		
		public function _insertBillTrans(){
			$_billId = "BILL".date("YmdhisA");
			$_databaseConnection = new DatabaseConnection();
			$_databaseConnection->_getDatabaseConnection();
			global $_conn;
			try{
				$_stmt = $_conn->prepare("INSERT INTO billing (description, sq_ft, size, type, cc_id, qty, amount_per_sqft, amount, bill_id) VALUES (:description, :sq_ft, :size, :type, :cc_id, :qty, :amount_per_sqft, :amount, :bill_id)");
				$_stmt->bindParam(":description", $_description);
				$_stmt->bindParam(":sq_ft", $_sqFt);
				$_stmt->bindParam(":size", $_size);
				$_stmt->bindParam(":type", $_type);
				$_stmt->bindParam(":cc_id", $_ccId);
				$_stmt->bindParam(":qty", $_qty);
				$_stmt->bindParam(":amount_per_sqft", $_amountPerSqFt);
				$_stmt->bindParam(":amount", $_amount);
				$_stmt->bindParam(":bill_id", $_billId);
				
				$_totalAmount = 0;
				
				foreach($_SESSION["_tempBill"] as $k => $v){
					$_description = $v[0];
					$_sqFt = $v[1];
					$_size = $v[2];
					$_type = $v[3];
					$_ccId = $v[4];
					$_qty = $v[5];
					$_amountPerSqFt = $v[6];
					$_amount = $v[7];
					$_stmt->execute();
					
					$_totalAmount += $v[7];
				}
				
				$_stmt = $_conn->prepare("INSERT INTO billing_transactions (bill_id, bill_date, client_id, cap, concil_handle, tax, tax_amount, total_amount, labour, net_amount) VALUES (:bill_id, :bill_date, :client_id, :cap, :concil_handle, :tax, :tax_amount, :total_amount, :labour, :net_amount)");
				$_stmt->bindParam(":bill_id", $_billId);
				$_stmt->bindParam(":bill_date", $_billDate);
				$_stmt->bindParam(":client_id", $_clientId);
				$_stmt->bindParam(":cap", $_cap);
				$_stmt->bindParam(":concil_handle", $_concilHandle);
				$_stmt->bindParam(":tax", $_tax);
				$_stmt->bindParam(":tax_amount", $_taxAmount);
				$_stmt->bindParam(":total_amount", $_totalAmount);
				$_stmt->bindParam(":labour", $_labour);
				$_stmt->bindParam(":net_amount", $_netAmount);
				
				$_billDate = date("Y-m-d");
				$_clientId = $_REQUEST["clientid"];
				$_cap = $_REQUEST["cap"];
				$_concilHandle = $_REQUEST["conhand"];
				$_totalAmount += ($_cap + $_concilHandle);
				$_tax = 28;
				$_taxAmount = ($_tax / 100) * $_totalAmount;
				$_labour = $_REQUEST["labour"];
				$_netAmount = $_taxAmount + $_totalAmount + $_labour;
				$_stmt->execute();
				
				
				$_SESSION["_tempBill"] = null;
			}
			catch(PDOException $_e){
				echo "Error! ".$_e->getMessage();
			}
		}
	}
?>