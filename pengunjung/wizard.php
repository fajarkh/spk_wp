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
	<title>Identifikasi Ikan | SPK Rekomendasi Ikan Lele</title>

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
	<div class="image-container set-full-height" style="background-image: url('assets/img/paper-1.jpg')">
		<a href="../pengunjung/dashboard.php" class="made-with-pk">
			<div class="brand">
				<i class="ti-dashboard"></i>
			</div>
			<div class="made-with">Kembali ke <strong>Dashboard</strong>
			</div>
		</a>

		<!--   Big container   -->
		<div class="container">
			<div class="row">
				<div class="col-sm-8 col-sm-offset-2">

					<!--      Wizard container        -->
					<div class="wizard-container">
						<div class="card wizard-card" data-color="blue" id="wizard">
							<form action="" method="">
								<!--        You can switch " data-color="azure" "  with one of the next bright colors: "blue", "green", "orange", "red"           -->

								<div class="wizard-header">
									<h3 class="wizard-title">Identifikasi Ikan</h3>
									<p class="category"></p>
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
														<i class="ti-list"></i>
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
											<div class="row">
												<div class="col-sm-12">
													<h5 class="info-text"><?php echo $row_kriteria['pertanyaan'] ?></h5>
												</div>
												<div class="col-sm-8 col-sm-offset-2">
													<div class="form-group">
														<select class="form-control" id="sel<?php echo $row_kriteria['id_kriteria'] ?>" required>
															<option disabled="" selected="">- pilih pilihan -</option>
															<?php
															$macam = explode(", ", $row_kriteria['macam']);
															$nilai = explode(", ", $row_kriteria['nilai']);
															$combined = array_combine($nilai, $macam);
															foreach ($combined as $key => $value) {
																echo '<option value="' . $key . '">' . $value . '</option>';
															}
															?>
														</select>
													</div>
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
			</div> <!-- row -->
		</div> <!--  big container -->

		<div class="footer">
			<div class="container text-center">
				Dibuat dengan <i class="fa fa-heart heart"></i> thema by <a href="https://www.creative-tim.com">Creative Tim</a>.
			</div>
		</div>
	</div>

</body>

<!--   Core JS Files   -->
<script src="assets/js/jquery.3.2.1.min.js" type="text/javascript"></script>
<script src="assets/js/bootstrap.min.js" type="text/javascript"></script>
<script src="assets/js/jquery.bootstrap.wizard.js" type="text/javascript"></script>

<!--  Plugin for the Wizard -->
<script src="assets/js/paper-bootstrap-wizard.js" type="text/javascript"></script>

<!--  More information about jquery.validate here: https://jqueryvalidation.org/	 -->
<script src="assets/js/jquery.validate.min.js" type="text/javascript"></script>

<script>
	var id = new URLSearchParams(window.location.search).get('id');
	var status = new URLSearchParams(window.location.search).get('status');
	var url_wizard = "";

	function selectItemByValue(elmnt, value) {
		for (var i = 0; i < elmnt.options.length; i++) {
			if (elmnt.options[i].value === value) {
				elmnt.selectedIndex = i;
				break;
			}
		}
	}

	//handle notification after wizard
	function notification_wizard(data, status) {
		if (status == 0) {
			switch (data) {
				case 'success':
					location.href = '../pengunjung/dashboard.php#inserted';
					break;
				case 'duplicated':
					location.href = '../pengunjung/dashboard.php#insertedduplicated';
					break;
				case 'fail':
					location.href = '../pengunjung/dashboard.php#errorinsert';
					break;
				default:
					location.href = '../pengunjung/dashboard.php#errorinsert';
					break;
			}
		}
		if (status == 1) {
			switch (data) {
				case 'success':
					location.href = '../pengunjung/dashboard.php#updated';
					break;
				case 'fail':
					location.href = '../pengunjung/dashboard.php#errorupdate';
					break;
				default:
					location.href = '../pengunjung/dashboard.php#errorupdate';
					break;
			}
		}
	}

	//change wizard ajax based status identifikasi
	$(document).ready(function() {
		if (status == 0) {
			$('.wizard-title').text("Identifikasi ikan");
			url_wizard = "ajax/insert_rangking.php"
		}
		if (status == 1) {
			$('.wizard-title').text("identifikasi ikan");
			url_wizard = "ajax/update_rangking.php"
		}

		//prepare data identifikasi on wizard 
		$.ajax({
			method: "GET",
			url: "ajax/data_identifikasi.php",
			dataType: "json",
			data: "id=" + id,
		}).done(function(data) {
			if (data.length > 0) {
				$.each(data, function(key, value) {
					selectItemByValue(document.getElementById('sel' + value.id_kriteria), value.nilai_rangking);
				});
			}
		});

		//onclick selesai button
		$("#selesai").click(function() {
			var nilai = [];
			$(".form-control").each(function() {
				nilai.push($(this).val());
			})

			var i = 0;
			var idKriteria = [];
			$(".tab-pane").each(function() {
				idKriteria[i++] = $(this).attr("id");
			});
			$.ajax({
				type: "POST",
				dataType: "text",
				url: url_wizard,
				data: "id=" + id + "&nilai=" + nilai + "&idkriteria=" + idKriteria,
				success: function(data) {
					notification_wizard(data, status);
				}
			});
		});
	});
</script>

</html>