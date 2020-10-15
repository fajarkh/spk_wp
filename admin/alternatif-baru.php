<?php
include_once '../admin/header.php';
if ($_POST) {

	include_once '../includes/alternatif.inc.php';
	$eks = new Alternatif($db);

	$eks->kt = $_POST['kt'];
	$eks->ktd = $_POST['ktd'];

	if ($eks->insert()) {
?>
		<script type="text/javascript">
			window.onload = function() {
				showStickySuccessToast();
			};
		</script>
	<?php
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
<!-- <script type="text/javascript" src="../tinymce/js/tinymce/tinymce.min.js"></script>
<script type="text/javascript">
	tinymce.init({
		selector: "textarea",
		paste_data_images: true,
		plugins: [
			"advlist autolink lists link image charmap print preview hr anchor pagebreak",
			"searchreplace wordcount visualblocks visualchars code fullscreen",
			"insertdatetime media nonbreaking save table contextmenu directionality",
			"emoticons template paste textcolor colorpicker textpattern"
		],
		toolbar1: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
		toolbar2: "print preview media | forecolor backcolor emoticons",
		image_advtab: true,
		file_picker_callback: function(callback, value, meta) {
			if (meta.filetype == 'image') {
				$('#upload') .trigger('click');
				$('#upload').on('change', function() {
					var file = this.files[0];
					var reader = new FileReader();
					reader.onload = function(e) {
						callback(e.target.result, {
							alt: ''
						});
					};
					reader.readAsDataURL(file);
				});
			}
		},
		templates: [{
			title: 'Test template 1',
			content: 'Test 1'
		}, {
			title: 'Test template 2',
			content: 'Test 2'
		}]
	});
</script> -->

<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-2"></div>
	<div class="col-xs-12 col-sm-12 col-md-8">
		<div class="panel panel-default">
			<div class="panel-body">
				<div class="row">
					<div class="col-md-6 text-left">
						<h3>Tambah Alternatif</h3>
					</div>
					<div class="col-md-6 text-right">
						<h3>
							<button type="button" onclick="location.href='../admin/alternatif.php'" class="btn btn-success">Kembali</button>
						</h3>
					</div>
				</div>

				<form method="post">
					<div class="form-group">
						<label for="kt">Nama Alternatif</label>
						<input type="text" class="form-control" id="kt" name="kt" required>
						<label for="ktd">Deskripsi</label>
						<textarea class="form-control" id="ktd" name="ktd" required></textarea>
						<input name="image" type="file" id="upload" class="hidden" onchange="">
					</div>
					<button type="submit" class="btn btn-primary">Simpan</button>
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