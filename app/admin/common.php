<?php
	class DatabaseConnection{
		public function _getDatabaseConnection(){
			$_serverSpec = "mysql:host=localhost;dbname=cap";
			$_username = "root";
			$_password = "";
			global $_conn;
			try{
				$_conn = new PDO($_serverSpec, $_username, $_password);
				$_conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			}
			catch(PDOExcetion $_e){
				echo "Error! ".$_e->getMessage();
			}
		}
	}
?>