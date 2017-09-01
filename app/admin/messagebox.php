<?php
	class MessageBox{
		public function _showMsgDialog($_msg){
?>
		<div class="msg-div">
			<div class="text-right"><a href="#" id="msgclose"><span class="glyphicon glyphicon-remove"></span></a></div>
			<h3 class="msg-head"><span class="glyphicon glyphicon-flag"></span> Message</h3>
			<hr>
			<p><?php echo $_REQUEST["msg"]; ?></p>
		</div>
<?php
		}
	}
?>