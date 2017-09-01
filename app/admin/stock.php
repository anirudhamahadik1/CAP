<?php
	class Stock{
		private $_action;
		private $_lessStock;
		private $_allStock;
		
		public function __construct($_action, $_lessStock, $_allStock){
			$this->_action = $_action;
			$this->_lessStock = $_lessStock;
			$this->_allStock = $_allStock;
		}
		public function _getPage(){
?>
					<a href="?nav=stock&action=new">New</a> |
					<a href="?nav=stock&action=add">Add</a> |
					<a href="?nav=stock&action=less">Less</a>
					<hr>
					
<?php
			$this->_getContent();
		}
		
		public function _getContent(){
			switch($this->_action){
				case "new":
					$this->_getNew();
				break;
				case "add":
					echo $this->_action;
				break;
				case "less":
					echo $this->_action;
				break;
				default:
					$this->_getDefault();
				break;
			}
		}
		
		public function _getDefault(){
			if(!empty($this->_lessStock)){
?>
				<h2>
					Stock:
					<small>Low</small>
				</h2>
				<div class="scroll-div">
					<table class="table table-condensed table-striped">
						<tr>
							<th>Colour Code</th>
							<th>Colour Name</th>
							<th>Type</th>
							<th>Quantity</th>
						</tr>
<?php
				foreach($this->_lessStock as $k => $v){
?>
						<tr>
							<td><?php echo $v["cc_id"]; ?></td>
							<td><?php echo $v["cc_name"]; ?></td>
							<td><?php echo $v["cc_type"]; ?></td>
							<td><?php echo $v["cc_stock"]; ?></td>
						</tr>
<?php
				}
?>
					</table>
				</div>
<?php
			}
?>
				<h2>
					Stock:
					<small>All</small>
				</h2>
				<div class="scroll-div">
					<table class="table table-condensed table-striped">
						<tr>
							<th>Colour Code</th>
							<th>Colour Name</th>
							<th>Type</th>
							<th>Quantity</th>
						</tr>
<?php
				foreach($this->_allStock as $k => $v){
?>
						<tr>
							<td><?php echo $v["cc_id"]; ?></td>
							<td><?php echo $v["cc_name"]; ?></td>
							<td><?php echo $v["cc_type"]; ?></td>
							<td><?php echo $v["cc_stock"]; ?></td>
						</tr>
<?php
				}
?>
					</table>
				</div>
<?php
		}
		
		public function _getNew(){
?>
					<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
						<div class="form-group">
							<label>Colour Code:</label>
							<input type="text" name="ccid" placeholder="Colour Code" class="form-control" required>
						</div>
						<div class="form-group">
							<label>Colour Name</label>
							<input type="text" name="ccname" placeholder="Colour Name" class="form-control" required>
						</div>
						<div class="form-group">
							<label>Colour Type:</label>
							<select name="cctype" class="form-control">
								<option value="matt">Matt</option>
								<option value="gloss">Gloss</option>
							</select>
						</div>
						<div class="form-group">
							<label>Quantity</label>
							<input type="text" name="ccqty" placeholder="Quantity" class="form-control" required>
						</div>
						<div class="form-group">
							<button type="submit" class="btn btn-primary" name="submit" value="addnewstock">Add New Stock</button>
						</div>
					</form>
<?php
		}
	}
?>