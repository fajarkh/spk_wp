<?php
include_once '../admin/header.php';
include_once '../includes/nilai.inc.php';
//$pgn = new Nilai($db);
if ($_POST) {

    include_once '../includes/kriteria.inc.php';
    $eks = new Kriteria($db);

    $eks->kt = $_POST['kt'];
    $eks->tp = $_POST['tp'];
    $eks->kp = $_POST['kp'];
    $eks->nab = $_POST['nama_macam_bobot'];
    $eks->nib = $_POST['nilai_macam_bobot'];

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

<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-2"></div>
    <div class="col-xs-12 col-sm-12 col-md-8">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-6 text-left">
                        <h3>Tambah Kriteria</h3>
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
                        <input type="text" class="form-control" id="kt" name="kt" required>
                    </div>
                    <div class="form-group">
                        <label for="tp">Tipe Kriteria</label>
                        <select class="form-control" id="tp" name="tp">
                            <option value='benefit'>Benefit</option>
                            <option value='cost'>Cost</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="kp">Teks Peryanyaan</label>
                        <input type="text" class="form-control" id="kp" name="kp" required>
                    </div>
                    <div class="form-group">
                        <table class="table table-bordered" id="dynamic_field">
                            <tr>
                                <td><input class="form-control" name="nama_macam_bobot[]" type="text" placeholder="nama macam bobot" required></td>
                                <td><input class="form-control" name="nilai_macam_bobot[]" type="text" placeholder="nilai macam bobot" required></td>
                                <td><button class="btn btn-success btn-add" type="button" name="add" id="add">
                                        <span class="glyphicon glyphicon-plus"></span>
                                    </button></td>
                            </tr>
                        </table>
                    </div>

                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>

            </div>
        </div>
    </div>

</div>

<script type="text/javascript" src="../js/jquery-3.3.1.js"></script>
<script type="text/javascript" src="../js/jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="../js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="../js/jquery.base64.js"></script>
<script type="text/javascript" src="../js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="../js/dataTables.select.min.js"></script>
<script type="text/javascript" src="../js/dataTables.editor.min.js"></script>

<script>
    $(document).ready(function() {
        var i = 1;
        $('#add').click(function() {
            i++;
            $('#dynamic_field').append('<tr id="row' + i + '"><td><input class="form-control" name="nama_macam_bobot[]" type="text" placeholder="nama macam bobot" required></td><td><input class="form-control" name="nilai_macam_bobot[]" type="text" placeholder="nilai macam bobot" required></td><td><button class="btn btn-danger btn-remove" type="button" name="remove" id="' + i + '"><span class="glyphicon glyphicon-minus"></span></button></td></tr>')
        });
        $(document).on('click', '.btn-remove', function() {
            var button_id = $(this).attr("id");
            $('#row' + button_id + '').remove();
        });

    });
</script>

<?php
include_once '../admin/footer.php';
?>