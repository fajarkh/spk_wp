<?php
session_start();
include '../includes/config.php';
$config = new Config();
$db = $config->getConnection();

$user_id = $_SESSION['id_user'];
//$user_id = 1;

include_once '../includes/alternatif.inc.php';
$alternatif = new Alternatif($db);
$stmt_alternatif = $alternatif->readAllByUser($user_id);
$stmt_alternatifx = $alternatif->readAllByUser($user_id);
$stmt_alternatify = $alternatif->readAllByUser($user_id);
$stmt_alternatif_recom = $alternatif->readRekomendasi($user_id);
$stmt_alternatif_recom2 = $alternatif->readRekomendasi2($user_id);

include_once '../includes/bobot.inc.php';
$bobot = new Bobot($db);
$stmt_bobot = $bobot->readAll();
$stmt_bobotx = $bobot->readAll();
$stmt_boboty = $bobot->readAll();
$stmt_bobotyx = $bobot->readAll();

include_once '../includes/rangking.inc.php';
$rangking = new Rangking($db);
?>

<!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8" />
	<link rel="icon" type="image/png" href="../images/favicon.png">
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

	<style>
		.notify-badge {
			position: absolute;
			right: 40px;
			top: 120px;
			background: cyan;
			text-align: center;
			border-radius: 30px 30px 30px 30px;
			color: white;
			padding: 5px 10px;
			font-size: 16px;
		}

		.item {
			position: relative;
			padding-top: 20px;
			display: inline-block;
		}
	</style>
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
										<?php
										while ($row5 = $stmt_alternatif_recom->fetch(PDO::FETCH_ASSOC)) {
										?>
											<div class="card card-user">
												<div class="image">
													<img src="../images/bg2.jpg" alt="..." />
												</div>
												<div class="content">
													<div class="author">
														<div class="item">
															<a href="#">
																<img class="avatar border-gray" src="../images/lele.jpg" alt="..." />
																<span class="notify-badge">1</span>
																<h4 class="title"><?php echo $row5['nama_alternatif'] ?>
																	<br />
																	<small> id : <?php echo $row5['id_alternatif'] ?></small>
																</h4>
															</a>
														</div>
													</div>
													<p class="description text-center"> "<?php echo $row5['deskripsi'] ?>"
													</p>
												</div>
												<hr>
												<div class="text-center">
													<a href="#" class="btn btn-simple"><i class="fa fa-bolt"></i>Vektor S : <?php echo $row5['vektor_s'] ?></a>
													<a href="#" class="btn btn-simple"><i class="fa fa-bolt"></i>Vektor V : <?php echo $row5['vektor_v'] ?></a>

												</div>
											</div>
										<?php } ?>
										<?php
										$num = 2;
										while ($row6 = $stmt_alternatif_recom2->fetch(PDO::FETCH_ASSOC)) {  ?>
											<div class="col-xs-12 col-sm-12 col-md-4">
												<div class="panel panel-default">
													<div class="panel-heading">
														<h3 class="panel-title"><?php echo "#" . $num . " " . $row6['nama_alternatif'] ?></h3>
													</div>
													<div class="panel-body">

														<table class="table table-bordered">
															<tr>
																<th>id</th>
																<th>Vektor S</th>
																<th>Vektor v</th>
															</tr>

															<tr>
																<td><?php echo $row6['id_alternatif'] ?></td>
																<td><?php echo $row6['vektor_s'] ?></td>
																<td><?php echo $row6['vektor_v'] ?></td>
															</tr>
														</table>
													</div>
												</div>
											</div>
										<?php
											$num = $num += 1;
										} ?>

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
													<th colspan="<?php echo $stmt_bobotx->rowCount(); ?>" class="text-center">Kriteria</th>
												</tr>
												<tr>
													<?php
													while ($row2x = $stmt_bobotx->fetch(PDO::FETCH_ASSOC)) {
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
													while ($row2y = $stmt_boboty->fetch(PDO::FETCH_ASSOC)) {
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
												while ($row1x = $stmt_alternatifx->fetch(PDO::FETCH_ASSOC)) {
												?>
													<tr>
														<th><?php echo $row1x['nama_alternatif'] ?></th>
														<?php
														$ax = $row1x['id_alternatif'];
														$stmt_rangkingrx = $rangking->readR($ax);
														while ($rowrx = $stmt_rangkingrx->fetch(PDO::FETCH_ASSOC)) {
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
													<th colspan="<?php echo $stmt_bobot->rowCount(); ?>" class="text-center">Kriteria</th>
													<th rowspan="2" style="vertical-align: middle" class="text-center">Vektor S</th>
													<th rowspan="2" style="vertical-align: middle" class="text-center">Vektor V</th>
												</tr>
												<tr>

													<?php
													while ($row2 = $stmt_bobot->fetch(PDO::FETCH_ASSOC)) {
													?>
														<th><?php echo $row2['nama_kriteria'] ?></th>

													<?php } ?>
												</tr>
											</thead>
											<tbody>
												<?php
												while ($row1 = $stmt_alternatif->fetch(PDO::FETCH_ASSOC)) {
												?>
													<tr>
														<th><?php echo $row1['nama_alternatif'] ?></th>
														<?php
														$a = $row1['id_alternatif'];
														$stmt_rangkingr = $rangking->readR($a);
														while ($rowr = $stmt_rangkingr->fetch(PDO::FETCH_ASSOC)) {
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
<!-- <script src="..js/moment.min.js" type="text/javascript"></script> -->
<script src="../js/chartjs/Chart.min.js" type="text/javascript"></script>

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