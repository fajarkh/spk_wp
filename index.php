<?php
session_start();
if (isset($_SESSION["loggedin"])) {
  if ($_SESSION["level"] == 1) {
    header("location: admin/dashboard.php");
    exit;
  } else {
    header("location: pengunjung/dashboard.php");
    exit;
  }
}
?>
<?php
include_once 'includes/config.php';
$config = new Config();
$db = $config->getConnection();

include_once 'includes/login.inc.php';
$login = new Login($db);

if (isset($_POST['form_login'])) {
  $login->email = $_POST['login_email'];
  $login->password = $_POST['login_password'];
  if ($login->login()) {
  } else { ?>
    <script type="text/javascript">
      alert('Email atau Password salah')
    </script>
  <?php
  }
}

if (isset($_POST['form_regis'])) {
  $login->email = $_POST['regis_email'];
  $login->password = $_POST['regis_password'];
  $login->first_name = $_POST['first_name'];
  $login->last_name = $_POST['last_name'];
  if ($login->register()) { ?>
    <script type="text/javascript">
      alert('Akun anda berhasil dibuat. Silahkan Masuk')
    </script>

  <?php  } else { ?>
    <script type="text/javascript">
      alert('Email atau Password salah')
    </script>
<?php
  }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>SPK WP - Aplikasi Penentuan Pembibitan Ikan Lele</title>

  <!-- Bootstrap core CSS -->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom fonts for this template -->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
  <link href="vendor/simple-line-icons/css/simple-line-icons.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">

  <!-- Custom styles -->
  <link href="css/landing-page.min.css" rel="stylesheet">
  <link href="css/login-register.css" rel="stylesheet" />

  <!-- Custom JS -->
  <script src="js/jquery-3.3.1.min.js" type="text/javascript"></script>
  <script src="js/bootstrap.min.js" type="text/javascript"></script>
  <script src="vendor/jquery/jquery.min.js" type="text/javascript"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="js/login-register.js" type="text/javascript"></script>

</head>

<body>
  <!-- Modal Login & register -->
  <div class="modal fade login" id="loginModal">
    <div class="modal-dialog login animated">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Masuk</h4>
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        </div>
        <div class="modal-body">
          <div class="box">
            <div class="content">
              <!-- <div class="social">
                <a id="google_login" href="#">
                  <i class="fab fa-google fa-2x fa-fw"></i>
                </a>
              </div> -->
              <!-- <div class="division">
                <div class="line l"></div>
                <span>atau</span>
                <div class="line r"></div>
              </div> -->
              <div class="error"></div>
              <div class="form loginBox">
                <form method="post" accept-charset="UTF-8" id="login-form">
                  <input id="login_email" class="form-control" type="text" placeholder="Email" name="login_email" autofocus>
                  <input id="login_password" class="form-control" type="password" placeholder="Password" name="login_password">
                  <input class="btn btn-default btn-login" type="submit" value="Masuk" name="form_login">
                </form>
              </div>
            </div>
          </div>
          <div class="box">
            <div class="content registerBox" style="display:none;">
              <div class="form">
                <form method="POST" html="{:multipart=>true}" data-remote="true" action="" accept-charset="UTF-8">
                  <input id="first_name" class="form-control" type="text" placeholder="Nama depan" name="first_name">
                  <input id="last_name" class="form-control" type="text" placeholder="Nama Belakang" name="last_name">
                  <input id="regis_email" class="form-control" type="text" placeholder="Email" name="regis_email">
                  <input id="regis_password" class="form-control" type="password" placeholder="Password" name="regis_password">
                  <input id="password_confirmation" class="form-control" type="password" placeholder="Ulang Password" name="password_confirmation">
                  <input class="btn btn-default btn-register" type="submit" value="Buat Akun" name="form_regis">
                </form>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <div class="forgot login-footer">
            <span>Ingin
              <a href="javascript: showRegisterForm();">buat akun</a>
              ?</span>
          </div>
          <div class="forgot register-footer" style="display:none">
            <span>Sudah punya akun?</span>
            <a href="javascript: showLoginForm();">Masuk</a>
          </div>
        </div>
      </div>
    </div>
  </div>



  <!-- Navigation -->
  <nav class="navbar navbar-light bg-light static-top">
    <div class="container">
      <a class="navbar-brand" href="#">Sistem Pendukung Keputusan Ikan Lele</a>
      <a class="btn btn-primary" data-toggle="modal" href="javascript:void(0)" onclick="openLoginModal();">Masuk</a>
    </div>
  </nav>

  <!-- Masthead -->
  <header class="masthead text-white text-center">
    <div class="overlay"></div>
    <div class="container">
      <div class="row">
        <div class="col-xl-9 mx-auto">
          <h1 class="mb-5">Cari tau jenis ikan lele yang cocok sesua dengan daerah mu, Mulai sekarang !</h1>
        </div>
        <div class="col-md-10 col-lg-8 col-xl-7 mx-auto">
          <form>
            <div class="form-row">
              <!-- <div class="col-12 col-md-9 mb-2 mb-md-0">
                <input type="email" class="form-control form-control-lg" placeholder="Enter your email...">
              </div> -->
              <div class="col-12">
                <button class="btn btn-block btn-lg btn-primary" data-toggle="modal" href="javascript:void(0)" onclick="openRegisterModal();">Mulai</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </header>

  <!-- Icons Grid -->
  <section class="features-icons bg-light text-center">
    <div class="container">
      <div class="row">
        <div class="col-lg-4">
          <div class="features-icons-item mx-auto mb-5 mb-lg-0 mb-lg-3">
            <div class="features-icons-icon d-flex">
              <i class="icon-screen-desktop m-auto text-primary"></i>
            </div>
            <h3>Identifikasi</h3>
            <p class="lead mb-0"></p>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="features-icons-item mx-auto mb-5 mb-lg-0 mb-lg-3">
            <div class="features-icons-icon d-flex">
              <i class="icon-layers m-auto text-primary"></i>
            </div>
            <h3>Validasi Data Ikan</h3>
            <p class="lead mb-0"></p>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="features-icons-item mx-auto mb-0 mb-lg-3">
            <div class="features-icons-icon d-flex">
              <i class="icon-check m-auto text-primary"></i>
            </div>
            <h3>Dapatkan Rekomedasi Pembibitan</h3>
            <p class="lead mb-0"></p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Call to Action -->
  <section class="call-to-action text-white text-center">
    <div class="overlay"></div>
    <div class="container">
      <div class="row">
        <div class="col-xl-9 mx-auto">
          <h2 class="mb-4">Siap cari tau? Registrasi Sekarang!</h2>
        </div>
        <div class="col-md-10 col-lg-8 col-xl-7 mx-auto">
          <form>
            <div class="form-row">
              <!-- <div class="col-12 col-md-9 mb-2 mb-md-0">
                <input type="email" class="form-control form-control-lg" placeholder="Enter your email...">
              </div> -->
              <div class="col-12">
                <button class="btn btn-block btn-lg btn-primary" data-toggle="modal" href="javascript:void(0)" onclick="openRegisterModal();">Mulai</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="footer bg-light">
    <div class="container">
      <div class="row">
        <div class="col-lg-6 h-100 text-center text-lg-left my-auto">
          <ul class="list-inline mb-2">
            <!-- <li class="list-inline-item">
              <a href="#">About</a>
            </li>
            <li class="list-inline-item">&sdot;</li>
            <li class="list-inline-item">
              <a href="#">Contact</a>
            </li>
            <li class="list-inline-item">&sdot;</li>
            <li class="list-inline-item">
              <a href="#">Terms of Use</a>
            </li>
            <li class="list-inline-item">&sdot;</li>
            <li class="list-inline-item">
              <a href="#">Privacy Policy</a>
            </li> -->
          </ul>
          <p class="text-muted small mb-4 mb-lg-0">&copy;
            <script>
              document.write(new Date().getFullYear())
            </script> - SPK</a> Rekomendasi ikan lele. All Rights Reserved.</p>
        </div>
        <div class="col-lg-6 h-100 text-center text-lg-right my-auto">
          <ul class="list-inline mb-0">
            <li class="list-inline-item mr-3">
              <a href="#">
                <i class="fab fa-facebook fa-2x fa-fw"></i>
              </a>
            </li>
            <li class="list-inline-item">
              <a href="#">
                <i class="fab fa-instagram fa-2x fa-fw"></i>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </footer>

  <script type="text/javascript">
    $(document).ready(function() {
      openLoginModal();
    });

    function checkPasswordMatch() {
      var password = $("#regis_password").val();
      var confirmPassword = $("#password_confirmation").val();
      if (password != confirmPassword) {
        $('.error').addClass('alert alert-danger').html('password konfirmasi tidak sama');
      } else {
        $('.error').removeClass('alert alert-danger').html('');
      }
    }

    $(document).ready(function() {
      $("#password_confirmation").keyup(checkPasswordMatch);
    });
  </script>

</body>

</html>