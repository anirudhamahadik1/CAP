<?php
	class CommonClass{
		public function _getSizeObject(){
			$_databaseConnection = new DatabaseConnection();
			$_databaseConnection->_getDatabaseConnection();
			global $_conn;
			try{
				$_stmt = $_conn->prepare("SELECT DISTINCT size FROM pricing");
				$_stmt->execute();
				$_stmt->setFetchMode(PDO::FETCH_ASSOC);
				$_result = $_stmt->fetchAll();
				
				$_adminModel = new AdminModel();
				$_adminModel->_setSize($_result);
				
				return $_adminModel;
			}
			catch(PDOException $_e){
				echo "Error! ".$_e->getMessage();
			}
		}
		
		public function _getTypeObject(){
			$_databaseConnection = new DatabaseConnection();
			$_databaseConnection->_getDatabaseConnection();
			global $_conn;
			try{
				$_stmt = $_conn->prepare("SELECT DISTINCT type FROM pricing");
				$_stmt->execute();
				$_stmt->setFetchMode(PDO::FETCH_ASSOC);
				$_result = $_stmt->fetchAll();
				
				$_adminModel = new AdminModel();
				$_adminModel->_setType($_result);
				
				return $_adminModel;
			}
			catch(PDOException $_e){
				echo "Error! ".$_e->getMessage();
			}
		}
		
		public function _getColourCodesObject(){
			$_databaseConnection = new DatabaseConnection();
			$_databaseConnection->_getDatabaseConnection();
			global $_conn;
			try{
				$_stmt = $_conn->prepare("SELECT * FROM colour_code");
				$_stmt->execute();
				$_stmt->setFetchMode(PDO::FETCH_ASSOC);
				$_result = $_stmt->fetchAll();
				$_adminModel = new AdminModel();
				$_adminModel->_setColourCodes($_result);
				
				return $_adminModel;
			}
			catch(PDOException $_e){
				echo "Error! ".$_e->getMessage();
			}
		}
		
		public function _getPricing(){
			$_databaseConnection = new DatabaseConnection();
			$_databaseConnection->_getDatabaseConnection();
			global $_conn;
			try{
				$_stmt = $_conn->prepare("SELECT * FROM pricing WHERE size = :size AND type = :type");
				$_stmt->bindParam(":size", $_size);
				$_stmt->bindParam(":type", $_type);
				$_size = $_REQUEST["size"];
				$_type = $_REQUEST["type"];
				$_stmt->execute();
				$_stmt->setFetchMode(PDO::FETCH_ASSOC);
				$_result = $_stmt->fetchAll();
				
				$_adminModel = new AdminModel();
				$_adminModel->_setPricing($_result[0]["price"]);
				
				return $_adminModel;
				
			}
			catch(PDOException $_e){
				echo "Error! ".$_e->getMessage();
			}
		}
		
		public function _getClientIdObject(){
			$_databaseConnection = new DatabaseConnection();
			$_databaseConnection->_getDatabaseConnection();
			global $_conn;
			try{
				$_stmt = $_conn->prepare("SELECT DISTINCT client_id FROM statement_transactions");
				$_stmt->execute();
				$_stmt->setFetchMode(PDO::FETCH_ASSOC);
				$_result = $_stmt->fetchAll();
				$_adminModel = new AdminModel();
				$_adminModel->_setClientId($_result);
				
				return $_adminModel;
			}
			catch(PDOException $_e){
				echo "Error! ".$_e->getMessage();
			}
		}
		
		public function _getCustIdObject(){
			$_databaseConnection = new DatabaseConnection();
			$_databaseConnection->_getDatabaseConnection();
			global $_conn;
			try{
				$_stmt = $_conn->prepare("SELECT DISTINCT client_id FROM billing_transactions");
				$_stmt->execute();
				$_stmt->setFetchMode(PDO::FETCH_ASSOC);
				$_result = $_stmt->fetchAll();
				$_adminModel = new AdminModel();
				$_adminModel->_setClientId($_result);
				
				return $_adminModel;
			}
			catch(PDOException $_e){
				echo "Error! ".$_e->getMessage();
			}
		}
		
		public function _getSuppIdObject(){
			$_databaseConnection = new DatabaseConnection();
			$_databaseConnection->_getDatabaseConnection();
			global $_conn;
			try{
				$_stmt = $_conn->prepare("SELECT DISTINCT supp_id FROM purchase_transactions");
				$_stmt->execute();
				$_stmt->setFetchMode(PDO::FETCH_ASSOC);
				$_result = $_stmt->fetchAll();
				$_adminModel = new AdminModel();
				$_adminModel->_setSuppId($_result);
				
				return $_adminModel;
			}
			catch(PDOException $_e){
				echo "Error! ".$_e->getMessage();
			}
		}
		
		public function _insertJournal($_transType, $_description, $_amount){
			$_databaseConnection = new DatabaseConnection();
			$_databaseConnection->_getDatabaseConnection();
			global $_conn;
			try{
				$_stmt = $_conn->prepare("INSERT INTO journal (trans_id, trans_date, trans_type, description, supp_id, amount) VALUES (:trans_id, :trans_date, :trans_type, :description, :supp_id, :amount)");
				$_stmt->bindParam(":trans_id", $_transId);
				$_stmt->bindParam(":trans_date", $_transDate);
				$_stmt->bindParam(":trans_type", $_transType);
				$_stmt->bindParam(":description", $_description);
				$_stmt->bindParam(":supp_id", $_suppId);
				$_stmt->bindParam(":amount", $_amount);
				
				$_transId = "PJ".date("YmdhisA");
				$_transDate = date("Y-m-d");
				$_suppId = $_REQUEST["suppid"];
				$_stmt->execute();
			}
			catch(PDOException $_e){
				echo "Error! ".$_e->getMessage();
			}
		}
	}
?>