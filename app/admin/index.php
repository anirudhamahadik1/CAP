<?php
	class AdminRoot{
		public function _main(){
			$_adminModel = new AdminModel();
			$_adminView = new AdminView();
			$_adminController = new AdminController($_adminModel, $_adminView);
			
			if(isset($_REQUEST["submit"])){
				$_adminController->_getSubmitEvent();
			}
			
			if(isset($_REQUEST["nav"])){
				$_adminController->_getNavPage();
			}
			else{
				$_adminController->_loadAdminGUI();
			}
		}
	}
	
	session_start();
	if(isset($_SESSION["_usertype"]) && $_SESSION["_usertype"] == "admin"){
		require_once("adminmodel.php");
		require_once("adminview.php");
		require_once("admincontroller.php");
		
		$_adminRoot = new AdminRoot();
		$_adminRoot->_main();
	}
	else{
		header("location:../?alert=Warning! Unauthorised Access.");
	}
?>