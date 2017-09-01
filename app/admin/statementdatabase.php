<?php
	class StatementDatabase{
		public function _setTempStmt($_pricing){
			if(isset($_pricing)){
				$_width = $_REQUEST["width"] / 304.8;
				$_height = $_REQUEST["height"] / 304.8;
				$_sqft = number_format(($_width * $_height), 2, "." , ",");
				$_qty = $_REQUEST["qty"];
				$_amount = ($_sqft * $_pricing) * $_qty;
				$temparr = array($_REQUEST["width"], $_REQUEST["height"], $_REQUEST["size"], $_REQUEST["type"], $_REQUEST["colour"], $_qty, $_sqft, $_pricing, $_amount);
				$_SESSION["_tempStmt"][] = $temparr;
				header("location:?nav=stmt");
			}
			else{
				header("location:?nav=stmt&msg=Please check your pricing details");
			}
		}
		
		public function _delTempStmt(){
			unset($_SESSION["_tempStmt"][$_REQUEST["token"]]);
			$_SESSION["_tempStmt"] = array_values($_SESSION["_tempStmt"]);
		}
		
		public function _insertStmtTrans(){
			$_stmtId = "STMT".date("YmdhisA");
			$_databaseConnection = new DatabaseConnection();
			$_databaseConnection->_getDatabaseConnection();
			global $_conn;
			try{
				$_stmt = $_conn->prepare("INSERT INTO statements (length, breadth, size, type, cc_id, qty, sq_ft, amount_per_sqft, amount, stmt_id) VALUES (:length, :breadth, :size, :type, :cc_id, :qty, :sq_ft, :amount_per_sqft, :amount, :stmt_id)");
				$_stmt->bindParam(":length", $_length);
				$_stmt->bindParam(":breadth", $_breadth);
				$_stmt->bindParam(":size", $_size);
				$_stmt->bindParam(":type", $_type);
				$_stmt->bindParam(":cc_id", $_ccId);
				$_stmt->bindParam(":qty", $_qty);
				$_stmt->bindParam(":sq_ft", $_sqFt);
				$_stmt->bindParam(":amount_per_sqft", $_amountPerSqFt);
				$_stmt->bindParam(":amount", $_amount);
				$_stmt->bindParam(":stmt_id", $_stmtId);
				
				$_totalAmount = 0;
				
				foreach($_SESSION["_tempStmt"] as $k => $v){
					$_length = $v[0];
					$_breadth = $v[1];
					$_size = $v[2];
					$_type = $v[3];
					$_ccId = $v[4];
					$_qty = $v[5];
					$_sqFt = $v[6];
					$_amountPerSqFt = $v[7];
					$_amount = $v[8];
					$_stmt->execute();
					
					$_totalAmount += $v[8];
				}
				
				$_stmt = $_conn->prepare("INSERT INTO statement_transactions (stmt_id, stmt_date, client_id, cap, concil_handle, tax, tax_amount, total_amount, labour, net_amount, status) VALUES (:stmt_id, :stmt_date, :client_id, :cap, :concil_handle, :tax, :tax_amount, :total_amount, :labour, :net_amount, :status)");
				$_stmt->bindParam(":stmt_id", $_stmtId);
				$_stmt->bindParam(":stmt_date", $_stmtDate);
				$_stmt->bindParam(":client_id", $_clientId);
				$_stmt->bindParam(":cap", $_cap);
				$_stmt->bindParam(":concil_handle", $_concilHandle);
				$_stmt->bindParam(":tax", $_tax);
				$_stmt->bindParam(":tax_amount", $_taxAmount);
				$_stmt->bindParam(":total_amount", $_totalAmount);
				$_stmt->bindParam(":labour", $_labour);
				$_stmt->bindParam(":net_amount", $_netAmount);
				$_stmt->bindParam(":status", $_status);
				
				$_stmtDate = date("Y-m-d");
				$_clientId = $_REQUEST["clientid"];
				$_cap = $_REQUEST["cap"];
				$_concilHandle = $_REQUEST["conhand"];
				$_totalAmount += ($_cap + $_concilHandle);
				$_tax = 28;
				$_taxAmount = ($_tax / 100) * $_totalAmount;
				$_labour = $_REQUEST["labour"];
				$_netAmount = $_taxAmount + $_totalAmount + $_labour;
				$_status = "Placed";
				$_stmt->execute();
				
				
				$_SESSION["_tempStmt"] = null;
			}
			catch(PDOException $_e){
				echo "Error! ".$_e->getMessage();
			}
		}
	}
?>