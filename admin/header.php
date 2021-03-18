<?php
session_start();
if (!$_SESSION["loggedin"] || $_SESSION["level"] != '1') {
	header("location:../index.php");
}

include "../includes/config.php";

$config = new Config();
$db = $config->getConnection();
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
	<title>Administrasi</title>

	<!-- Bootstrap -->
	<link href="../css/bootstrap.min.css" rel="stylesheet">
	<link href="../css/dataTables.bootstrap.min.css" rel="stylesheet">
	<link type="text/css" href="../css/jquery.toastmessage.css" rel="stylesheet" />

	<!-- CKEditor -->
	<script type="text/javascript" src="../ckeditor/ckeditor.js"></script>

	<!-- SELECT2 -->
	<link type="text/css" href="../css/select2-4.1.0/select2.min.css" rel="stylesheet" />

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
	<nav class="navbar navbar-default navbar-static-top">
		<div class="container">
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="../admin/dashboard.php">WP</a>
			</div>

			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="navbar-collapse collapse">
				<ul class="nav navbar-nav navbar-left">
					<li><a href="dashboard.php">Home</a></li>
					<li><a href="kriteria.php">Kriteria</a></li>
					<li><a href="bobot.php">Bobot</a></li>
					<li><a href="alternatif.php">Alternatif</a></li>
					<li><a href="rekomendasi.php">Rekomendasi</a></li>
				</ul>
				<ul class="nav navbar-nav navbar-right">
					<li><a href="#">Selamat datang, <?php echo $_SESSION['username']; ?></a></li>
					<li><a href="../logout.php" class="btn btn-simple"><span class="glyphicon glyphicon-user" aria-hidden="true"> Logout</span></a></li>
				</ul>
			</div>
		</div>
	</nav>
	</div><!-- /.navbar-collapse -->
	</div><!-- /.container-fluid -->
	</nav>

	<div class="container-fluid">