<?php
	class PricingDatabase{
		public function _getPricingObject(){
			$_databaseConnection = new DatabaseConnection();
			$_databaseConnection->_getDatabaseConnection();
			global $_conn;
			try{
				$_stmt = $_conn->prepare("SELECT * FROM pricing");
				$_stmt->execute();
				$_stmt->setFetchMode(PDO::FETCH_ASSOC);
				$_result = $_stmt->fetchAll();
				
				$_adminModel = new AdminModel();
				$_adminModel->_setPricing($_result);
				
				return $_adminModel;
			}
			catch(PDOException $_e){
				echo "Error! ".$_e->getMessage();
			}
		}
		
		public function _insertPricing(){
			$_databaseConnection = new DatabaseConnection();
			$_databaseConnection->_getDatabaseConnection();
			global $_conn;
			try{
				$_stmt = $_conn->prepare("INSERT INTO pricing (size, type, price) VALUES (:size, :type, :price)");
				$_stmt->bindParam(":size", $_size);
				$_stmt->bindParam(":type", $_type);
				$_stmt->bindParam(":price", $_price);
				
				$_size = $_REQUEST["size"];
				$_type = $_REQUEST["type"];
				$_price = $_REQUEST["price"];
				$_stmt->execute();
			}
			catch(PDOException $_e){
				echo "Error! ".$_e->getMessage();
			}
		}
		
		public function _deletePricing(){
			$_databaseConnection = new DatabaseConnection();
			$_databaseConnection->_getDatabaseConnection();
			global $_conn;
			try{
				$_stmt = $_conn->prepare("DELETE FROM pricing WHERE size = :size AND type = :type AND price = :price");
				$_stmt->bindParam(":size", $_size);
				$_stmt->bindParam(":type", $_type);
				$_stmt->bindParam(":price", $_price);
				
				$_size = $_REQUEST["size"];
				$_type = $_REQUEST["type"];
				$_price = $_REQUEST["price"];
				$_stmt->execute();
			}
			catch(PDOException $_e){
				echo "Error! ".$_e->getMessage();
			}
		}
	}
?>