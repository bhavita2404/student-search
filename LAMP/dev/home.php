<?php 
include('../functions.php');

	if (!isLoggedIn()) {
		$_SESSION['msg'] = "You must log in first";
		header('location: ../index.php');
	}

	if (isset($_GET['logout'])) {
		session_destroy();
		unset($_SESSION['user']);
		header("location: ../index.php");
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Home</title>
	<link rel="stylesheet" type="text/css" href="../style.css">
	<style>
	.header {
		background: #003366;
	}
	button[name=register_btn] {
		background: #003366;
	}
	</style>
</head>
<body>
	<div class="header">
		<h2>Dev - Home Page</h2>
	</div>
	<div class="content">
		<!-- notification message -->
		<?php if (isset($_SESSION['success'])) : ?>
			<div class="error success" >
				<h3>
					<?php 
						echo $_SESSION['success']; 
						unset($_SESSION['success']);
					?>
				</h3>
			</div>
		<?php endif ?>

		<!-- logged in user information -->
		<div class="profile_info">
			<img src="../images/dev_profile.png"  >

			<div>
				<?php  if (isset($_SESSION['user'])) : ?>
					<strong><?php echo $_SESSION['user']['username']; ?></strong>

					<small>
						<i  style="color: #888;">(<?php echo ucfirst($_SESSION['user']['user_type']); ?>)</i> 
						<br>
						<a href="home.php?logout='1'" style="color: red;">logout</a>
                       <!-- &nbsp; <a href="create_user.php"> + add user for login</a> --> 
                       	<br> 
						<a href="../search/public/read.php"><strong>find a user</strong></a> 
						<br>
						<a href="../search/public/update.php"><strong>edit a user</strong></a> 
					</small>

				<?php endif ?>
			</div>
		</div>
	</div>
<!-- 	<ul>
		<li><a href="../search/public/read.php"><strong>Read</strong></a> - find a user</li>
		<li><a href="../search/public/update.php"><strong>Update</strong></a> - edit a user</li>
	</ul> -->
</body>
</html>