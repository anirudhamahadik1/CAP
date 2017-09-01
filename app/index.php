<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="keywords" content="">
		<meta name="description" content="">
		<meta name="author" content="Anirudha Anil Mahadik">
		<title>Dashboard > Login</title>
		<link rel="shortcut icon" href="../images/favicon.png" type="image/x-icon" />
		
		<!-- CSS -->
		<link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="../css/login.css" />
		
		<!-- Javascript -->
		<script src="../bootstrap/js/jquery.min.js"></script>
		<script src="../bootstrap/js/bootstrap.min.js"></script>
	</head>
	<body>
		<div class="container">
			<form class="form-signin" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
				<h2 class="form-signin-heading">Please sign in</h2>
				<label for="inputEmail" class="sr-only">Email address</label>
				<input type="text" id="inputEmail" class="form-control" placeholder="Username" name="uname" required autofocus>
				<label for="inputPassword" class="sr-only">Password</label>
				<input type="password" id="inputPassword" class="form-control" placeholder="Password" name="password" required>
				<a href="#">Forgot password?</a>
				<button class="btn btn-lg btn-primary btn-block" type="submit" name="submit" value="signin">Sign in</button>
				<?php
					if(isset($_REQUEST["alert"])){
				?>
				<div class="alert alert-danger"><?php echo $_REQUEST["alert"]; ?></div>
				<?php
					}
				?>
				
			</form>
		</div>
	</body>
</html>
<?php
	if(isset($_REQUEST["submit"])){
		require_once("common.php");
		_databaseConnect();
		try{
			$_stmt = $_conn->prepare("SELECT * FROM user_credentials WHERE userid = :userid AND password = :password");
			$_stmt->bindParam(":userid", $_userid);
			$_stmt->bindParam(":password", $_password);
			$_userid = $_REQUEST["uname"];
			$_password = md5($_REQUEST["password"]);
			$_stmt->execute();
			$_stmt->setFetchMode(PDO::FETCH_ASSOC);
			$_result = $_stmt->fetchAll();
			if(empty($_result)){
				header("location:?alert=Invalid username or password!");
			}
			else{
				session_start();
				$_SESSION["_userid"] = $_result[0]["userid"];
				$_SESSION["_usertype"] = $_result[0]["user_type"];
				header("location:".$_SESSION["_usertype"]);
			}
		}
		catch(PDOException $_e){
			echo "Error! ".$_e->getMessage();
		}
	}
?>