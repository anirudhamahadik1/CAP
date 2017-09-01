<?php
	function _displayGreetings(){
?>
			<div class="row">
				<div class="col-md-12">
					<h1>Welcome! User: <?php echo $_SESSION["_userid"]; ?></h1>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<h2>Features!</h2>
					<ul>
						<li>Easy to generate statement by using our online statement generator tool.</li>
						<li>You can view your statement and billing history.</li>
					</ul>
				</div>
				<div class="col-md-6">
					<h2>News!</h2>
					<p>Under construction.</p>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<h2>Pricing and Tax/GST</h2>
					<table class="table table-condensed table-striped">
						<tr>
							<th>Size</th>
							<th>Type</th>
							<th>Price</th>
						</tr>
						<?php _getPricingList(); ?>
					</table>
					<p><label>T &amp; C:</label> 13.5% TAX apply on every bill.</p>
				</div>
			</div>
<?php
	}
	
	function _getPricingList(){
		_databaseConnect();
		global $_conn;
		try{
			$_stmt = $_conn->prepare("SELECT * FROM pricing");
			$_stmt->execute();
			$_stmt->setFetchMode(PDO::FETCH_ASSOC);
			$_result = $_stmt->fetchAll();
			if(!empty($_result)){
				foreach($_result as $k => $v){
?>
						<tr>
							<td><?php echo $_result[$k]["size"]; ?></td>
							<td><?php echo $_result[$k]["type"]; ?></td>
							<td><?php echo $_result[$k]["price"]; ?></td>
						</tr>
<?php
				}
			}
		}
		catch(PDOException $_e){
			echo "Error! ".$_e->getMessage();
		}
	}
?>