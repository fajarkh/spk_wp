<?php
include_once '../admin/header.php';
include_once '../includes/kriteria.inc.php';
include_once '../includes/macam.inc.php';

$kriteria = new Kriteria($db);
$stmt_kriteria = $kriteria->readAll();

$id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: missing ID.');

?>

<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-2"></div>
	<div class="col-xs-12 col-sm-12 col-md-8">
		<div class="panel panel-default">
			<div class="panel-body">
				<div class="row">
					<div class="col-md-6 text-left">
						<h3>Ubah Alternatif</h3>
					</div>
					<div class="col-md-6 text-right">
						<h3>
							<button type="button" onclick="location.href='../admin/alternatif.php'" class="btn btn-success">Kembali</button>
						</h3>
					</div>
				</div>

				<form action="" method="">
					<div class="form-group">
						<label for="kt">Nama Alternatif</label>
						<input type="text" class="form-control" id="kt" name="kt" required>
						<label for="ktd">Deskripsi</label>
						<textarea class="form-control" id="ktd" name="ktd" required></textarea>
						<input name="image" type="file" id="upload" class="hidden" onchange="">
						<?php while ($row_kriteria = $stmt_kriteria->fetch(PDO::FETCH_ASSOC)) { ?>
							<label for="<?php echo $row_kriteria['id_kriteria'] ?>"><?php echo $row_kriteria['nama_kriteria'] ?></label>
							<select class="form-control select" id="<?php echo $row_kriteria['id_kriteria'] ?>">
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
						<?php } ?>

					</div>
					<button type="button" class="btn btn-primary" id='selesai' value='Simpan'>Simpan</button>
				</form>

			</div>
		</div>
	</div>
	<div class="col-xs-12 col-sm-12 col-md-2">
	</div>
</div>

<script type="text/javascript" src="../js/jquery-3.3.1.js"></script>
<script type="text/javascript" src="../js/jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="../js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="../js/jquery.base64.js"></script>

<script>
	var id = new URLSearchParams(window.location.search).get('id');
	//var status = new URLSearchParams(window.location.search).get('status');

	function selectItemByValue(elmnt, value) {
		for (var i = 0; i < elmnt.options.length; i++) {
			if (elmnt.options[i].value === value) {
				elmnt.selectedIndex = i;
				break;
			}
		}
	}

	$(document).ready(function() {

		//prepare data alternatif 
		$.ajax({
			method: "GET",
			url: "ajax/data_alternatif.php",
			dataType: "json",
			data: "id=" + id,
		}).done(function(data) {
			if (data["kriteria"].length > 0) {
				$.each(data["kriteria"], function(key, value) {
					selectItemByValue(document.getElementById(value.id_kriteria), value.nilai_rangking);
				});
				document.getElementById('kt').value = data.nama_alternatif;
				document.getElementById('ktd').value = data.deskripsi;
			}

		});

		//onclick selesai button
		$("#selesai").click(function() {
			var kt = document.getElementById("kt").value;
			var ktd = document.getElementById("ktd").value;
			var nilai = [];
			$(".form-control.select").each(function() {
				nilai.push($(this).val());
			})

			var i = 0;
			var idKriteria = [];
			$(".form-control.select").each(function() {
				idKriteria[i++] = $(this).attr("id");
			});
			console.log("kt = "+kt+" ktd = "+ktd+" id = "+id+" nilai = "+nilai+" idkriteria = "+idKriteria)
			$.ajax({
				type: "POST",
				dataType: "text",
				url: "ajax/update_alternatif.php",
				data: "id=" + id +"&nilai=" + nilai + "&idkriteria=" + idKriteria + "&kt=" + kt + "&ktd=" + ktd,
				success: function(data) {
					notification_wizard(data);
				}
			});
		});
	});
</script>
<?php
include_once '../admin/footer.php';
?>

<script>
	//handle notification after wizard
	function notification_wizard(data) {
		if (data == 'success') {
			location.href = '../admin/alternatif.php';
		}
	}
</script>