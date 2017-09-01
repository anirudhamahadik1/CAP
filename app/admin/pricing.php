<?php
	class Pricing{
		private $_pricing;
		
		public function __construct($_pricing){
			$this->_pricing = $_pricing;
		}
		
		public function _getPage(){
?>
					<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
						<div class="row">
							<div class="col-md-2">
								<label>Size:</label>
								<input type="text" name="size" placeholder="mm." class="form-control" required>
							</div>
							<div class="col-md-2">
								<label>Type:</label>
								<input type="text" name="type" placeholder="Type" class="form-control" required>
							</div>
							<div class="col-md-2">
								<label>Price/Sq. Ft.:</label>
								<input type="text" name="price" placeholder="Price/Sq. Ft." class="form-control" required>
							</div>
							<div class="col-md-2" style="padding-top:24px;">
								<button type="submit" class="btn btn-primary" name="submit" value="addpricing">Add</button>
							</div>
						</div>
					</form>
					<br>
<?php
			if(isset($this->_pricing)){
?>
					<table class="table table-condensed table-striped">
						<tr>
							<th>#</th>
							<th>Size</th>
							<th>Type</th>
							<th>Price/Sq. Ft.</th>
							<th>Action</th>
						</tr>
<?php
				foreach($this->_pricing as $k => $v){
?>
						<tr>
							<td><?php echo ($k + 1); ?></td>
							<td><?php echo $v["size"]; ?></td>
							<td><?php echo $v["type"]; ?></td>
							<td><?php echo $v["price"]; ?></td>
							<td><a href="?submit=delpricing&size=<?php echo $v["size"]; ?>&type=<?php echo $v["type"]; ?>&price=<?php echo $v["price"]; ?>">Delete</a></td>
						</tr>
<?php
				}
?>
					</table>
<?php
			}
		}
	}
?>