<?php
	class Greetings{
		public function _getPage(){
?>
					<div class="row" style="margin-bottom:30px;">
						<div class="col-md-12">
							<h1>Welcome! <?php echo $_SESSION["_userid"]; ?></h1>
						</div>
					</div>
					<div class="row">
						<div class="col-md-2 text-right">
							<label>Software Type: </label>
						</div>
						<div class="col-md-10">
							Accounting/Billing.
						</div>
					</div>
					<div class="row">
						<div class="col-md-2 text-right">
							<label>Software Version: </label>
						</div>
						<div class="col-md-10">
							V1.0.0
						</div>
					</div>
					<div class="row">
						<div class="col-md-2 text-right">
							<label>Software Support: </label>
						</div>
						<div class="col-md-10">
							(+91) 8793 298 455
						</div>
					</div>
					<div class="row">
						<div class="col-md-2 text-right">
							<label>Copyrights: </label>
						</div>
						<div class="col-md-10">
							&copy; <?php echo date("Y"); ?> Anirudha Anil Mahadik.
						</div>
					</div>
					<div class="row">
						<div class="col-md-2 text-right">
							<label>Features: </label>
						</div>
						<div class="col-md-10">
							<ul style="padding-left:10px;">
								<li>Purchase Entry.</li>
								<li>Purchase Payment.</li>
								<li>Statement Generation.</li>
								<li>Billing Generation.</li>
								<li>Pricing Management.</li>
								<li>Reports: Purchase, Purchase Ledger,<br> Sale Ledger, Statements, Billing, Tax, etc.</li>
							</ul>
						</div>
					</div>
<?php
		}
	}
?>