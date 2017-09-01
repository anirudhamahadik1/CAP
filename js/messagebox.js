$(document).ready(function(){
	setTimeout(closeMsg, 5000);
	
	function closeMsg(){
		$(".msg-div").fadeOut();
	}
	
	$("#msgclose").click(function(){
		$(".msg-div").fadeOut();
	});
});