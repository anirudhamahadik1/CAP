<?php
	class Purchase{
		private $_suppId;
		
		public function __construct($_suppId){
			$this->_suppId = $_suppId;
		}
		
		public function _getPage(){
?>
					<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
						<div class="row">
							<div class="col-md-3">
								<label>Decription:</label>
								<input type="text" name="desc" placeholder="Description" class="form-control" required>
							</div>
							<div class="col-md-3">
								<label>Quantity:</label>
								<input type="number" name="qty" placeholder="Quantity" class="form-control" required>
							</div>
							<div class="col-md-3">
								<label>Amount:</label>
								<input type="number" step=".01" name="amount" placeholder="Amount" class="form-control" required>
							</div>
							<div class="col-md-3" style="padding-top:24px;">
								<button type="submit" class="btn btn-primary" name="submit" value="addtemppur">Add</button>
							</div>
						</div>
					</form>
					<br>
					<div class="scroll-div">
						<table class="table table-condensed table-striped">
							<tr>
								<th>Description</th>
								<th>Quantity</th>
								<th>Amount</th>
								<th>Action</th>
							</tr>
<?php
			$_totalAmount = 0;
			if(isset($_SESSION["_tempPur"])){
				foreach($_SESSION["_tempPur"] as $_k => $_v){
					$_totalAmount += $_v[2];
?>
							<tr>
								<td><?php echo $_v[0]; ?></td>
								<td><?php echo $_v[1]; ?></td>
								<td><?php echo $_v[2]."/-"; ?></td>
								<td><a href="?submit=deltemppur&token=<?php echo $_k; ?>">Delete</a></td>
							</tr>
<?php
				}
			}
?>
						</table>
						<label>Net Amount:</label> <?php echo $_totalAmount."/-"; ?>
					</div>
					<br>
					<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
						<div class="row">
							<div class="col-md-3">
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
							<div class="col-md-3">
								<label>Payment Type:</label>
								<select name="paytype" class="form-control">
									<option value="credit">Credit</option>
									<option value="cheque">Cheque</option>
								</select>
							</div>
							<div class="col-md-3">
								<label>Amount:</label>
								<input type="number" step=".01" name="amountpaid" placeholder="Amount" class="form-control">
							</div>
							<div class="col-md-3" style="padding-top:24px;">
								<button type="submit" class="btn btn-primary" name="submit" value="subpurtrans">Submit Purchase Transaction</button>
							</div>
						</div>
					</form>
<?php
		}
	}
?>