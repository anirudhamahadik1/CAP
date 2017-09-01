<?php
	define("DS", DIRECTORY_SEPARATOR);
	
	session_start();
	if(isset($_SESSION["_usertype"]) && $_SESSION["_usertype"] == "client"){
		require_once("greetings.php");
		require_once("statements.php");
		require_once("statementhistory.php");
		require_once("..".DS."common.php");
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="keywords" content="">
		<meta name="description" content="">
		<meta name="author" content="Anirudha Anil Mahadik">
		<title>Dashboard > Client</title>
		<link rel="shortcut icon" href="../../images/favicon.jpg" type="image/x-icon" />
		
		<!-- CSS -->
		<link href="../../bootstrap/css/bootstrap.min.css" rel="stylesheet">
		<link href="../../css/dashboard.css" rel="stylesheet">
		<link href="../../css/scroll.css" rel="stylesheet">
		
		<!-- Javascript -->
		<script src="../../bootstrap/js/jquery.min.js"></script>
		<script src="../../bootstrap/js/bootstrap.min.js"></script>
	</head>
	<body>
		<div class="container-fluid">
			<div class="row">
<?php
		if(isset($_REQUEST["nav"])){
			if($_REQUEST["nav"] == "newstmt"){
?>
				<div class="col-md-3 dash-sidebar">
					<h1>Dashboard</h1>
					<ul class="nav">
						<li><a href="?nav=home">Home</a></li>
						<li class="active"><a href="?nav=newstmt&new=true">New Statement</a></li>
						<li><a href="?nav=stmthis">Statement History</a></li>
						<li><a href="?nav=signout">Sign Out</a></li>
					</ul>
				</div>
				<div class="col-md-9 dash-content">
<?php
				if(isset($_REQUEST["new"])){
					$_SESSION["_tempstmt"] = null;
				}
				_statementForm();
?>
				</div>
<?php
			}
			else if($_REQUEST["nav"] == "stmthis"){
?>
				<div class="col-md-3 dash-sidebar">
					<h1>Dashboard</h1>
					<ul class="nav">
						<li><a href="?nav=home">Home</a></li>
						<li><a href="?nav=newstmt&new=true">New Statement</a></li>
						<li class="active"><a href="?nav=stmthis">Statement History</a></li>
						<li><a href="?nav=signout">Sign Out</a></li>
					</ul>
				</div>
				<div class="col-md-9 dash-content">
					<?php _statementHistoryForm(); ?>
				</div>
<?php
			}
			else if($_REQUEST["nav"] == "billing"){
?>
				<div class="col-md-3 dash-sidebar">
					<h1>Dashboard</h1>
					<ul class="nav">
						<li><a href="?nav=home">Home</a></li>
						<li><a href="?nav=newstmt&new=true">New Statement</a></li>
						<li><a href="?nav=stmthis">Statement History</a></li>
						<li class="active"><a href="?nav=billing">Billing History</a></li>
						<li><a href="?nav=signout">Sign Out</a></li>
					</ul>
				</div>
				<div class="col-md-9 dash-content">
				
				</div>
<?php
			}
			else if($_REQUEST["nav"] == "signout"){
				session_unset();
				session_destroy();
				header("location:..");
			}
			else{
?>
				<div class="col-md-3 dash-sidebar">
					<h1>Dashboard</h1>
					<ul class="nav">
						<li class="active"><a href="?nav=home">Home</a></li>
						<li><a href="?nav=newstmt&new=true">New Statement</a></li>
						<li><a href="?nav=stmthis">Statement History</a></li>
						<li><a href="?nav=signout">Sign Out</a></li>
					</ul>
				</div>
				<div class="col-md-9 dash-content">
<?php
				_displayGreetings();
?>
				</div>
<?php
			}
		}
		else{
?>
				<div class="col-md-3 dash-sidebar">
					<h1>Dashboard</h1>
					<ul class="nav">
						<li class="active"><a href="?nav=home">Home</a></li>
						<li><a href="?nav=newstmt&new=true">New Statement</a></li>
						<li><a href="?nav=stmthis">Statement History</a></li>
						<li><a href="?nav=signout">Sign Out</a></li>
					</ul>
				</div>
				<div class="col-md-9 dash-content">
<?php
			_displayGreetings()
?>
				</div>
<?php
		}
?>	
			</div>
		</div>
	</body>
</html>
<?php
	}
	else{
		header("location:../?alert=Warning! Unauthorised Access.");
	}
	
	if(isset($_REQUEST["submit"])){
		if($_REQUEST["submit"] == "add"){
			_addTempStmt();
		}
		else if($_REQUEST["submit"] == "deltempstmt"){
			_delTempStmt();
		}
		else if($_REQUEST["submit"] == "submitstmt"){
			_insertStatements();
		}
	}
?>