<?php
include "../includes/config.php";
$config = new Config();
$db = $config->getConnection();

include_once '../includes/kriteria.inc.php';
include_once '../includes/macam.inc.php';

$id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: missing ID.');

$kriteria = new Kriteria($db);
$stmt_kriteria = $kriteria->readAll();
$stmt_kriteria1 = $kriteria->readAll();


?>

<!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png" />
	<link rel="icon" type="image/png" href="assets/img/favicon.png" />
	<title>Register | Penentuan Pembibitan Ikan Lele</title>

	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
	<meta name="viewport" content="width=device-width" />

	<!-- CSS Files -->
	<link href="assets/css/bootstrap.min.css" rel="stylesheet" />
	<link href="assets/css/paper-bootstrap-wizard.css" rel="stylesheet" />

	<!-- Fonts and Icons -->
	<link href="https://netdna.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.css" rel="stylesheet">
	<link href='https://fonts.googleapis.com/css?family=Muli:400,300' rel='stylesheet' type='text/css'>
	<link href="assets/css/themify-icons.css" rel="stylesheet">
</head>

<body>

	<div class="image-container set-full-height" style="background-image: url('assets/img/paper-1.jpeg')">

		<!--   Big container   -->
		<div class="container">
			<div class="row">
				<div class="col-sm-8 col-sm-offset-2">
					<!--      Wizard container        -->
					<div class="wizard-container">
						<div class="card wizard-card" data-color="blue" id="wizardProfile">
							<form action="" method="">
								<div class="wizard-header text-center">
									<h3 class="wizard-title">Mulai Identifikasi</h3>
									<p class="category">Informasi ini digunakan untuk menidentifikasi ikan yang cocok untuk calon pembudidaya.</p>
								</div>

								<div class="wizard-navigation">
									<div class="progress-with-circle">
										<div class="progress-bar" role="progressbar" aria-valuenow="1" aria-valuemin="1" aria-valuemax="3" style="width: 21%;"></div>
									</div>
									<ul>
										<?php while ($row_kriteria = $stmt_kriteria->fetch(PDO::FETCH_ASSOC)) { ?>
											<li>
												<a href="#<?php echo $row_kriteria['id_kriteria'] ?>" data-toggle="tab">
													<div class="icon-circle">
														<i class="ti-user"></i>
													</div>
													<?php echo $row_kriteria['nama_kriteria'] ?>
												</a>
											</li>
										<?php } ?>
									</ul>
								</div>
								<div class="tab-content">
									<?php while ($row_kriteria = $stmt_kriteria1->fetch(PDO::FETCH_ASSOC)) { ?>
										<div class="tab-pane" id="<?php echo $row_kriteria['id_kriteria'] ?>">
											<h5 class="info-text"><?php echo $row_kriteria['pertanyaan'] ?></h5>
											<div class="row">
												<div class="col-sm-8 col-sm-offset-2">
													<?php
													$macam = explode(", ", $row_kriteria['macam']);
													$nilai = explode(", ", $row_kriteria['nilai']);
													$combined = array_combine($nilai, $macam);
													foreach ($combined as $key => $value) { ?>
														<div class="col-sm-4">
															<div class="choice" id="<?php echo $row_kriteria['id_kriteria'] ?>" data-toggle="wizard-checkbox">
																<input type="checkbox" name="sel<?php echo $row_kriteria['id_kriteria'] ?>" value="<?php echo $key; ?>">
																<div class="card card-checkboxes card-hover-effect">
																	<i class="ti-paint-roller"></i>
																	<p><?php echo $value; ?></p>
																</div>
															</div>
														</div>
													<?php } ?>
												</div>
											</div>
										</div>
									<?php } ?>
								</div>
								<div class="wizard-footer">
									<div class="pull-right">
										<input type='button' class='btn btn-next btn-fill btn-primary btn-wd' name='next' value='Selanjutnya' />
										<input type='button' class='btn btn-finish btn-fill btn-primary btn-wd' name='finish' id='selesai' value='Simpan' />
									</div>

									<div class="pull-left">
										<input type='button' class='btn btn-previous btn-default btn-wd' name='previous' value='Sebelumnya' />
									</div>
									<div class="clearfix"></div>
								</div>
							</form>
						</div>
					</div> <!-- wizard container -->
				</div>
			</div><!-- end row -->
		</div> <!--  big container -->

		<div class="footer">
			<div class="container text-center">
				Made with <i class="fa fa-heart heart"></i> by <a href="https://www.creative-tim.com">Creative Tim</a>. Free download <a href="https://www.creative-tim.com/product/paper-bootstrap-wizard">here.</a>
			</div>
		</div>
	</div>

</body>

<!--   Core JS Files   -->
<script src="assets/js/jquery-2.2.4.min.js" type="text/javascript"></script>
<script src="assets/js/bootstrap.min.js" type="text/javascript"></script>
<script src="assets/js/jquery.bootstrap.wizard.js" type="text/javascript"></script>

<!--  Plugin for the Wizard -->
<script src="assets/js/demo.js" type="text/javascript"></script>
<script src="assets/js/paper-bootstrap-wizard.js" type="text/javascript"></script>

<!--  More information about jquery.validate here: https://jqueryvalidation.org/	 -->
<script src="assets/js/jquery.validate.min.js" type="text/javascript"></script>

<script>
	$(document).ready(function() {

		var i = 0;
		var idKriteria = [];
		$(".tab-pane").each(function() {
			idKriteria[i++] = $(this).attr("id");
		});

		// membuat hanya satu checkbox yang dapat di pilih
		for (let j = 0; j < idKriteria.length; j++) {
			$("#" + idKriteria[j] + " div.choice").click(function() {
				$("#" + idKriteria[j] + " div.choice.active").removeClass("active");
				$(this).toggleClass("active");
			});
		}

		//onclick selesai button
		$("#selesai").click(function() {
			var nilai = [];
			$("div.choice.active > input[type=checkbox]:checked").each(function() {
				nilai.push($(this).val());
			});
			//console.log(nilai);

			// $.ajax({
			// 	type: "POST",
			// 	dataType: "text",
			// 	url: url_wizard,
			// 	data: "id=" + id + "&nilai=" + nilai + "&idkriteria=" + idKriteria,
			// 	success: function(data) {
			// 		notification_wizard(data, status);
			// 	}
			// });
		});
	});
</script>

</html>