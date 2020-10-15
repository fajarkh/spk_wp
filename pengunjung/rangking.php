<?php
include "../includes/config.php";
$config = new Config();
$db = $config->getConnection();

include_once '../includes/alternatif.inc.php';
$alternatif = new Alternatif($db);
$stmt1 = $alternatif->readAll();
$stmt1x = $alternatif->readAll();
$stmt1y = $alternatif->readAll();
$stmt_alternatif_recom = $alternatif->readRekomendasi();

include_once '../includes/bobot.inc.php';
$bobot = new Bobot($db);
$stmt2 = $bobot->readAll();
$stmt2x = $bobot->readAll();
$stmt2y = $bobot->readAll();
$stmt2yx = $bobot->readAll();

include_once '../includes/rangking.inc.php';
$rangking = new Rangking($db);
$stmt = $rangking->readKhusus();
$stmtx = $rangking->readKhusus();
$stmty = $rangking->readKhusus();
?>

<!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8" />
	<link rel="icon" type="image/png" href="assets/img/favicon.ico">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<title>Perangkingan</title>

	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
	<meta name="viewport" content="width=device-width" />

	<link href="assets/css/bootstrap.min.css" rel="stylesheet" />
	<link href="../css/dataTables.bootstrap.min.css" rel="stylesheet">
	<link href="assets/css/animate.min.css" rel="stylesheet" />
	<link href="assets/css/light-bootstrap-dashboard.css?v=1.4.0" rel="stylesheet" />

	<link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet" type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300' rel='stylesheet' type='text/css'>
	<link href="assets/css/pe-icon-7-stroke.css" rel="stylesheet" type='text/css' />

</head>

<body>

	<div class="wrapper">
		<br />
		<div>

			<div class="row">
				<div class="col-md-12">
					<div class="card">
						<div class="header">
							<h4 class="title"></h4>
							<p class="category"></p>
						</div>
						<div class="content">
							<div>
								<!-- Nav tabs -->
								<ul class="nav nav-tabs" role="tablist">
									<li role="presentation" class="active"><a href="#ringkasan" aria-controls="ringkasan" role="tab" data-toggle="tab">Ringkasan Rekomendasi</a></li>
									<li role="presentation"><a href="#rangking" aria-controls="rangking" role="tab" data-toggle="tab">Nilai Aktif Kriteria</a></li>
									<li role="presentation"><a href="#rangkingWP" aria-controls="rangkingWP" role="tab" data-toggle="tab">Perangkingan Metode Weighted Product</a></li>
								</ul>

								<!-- Tab panes -->
								<div class="tab-content">
									<!-- Tab Ringkasan Rekomendasi -->
									<div role="tabpanel" class="tab-pane active" id="ringkasan">
										<br />
										<h4>Ringkasan Rekomendasi</h4>
										<br />
										<?php
										while ($row5 = $stmt_alternatif_recom->fetch(PDO::FETCH_ASSOC)) {
										?>
											<p><?php echo $row5['nama_alternatif'] ?></p>

										<?php } ?>
									</div>
									<!-- End Tab Ringkasan Rekomendasi -->

									<!-- Tab Nilai Aktif Kriteria -->
									<div role="tabpanel" class="tab-pane" id="rangking">
										<br />
										<h4>Nilai Alternatif Kriteria</h4>
										<table width="100%" class="table table-striped table-bordered">
											<thead>
												<tr>
													<th rowspan="2" style="vertical-align: middle" class="text-center">Alternatif</th>
													<th colspan="<?php echo $stmt2x->rowCount(); ?>" class="text-center">Kriteria</th>
												</tr>
												<tr>
													<?php
													while ($row2x = $stmt2x->fetch(PDO::FETCH_ASSOC)) {
													?>
														<th><?php echo $row2x['nama_kriteria'] ?><br />(<?php echo $row2x['tipe_kriteria'] ?>)</th>
													<?php
													}
													?>
												</tr>
											</thead>

											<tbody>
												<tr>
													<th>Bobot</th>
													<?php
													while ($row2y = $stmt2y->fetch(PDO::FETCH_ASSOC)) {
													?>
														<td>
															<?php
															echo $row2y['hasil_bobot'];
															?>
														</td>
													<?php
													}
													?>
												</tr>
												<?php
												while ($row1x = $stmt1x->fetch(PDO::FETCH_ASSOC)) {
												?>
													<tr>
														<th><?php echo $row1x['nama_alternatif'] ?></th>
														<?php
														$ax = $row1x['id_alternatif'];
														$stmtrx = $rangking->readR($ax);
														while ($rowrx = $stmtrx->fetch(PDO::FETCH_ASSOC)) {
														?>
															<td>
																<?php
																echo $rowrx['nilai_rangking'];
																?>
															</td>
														<?php
														}
														?>
													</tr>
												<?php  } ?>
											</tbody>
											<br />
										</table>
									</div>
									<!-- End Tab Nilai Aktif Kriteria -->

									<!-- Tab Perangkingan Metode Weighted Product -->
									<div role="tabpanel" class="tab-pane" id="rangkingWP">
										<h4>Perangkingan Metode Weighted Product</h4>
										<table width="100%" class="table table-striped table-bordered" id="tabeldata2">
											<thead>
												<tr>
													<th rowspan="2" style="vertical-align: middle" class="text-center">Alternatif</th>
													<th colspan="<?php echo $stmt2->rowCount(); ?>" class="text-center">Kriteria</th>
													<th rowspan="2" style="vertical-align: middle" class="text-center">Vektor S</th>
													<th rowspan="2" style="vertical-align: middle" class="text-center">Vektor V</th>
												</tr>
												<tr>

													<?php
													while ($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)) {
													?>
														<th><?php echo $row2['nama_kriteria'] ?></th>

													<?php } ?>
												</tr>
											</thead>
											<tbody>
												<?php
												while ($row1 = $stmt1->fetch(PDO::FETCH_ASSOC)) {
												?>
													<tr>
														<th><?php echo $row1['nama_alternatif'] ?></th>
														<?php
														$a = $row1['id_alternatif'];
														$stmtr = $rangking->readR($a);
														while ($rowr = $stmtr->fetch(PDO::FETCH_ASSOC)) {
															$b = $rowr['id_kriteria'];
															$tipe = $rowr['tipe_kriteria'];
															$bobot = $rowr['hasil_bobot'];
														?>
															<td>
																<?php
																if ($tipe == 'benefit') {
																	echo $nor = pow($rowr['nilai_rangking'], $bobot);
																} else {
																	echo $nor = pow($rowr['nilai_rangking'], -$bobot);
																}

																$rangking->ia = $a;
																$rangking->ik = $b;
																$rangking->nn4 = $nor;
																$rangking->normalisasi1();
																?>
															</td>
														<?php } ?>
														<td>
															<?php
															$stmthasil = $rangking->readHasil1($a);
															$hasil = $stmthasil->fetch(PDO::FETCH_ASSOC);
															echo $hasil['bbn'];
															$rangking->has1 = $hasil['bbn'];
															$rangking->hasil1();
															?>
														</td>
														<td>
															<?php
															$stmtmax = $rangking->readMax();
															$maxnr = $stmtmax->fetch(PDO::FETCH_ASSOC);
															echo $hasil['bbn'] / $maxnr['mnr1']; //hasil vector v
															$rangking->has2 = $hasil['bbn'] / $maxnr['mnr1'];
															$rangking->hasil2();
															?>
														</td>
													</tr>
												<?php } ?>
											</tbody>
										</table>
									</div>
									<!-- End Tab Perangkingan Metode Weighted Product -->
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

		</div>
	</div>
</body>

<!--   Core JS Files   -->
<script src="assets/js/jquery.3.2.1.min.js" type="text/javascript"></script>
<script src="assets/js/bootstrap.min.js" type="text/javascript"></script>
<script src="assets/js/holder.min.js" type="text/javascript"></script>
<script src="../js/jquery.dataTables.min.js"></script>
<script src="../js/dataTables.bootstrap.min.js"></script>
<script src="../js/popper.min.js"></script>

<script type="text/javascript">
	$(document).ready(function() {

		$('#tabeldata2').DataTable({
			"bInfo": false, //Dont display info
			"paging": false, //Dont want paging                
			"bPaginate": false, //Dont want paging   
			"bFilter": false,
			columnDefs: [{
				orderable: false,
				targets: [0, 1, 2, 3, 4, 5, 6]
			}, ],
			"order": [
				[7, "desc"]
			],

		});
	});
</script>

</html>