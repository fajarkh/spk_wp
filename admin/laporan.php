<?php
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
	<title>Sistem Pendukung Keputusan Metode WP</title>

	<!-- Bootstrap -->
	<link href="../css/bootstrap.min.css" rel="stylesheet">
	<link href="../css/dataTables.bootstrap.min.css" rel="stylesheet">

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>

	<nav class="navbar navbar-inverse navbar-static-top">
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
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav">
					<li><a href="../admin/dashboard.php">Home</a></li>
					<li><a href="../admin/kriteria.php">Kriteria</a></li>
					<li><a href="../admin/bobot.php">Bobot</a></li>
					<li><a href="../admin/alternatif.php">Alternatif</a></li>
					<li><a href="../admin/rangking.php">Rangking</a></li>
					<li class="active"><a href="../admin/laporan.php">Laporan</a></li>
				</ul>

			</div><!-- /.navbar-collapse -->
		</div><!-- /.container-fluid -->
	</nav>

	<div id="container" class="container">

		<?php
		include_once '../includes/alternatif.inc.php';
		$pro1 = new Alternatif($db);
		$stmt1 = $pro1->readAll();
		$stmt1x = $pro1->readAll();
		$stmt1y = $pro1->readAll();
		$stmt1r = $pro1->readRekomendasi();
		include_once '../includes/bobot.inc.php';
		$pro2 = new Bobot($db);
		$stmt2 = $pro2->readAll();
		$stmt2x = $pro2->readAll();
		$stmt2y = $pro2->readAll();
		$stmt2yx = $pro2->readAll();
		include_once '../includes/rangking.inc.php';
		$pro = new Rangking($db);
		$stmt = $pro->readKhusus();
		$stmtx = $pro->readKhusus();
		$stmty = $pro->readKhusus();
		?>
		<br />
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
					while ($row5 = $stmt1r->fetch(PDO::FETCH_ASSOC)) {
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
									$stmtrx = $pro->readR($ax);
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
									$stmtr = $pro->readR($a);
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

											$pro->ia = $a;
											$pro->ik = $b;
											$pro->nn4 = $nor;
											$pro->normalisasi1();
											?>
										</td>
									<?php } ?>
									<td>
										<?php
										$stmthasil = $pro->readHasil1($a);
										$hasil = $stmthasil->fetch(PDO::FETCH_ASSOC);
										echo $hasil['bbn'];
										$pro->has1 = $hasil['bbn'];
										$pro->hasil1();
										?>
									</td>
									<td>
										<?php
										$stmtmax = $pro->readMax();
										$maxnr = $stmtmax->fetch(PDO::FETCH_ASSOC);
										echo $hasil['bbn'] / $maxnr['mnr1']; //hasil vector v
										$pro->has2 = $hasil['bbn'] / $maxnr['mnr1'];
										$pro->hasil2();
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

	<?php
	include_once '../admin/footer.php';
	?>

	<script type="text/javascript" src="../js/jquery-3.3.1.js"></script>
	<script type="text/javascript" src="../js/jquery-3.3.1.min.js"></script>
	<script type="text/javascript" src="../js/bootstrap.min.js"></script>
	<script type="text/javascript" src="../js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" src="../js/tableExport.js"></script>
	<script type="text/javascript" src="../js/html2canvas.js"></script>
	<script type="text/javascript" src="../js/jspdf/libs/sprintf.js"></script>
	<script type="text/javascript" src="../js/jspdf/jspdf.js"></script>
	<script type="text/javascript" src="../js/jspdf/libs/base64.js"></script>
	<script type="text/javascript" src="../js/jquery-printme.js"></script>


	<script>
		$('#cetak').click(function() {

			$("#rangking").printMe({
				"path": "../css/bootstrap.min.css",
				"title": "LAPORAN HASIL AKHIR"
			});

		});
	</script>

	<script>
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
		})
	</script>
	<script>
		$(document).ready(function() {
			var table = $('#tabeldata2').DataTable();

			$('#tabeldata2 tbody').on('click', 'tr', function() {
				if ($(this).hasClass('selected')) {
					$(this).removeClass('selected');
				} else {
					table.$('tr.selected').removeClass('selected');
					$(this).addClass('selected');
				}
			});

			$('#button').click(function() {
				table.row('.selected').remove().draw(false);
			});
		});
	</script>
</body>

</html>