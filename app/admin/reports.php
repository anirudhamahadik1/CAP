<?php
	class Reports{
		private $_action;
		private $_stmt;
		private $_bill;
		private $_purTrans;
		private $_suppId;
		private $_clientId;
		
		public function __construct($_action, $_stmt, $_bill, $_purTrans, $_suppId, $_clientId){
			$this->_action = $_action;
			$this->_stmt = $_stmt;
			$this->_bill = $_bill;
			$this->_purTrans = $_purTrans;
			$this->_suppId = $_suppId;
			$this->_clientId = $_clientId;
		}
		
		public function _getPage(){
			if(isset($this->_action)){
				$this->_getContent();
			}
			else{
?>
					<h2>Reports</h2>
					<ul>
						<li><a href="?nav=reports&action=purchase">Purchase</a></li>
						<li><a href="?nav=reports&action=purled">Purchase Ledger</a></li>
						<li><a href="?nav=reports&action=stmt">Statements</a></li>
						<li><a href="?nav=reports&action=billing">Billing</a></li>
						<li><a href="viewbillreg.php?month=<?php echo date("m"); ?>" target="_blank">Billing Register</a></li>
					</ul>
<?php
			}
		}
		
		public function _getContent(){
			switch($this->_action){
				case "purchase":
					$this->_getPurchase();
				break;
				case "purled":
					$this->_getPurchaseLedger();
				break;
				case "stmt":
					$this->_getStmt();
				break;
				case "billing":
					$this->_getBill();
				break;
				default:
					
				break;
			}
		}
		
		public function _getPurchase(){
?>
					<h2>Purchase</h2>
					<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
						<div class="row">
							<input type="hidden" name="nav" value="reports">
							<input type="hidden" name="action" value="purchase">
							<div class="col-md-4">
								<label>Supplier:</label>
							<input list="supp-id" name="suppid" placeholder="Supplier Id" class="form-control" autocomplete="off" required>
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
							<div class="col-md-8" style="padding-top:24px;">
								<button type="submit" class="btn btn-primary" name="submit" value="filstmt">Filter</button>
							</div>
						</div>
					</form>
					<br>
					<div class="scroll-div">
						<table class="table table-condensed table-striped">
							<tr>
								<th>#</th>
								<th>Purchase Id</th>
								<th>Date</th>
								<th>Client</th>
								<th>Amount</th>
								<th>Action</th>
							</tr>
<?php
			if(isset($_REQUEST["suppid"])){
				foreach($this->_purTrans as $_k => $_v){
					if($_v["supp_id"] == $_REQUEST["suppid"]){
?>
							<tr>
								<td><?php echo $_v["sr_no"]; ?></td>
								<td><?php echo $_v["purchase_id"]; ?></td>
								<td><?php echo $_v["purchase_date"]; ?></td>
								<td><?php echo $_v["supp_id"]; ?></td>
								<td><?php echo $_v["net_amount"]; ?></td>
								<td><a href="viewpurchase.php?purid=<?php echo $_v["purchase_id"]; ?>" target="_blank">View</a></td>
							</tr>
<?php
					}
				}
			}
			else{
				foreach($this->_purTrans as $_k => $_v){
?>
							<tr>
								<td><?php echo $_v["sr_no"]; ?></td>
								<td><?php echo $_v["purchase_id"]; ?></td>
								<td><?php echo $_v["purchase_date"]; ?></td>
								<td><?php echo $_v["supp_id"]; ?></td>
								<td><?php echo $_v["net_amount"]; ?></td>
								<td><a href="viewpurchase.php?purid=<?php echo $_v["purchase_id"]; ?>" target="_blank">View</a></td>
							</tr>
<?php
				}
			}
?>
						</table>
					</div>
<?php
		}
		
		public function _getPurchaseLedger(){
?>
					<h2>Purchase Ledger</h2>
					<form method="post" action="viewledger.php" target="_blank">
						<div class="form-group">
							<label>Month:</label>
							<select name="month" class="form-control" style="max-width:50%">
								<option value="1">January</option>
								<option value="2">February</option>
								<option value="3">March</option>
								<option value="4">April</option>
								<option value="5">May</option>
								<option value="6">June</option>
								<option value="7">July</option>
								<option value="8">August</option>
								<option value="9">September</option>
								<option value="10">October</option>
								<option value="11">November</option>
								<option value="12">December</option>
							</select>
						</div>
						<div class="form-group">
							<label>Supplier:</label>
							<input list="supp-id" name="suppid" placeholder="Supplier Id" class="form-control" autocomplete="off" style="max-width:50%" required>
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
						<button type="submit" class="btn btn-primary" name="submit" value="filpurled">Filter</button>
					</form>
<?php
		}
		
		public function _getStmt(){
?>
					<h2>Statements</h2>
					<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
						<div class="row">
							<input type="hidden" name="nav" value="reports">
							<input type="hidden" name="action" value="stmt">
							<div class="col-md-4">
								<label>Client Id:</label>
								<input list="client-id" name="clientid" placeholder="Client Id" class="form-control" autocomplete="off" required>
								<datalist id="client-id">
<?php
			foreach($this->_clientId as $_k => $_v){
?>
									<option value="<?php echo $_v["client_id"]; ?>"><?php echo $_v["client_id"]; ?></option>
<?php
			}
?>
								</datalist>
							</div>
							<div class="col-md-8" style="padding-top:24px;">
								<button type="submit" class="btn btn-primary" name="submit" value="filstmt">Filter</button>
							</div>
						</div>
					</form>
					<br>
					<div class="scroll-div">
						<table class="table table-condensed table-striped">
							<tr>
								<th>#</th>
								<th>Statement Id</th>
								<th>Date</th>
								<th>Client</th>
								<th>Net Amount</th>
								<th>Action</th>
							</tr>
<?php
			if(isset($_REQUEST["clientid"])){
				foreach($this->_stmt as $k => $v){
					if($v["client_id"] == $_REQUEST["clientid"]){
?>
							<tr>
								<td><?php echo $v["sr_no"]; ?></td>
								<td><?php echo $v["stmt_id"]; ?></td>
								<td><?php echo $v["stmt_date"]; ?></td>
								<td><?php echo $v["client_id"]; ?></td>
								<td><?php echo $v["net_amount"]."/-"; ?></td>
								<td>
									<a href="viewstatement.php?stmtid=<?php echo $v["stmt_id"]; ?>" target="_blank">View</a>
								</td>
							</tr>
<?php
					}
				}
			}
			else{
				foreach($this->_stmt as $k => $v){
?>
							<tr>
								<td><?php echo $v["sr_no"]; ?></td>
								<td><?php echo $v["stmt_id"]; ?></td>
								<td><?php echo $v["stmt_date"]; ?></td>
								<td><?php echo $v["client_id"]; ?></td>
								<td><?php echo $v["net_amount"]."/-"; ?></td>
								<td>
									<a href="viewstatement.php?stmtid=<?php echo $v["stmt_id"]; ?>" target="_blank">View</a>
								</td>
							</tr>
<?php
				}
			}
?>
						</table>
					</div>
<?php
		}
		
		public function _getBill(){
?>
					<h2>Billing</h2>
					<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
						<div class="row">
							<input type="hidden" name="nav" value="reports">
							<input type="hidden" name="action" value="billing">
							<div class="col-md-4">
								<label>Client Id:</label>
								<input list="client-id" name="clientid" placeholder="Client Id" class="form-control" autocomplete="off" required>
								<datalist id="client-id">
<?php
			foreach($this->_clientId as $_k => $_v){
?>
									<option value="<?php echo $_v["client_id"]; ?>"><?php echo $_v["client_id"]; ?></option>
<?php
			}
?>
								</datalist>
							</div>
							<div class="col-md-8" style="padding-top:24px;">
								<button type="submit" class="btn btn-primary" name="submit" value="filstmt">Filter</button>
							</div>
						</div>
					</form>
					<br>
					<div class="scroll-div">
						<table class="table table-condensed table-striped">
							<tr>
								<th>#</th>
								<th>Bill Id</th>
								<th>Date</th>
								<th>Client</th>
								<th>Net Amount</th>
								<th>Action</th>
							</tr>
<?php
			if(isset($_REQUEST["clientid"])){
				foreach($this->_bill as $k => $v){
					if($v["client_id"] == $_REQUEST["clientid"]){
?>
							<tr>
								<td><?php echo $v["sr_no"]; ?></td>
								<td><?php echo $v["bill_id"]; ?></td>
								<td><?php echo $v["bill_date"]; ?></td>
								<td><?php echo $v["client_id"]; ?></td>
								<td><?php echo $v["net_amount"]."/-"; ?></td>
								<td>
									<a href="viewbill.php?billid=<?php echo $v["bill_id"]; ?>" target="_blank">View</a>
								</td>
							</tr>
<?php
					}
				}
			}
			else{
				foreach($this->_bill as $k => $v){
?>
							<tr>
								<td><?php echo $v["sr_no"]; ?></td>
								<td><?php echo $v["bill_id"]; ?></td>
								<td><?php echo $v["bill_date"]; ?></td>
								<td><?php echo $v["client_id"]; ?></td>
								<td><?php echo $v["net_amount"]."/-"; ?></td>
								<td>
									<a href="viewbill.php?billid=<?php echo $v["bill_id"]; ?>" target="_blank">View</a>
								</td>
							</tr>
<?php
				}
			}
?>
						</table>
					</div>
<?php
		}
	}
?>