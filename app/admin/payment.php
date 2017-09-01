<?php
	class Payment{
		private $_suppId;
		private $_clientId;
		
		public function __construct($_suppId, $_clientId){
			$this->_suppId = $_suppId;
			$this->_clientId = $_clientId;
		}
		
		public function _getPage(){
?>
					<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
						<div class="form-group">
							<label>Payment Amount:</label>
							<input type="number" step=".01" name="amountpaid" placeholder="Amount" class="form-control" style="max-width:50%" required>
						</div>
						<div class="form-group">
							<label>Supplier:</label>
							<input list="supp-id" name="suppid" placeholder="Supplier" class="form-control" autocomplete="off" style="max-width:50%" required>
							<datalist id="supp-id">
<?php
			foreach($this->_suppId as $_k => $_v){
?>
								<option value="<?php echo $_v["supp_id"]; ?>"><?php echo $_v["supp_id"]; ?></option>
<?php
			}
?>
							</datalist>
						</div>
						<button type="submit" class="btn btn-primary" name="submit" value="subpayment">Submit Payment</button>
					</form>
<?php
		}
	}
?>