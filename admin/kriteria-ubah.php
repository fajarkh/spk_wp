<?php
include_once '../admin/header.php';
include_once '../includes/nilai.inc.php';
include_once '../includes/alternatif.inc.php';

include_once '../includes/nilai.inc.php';
$pgn = new Nilai($db);

$id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: missing ID.');

include_once '../includes/kriteria.inc.php';
$eks = new Kriteria($db);

$eks->id = $id;

$eks->readOne();

if ($_POST) {

	$eks->kt = $_POST['kt'];
	$eks->kp = $_POST['kp'];
	$eks->tp = $_POST['tp'];

	if ($eks->update()) {
		echo "<script>location.href='../admin/kriteria.php'</script>";
	} else {
?>
		<script type="text/javascript">
			window.onload = function() {
				showStickyErrorToast();
			};
		</script>
<?php
	}
}
?>
<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-2"></div>
	<div class="col-xs-12 col-sm-12 col-md-8">
		<div class="panel panel-default">
			<div class="panel-body">
				<div class="row">
					<div class="col-md-6 text-left">
						<h3>Ubah Kriteria</h3>
					</div>
					<div class="col-md-6 text-right">
						<h3>
							<button type="button" onclick="location.href='../admin/kriteria.php'" class="btn btn-success">Kembali</button>
						</h3>
					</div>
				</div>

				<form method="post">
					<div class="form-group">
						<label for="kt">Nama Kriteria</label>
						<input type="text" class="form-control" id="kt" name="kt" value="<?php echo $eks->kt; ?>">
					</div>
					<div class="form-group">
						<label for="tp">Tipe Kriteria</label>
						<select class="form-control" id="tp" name="tp">
							<option><?php echo $eks->tp; ?></option>
							<option value='benefit'>Benefit</option>
							<option value='cost'>Cost</option>
						</select>
					</div>
					<div class="form-group">
                        <label for="kp">Teks Peryanyaan</label>
                        <input type="text" class="form-control" id="kp" name="kp" value="<?php echo $eks->kp; ?>">
                    </div>
					<button type="submit" class="btn btn-warning">Ubah</button>
				</form>

			</div>
		</div>
	</div>
	<div class="col-xs-12 col-sm-12 col-md-2">
	</div>
</div>
<?php
include_once '../admin/footer.php';
?>