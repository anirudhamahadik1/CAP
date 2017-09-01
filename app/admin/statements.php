<?php
	class Statements{
		private $_size;
		private $_type;
		private $_colourCodes;
		private $_clientId;
		
		public function __construct($_size, $_type, $_colourCodes, $_clientId){
			$this->_size = $_size;
			$this->_type = $_type;
			$this->_colourCodes = $_colourCodes;
			$this->_clientId = $_clientId;
		}
		
		public function _getPage(){
?>
					<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
						<div class="row">
							<div class="col-md-2">
								<label>Length:</label>
								<input type="number" step=".01" name="width" placeholder="mm." class="form-control" required>
							</div>
							<div class="col-md-2">
								<label>Breadth:</label>
								<input type="number" step=".01" name="height" placeholder="mm." class="form-control" required>
							</div>
							<div class="col-md-2">
								<label>Size:</label>
								<input list="size" name="size" placeholder="mm." class="form-control" autocomplete="off" required>
								<datalist id="size">
<?php
			foreach($this->_size as $_k => $_v){
?>
									<option value="<?php echo $_v["size"]; ?>"><?php echo $_v["size"]; ?></option>
<?php
			}
?>
								</datalist>
							</div>
							<div class="col-md-2">
								<label>Type:</label>
								<input list="type" name="type" placeholder="Type" class="form-control" autocomplete="off" required>
								<datalist id="type">
<?php
			foreach($this->_type as $_k => $_v){
?>
									<option value="<?php echo $_v["type"]; ?>"><?php echo $_v["type"]; ?></option>
<?php
			}
?>
								</datalist>
							</div>
							<div class="col-md-2">
								<label>Colour:</label>
								<input list="colour-code" name="colour" placeholder="Colour Code" class="form-control" autocomplete="off" required>
								<datalist id="colour-code">
<?php
			foreach($this->_colourCodes as $_k => $_v){
?>
									<option value="<?php echo $_v["cc_id"]; ?>"><?php echo $_v["cc_name"]; ?></option>
<?php
			}
?>
								</datalist>
							</div>
							<div class="col-md-2">
								<label>Quantity:</label>
								<input type="number" name="qty" placeholder="Quantity" class="form-control" required>
								<button type="submit" class="btn btn-primary" name="submit" value="addtempstmt" style="display:none;">Add</button>
							</div>
						</div>
					</form>
					<br>
					<div class="scroll-div">
						<table class="table table-condensed table-striped">
							<tr>
								<th>Length</th>
								<th>Breadth</th>
								<th>Size</th>
								<th>Type</th>
								<th>Colour Code</th>
								<th>Quantity</th>
								<th>Sq. Ft.</th>
								<th>Amount/Sq. Ft.</th>
								<th>Amount</th>
								<th>Action</th>
							</tr>
<?php
			$_totalAmount = 0;
			$_tax = 28;
			if(isset($_SESSION["_tempStmt"])){
				foreach($_SESSION["_tempStmt"] as $_k => $_v){
					$_totalAmount += $_v[8];
?>
							<tr>
								<td><?php echo $_v[0]; ?></td>
								<td><?php echo $_v[1]; ?></td>
								<td><?php echo $_v[2]; ?></td>
								<td><?php echo $_v[3]; ?></td>
								<td><?php echo $_v[4]; ?></td>
								<td><?php echo $_v[5]; ?></td>
								<td><?php echo $_v[6]; ?></td>
								<td><?php echo $_v[7]; ?></td>
								<td><?php echo $_v[8]; ?></td>
								<td><a href="?submit=deltempstmt&token=<?php echo $_k; ?>">Delete</a></td>
							</tr>
<?php
				}
			}
			$_taxAmount = ($_tax / 100) * $_totalAmount;
?>
						</table>
					</div>
					<span id="totalamount" style="display:none"><?php echo $_totalAmount; ?></span>
					<span id="taxamount" style="display:none"><?php echo $_taxAmount; ?></span>
					<span id="netamount" style="display:none"><?php echo ($_totalAmount + $_taxAmount); ?></span>
					<br>
					<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
						<div class="row">
							<div class="col-md-2">
								<label>Cap:</label>
								<input type="number" step=".01" name="cap" placeholder="Cap" class="form-control" onkeyup="updateFormData(this.value)" id="cap" required>
							</div>
							<div class="col-md-2">
								<label>Concil Handle:</label>
								<input type="number" step=".01" name="conhand" placeholder="Concil Handle" class="form-control" onkeyup="updateFormData(this.value)" id="conhand" required>
							</div>
							<div class="col-md-2">
								<label>Total Amount:</label><br>
								<span id="distotalamount"><?php echo $_totalAmount; ?></span>
							</div>
							<div class="col-md-2">
								<label>Tax (<?php echo $_tax."%"; ?>):</label><br>
								<span id="distaxamount"><?php echo $_taxAmount; ?></span>
							</div>
							<div class="col-md-2">
								<label>Labour:</label>
								<input type="number" step=".01" name="labour" placeholder="Labour" class="form-control" onkeyup="updateFormData(this.value)" id="labour" required>
							</div>
							<div class="col-md-2">
								<label>Net Amount:</label><br>
								<span id="disnetamount"><?php echo ($_totalAmount + $_taxAmount); ?></span>
							</div>
						</div>
						<div class="row" style="padding-top:10px;">
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
						</div><br>
						<button type="submit" class="btn btn-primary" name="submit" value="submitstmt">Submit Statement</button>
					</form>
					
<?php
		}
	}
?>