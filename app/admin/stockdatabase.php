<?php
	require_once("common.php");
	
	class StockDatabase{
		public function _getLessStockObject(){
			$_databaseConnection = new DatabaseConnection();
			$_databaseConnection->_getDatabaseConnection();
			global $_conn;
			try{
				$_stmt = $_conn->prepare("SELECT * FROM colour_code WHERE cc_stock < 3 ORDER BY cc_type, cc_name");
				$_stmt->execute();
				$_stmt->setFetchMode(PDO::FETCH_ASSOC);
				$_result = $_stmt->fetchAll();
				
				$_adminModel = new AdminModel();
				$_adminModel->_setLessStock($_result);
				
				return $_adminModel;
			}
			catch(PDOException $_e){
				echo "Error! ".$_e->getMessage();
			}
		}
		
		public function _getAllStockObject(){
			$_databaseConnection = new DatabaseConnection();
			$_databaseConnection->_getDatabaseConnection();
			global $_conn;
			try{
				$_stmt = $_conn->prepare("SELECT * FROM colour_code ORDER BY cc_type, cc_name");
				$_stmt->execute();
				$_stmt->setFetchMode(PDO::FETCH_ASSOC);
				$_result = $_stmt->fetchAll();
				
				$_adminModel = new AdminModel();
				$_adminModel->_setAllStock($_result);
				
				return $_adminModel;
			}
			catch(PDOException $_e){
				echo "Error! ".$_e->getMessage();
			}
		}
	}
?>