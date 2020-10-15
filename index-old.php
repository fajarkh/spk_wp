<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Login</title>
<link rel="shortcut icon" href="images/ico.png" />
<link rel="stylesheet" href="css/index.css" type="text/css" />
<link rel="stylesheet" href="css/basic-jquery-slider.css" type="text/css" />
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/tooltip.js"></script>
<script type="text/javascript" src="js/basic-jquery-slider.js"></script>
		<script>
			$(document).ready(function(){
				$('#slideshow').bjqs({
					'width' : 720,
					'height' : 238,
					'showmarkers' : false,
					'showcontrols' : true
				});
			});

		</script>
</head>

<?php
include "includes/config.php";
include_once 'admin/footer.php';
$config = new Config();
$db = $config->getConnection();
if($_POST){
	
	include_once 'includes/login.inc.php';
	$eks = new Login($db);

	$eks->userid = $_POST['userid'];
	$eks->passid = $_POST['passid'];
	if($eks->login()){
		?>
		<script type="text/javascript">
		window.onload=function(){
			showStickySuccessToast();
			//window.location=('admin/dashboard.php')</script>";
		};
		</script>
		<?php
			}
			
			else{
		?>
		<script type="text/javascript">
		window.onload=function(){
			//showStickyWrongLogin();
			window.location=('admin/dashboard.php');
		};
		</script>
		<?php
			}
		}
?>

<body background="images/bg.jpg" style="background-attachment:fixed">
<div class="mainbox"></div>
<form method="post">
	<input type="text" placeholder="Email atau Username" class="email" id="userid" name="userid" />
    <input type="password" placeholder="Password" class="pass" id="passid" name="passid" />
    <label class="checklabel"><input type="checkbox" checked="" class="check" /> 
    Ingat Saya</label>
	<button type="submit" class="button submit" title="Submit">Log In</button>
</form>
    <!-- <a href="#" class="forgot2" title="Lupa Password?" target="_blank"></a> -->
<a href="#" class="button daftar" title="Sign Up">Daftar</a>
<div class="usericon"></div>
<div class="passicon"></div>
<div id="slideshow">
	<ul class="bjqs">
		<li>
		<img src="images/slide/1.png" alt="slide" />
		</li>
		<li>
		<img src="images/slide/2.jpg" alt="slide" />
		</li>
		<li>
		<img src="images/slide/3.jpg" alt="slide" />
		</li>
	</ul>
</div>
<footer>Sistem Informiasi Penunjang Keputusan Pemilihan Ikan Lele
	<a href="#" class="info" title="Information" target="_blank"></a>
    <a href="#" class="fb" title="Facebook" target="_blank"></a>
    <a href="#" class="gplus" title="Google +Plus" target="_blank"></a>
</footer>
</body>
</html>