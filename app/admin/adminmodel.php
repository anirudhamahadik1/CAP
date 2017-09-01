<?php
	class AdminModel{
		private $_size;
		private $_type;
		private $_colourCodes;
		private $_pricing;
		private $_clientId;
		private $_lessStock;
		private $_allStock;
		private $_stmt;
		private $_bill;
		private $_suppId;
		private $_purTrans;
		
		public function _setSize($_size){
			$this->_size = $_size;
		}
		
		public function _getSize(){
			return $this->_size;
		}
		
		public function _setType($_type){
			$this->_type = $_type;
		}
		
		public function _getType(){
			return $this->_type;
		}
		
		public function _setColourCodes($_colourCodes){
			$this->_colourCodes = $_colourCodes;
		}
		
		public function _getColourCodes(){
			return $this->_colourCodes;
		}
		
		public function _setPricing($_pricing){
			$this->_pricing = $_pricing;
		}
		
		public function _getPricing(){
			return $this->_pricing;
		}
		
		public function _setClientId($_clientId){
			$this->_clientId = $_clientId;
		}
		
		public function _getClientId(){
			return $this->_clientId;
		}
		/*
		public function _setLessStock($_lessStock){
			$this->_lessStock = $_lessStock;
		}
		
		public function _getLessStock(){
			return $this->_lessStock;
		}
		
		public function _setAllStock($_allStock){
			$this->_allStock = $_allStock;
		}
		
		public function _getAllStock(){
			return $this->_allStock;
		}
		*/
		public function _setStmtTrans($_stmt){
			$this->_stmt = $_stmt;
		}
		
		public function _getStmtTrans(){
			return $this->_stmt;
		}
		
		public function _setBillTrans($_bill){
			$this->_bill = $_bill;
		}
		
		public function _getBillTrans(){
			return $this->_bill;
		}
		
		public function _setSuppId($_suppId){
			$this->_suppId = $_suppId;
		}
		
		public function _getSuppId(){
			return $this->_suppId;
		}
		
		public function _setPurTrans($_purTrans){
			$this->_purTrans = $_purTrans;
		}
		
		public function _getPurTrans(){
			return $this->_purTrans;
		}
	}
?>