<?php
include_once '../admin/header.php';
include_once '../includes/macam.inc.php';
include_once '../includes/kriteria.inc.php';
$idk = isset($_GET['id']) ? $_GET['id'] : die('ERROR: missing ID.');
$pro = new Macam($db);
$eks = new Kriteria($db);

$eks->id = $idk;
$eks->readOne();

$pro->idk = $idk;
$stmt = $pro->readByKriteria();

if ($_POST) {
    $pro->id = $_POST['id_macam'];
    $pro->nab = $_POST['nab'];
    $pro->nib = $_POST['nib'];

    if ($_POST["operation"] == "Edit") {
        if ($pro->update()) {
            echo "<script>window.location.replace(window.location.href)</script>";
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

    if ($_POST["operation"] == "Add") {
        if ($pro->insert()) {
            echo "<script>window.location.replace(window.location.href)</script>";
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

    if ($_POST["operation"] == "Delete") {
        if ($pro->delete()) {
            echo "<script>window.location.replace(window.location.href)</script>";
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
}
?>

<div id="userModal" class="modal fade">
    <div class="modal-dialog">
        <form method="post" id="user_form" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Tambah Macam Kriteria</h4>
                </div>
                <div class="modal-body">
                    <label>Nama Macam</label>
                    <input type="text" name="nab" id="nab" class="form-control" />
                    <br />
                    <label>Nilai Macam</label>
                    <input type="text" name="nib" id="nib" class="form-control" />
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="id_macam" id="id_macam" />
                    <input type="hidden" name="operation" id="operation" />
                    <input type="submit" name="action" id="action" class="btn btn-success" value="Add" />
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-2"></div>
    <div class="col-xs-12 col-sm-12 col-md-8">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-6 text-left">
                        <h3>Ubah Macam Kriteria</h3>
                    </div>
                    <div class="col-md-6 text-right">
                        <h3>
                            <button type="button" onclick="location.href='../admin/kriteria.php'" class="btn btn-success">Kembali</button>
                        </h3>
                    </div>
                </div>

                <div class="card">
                    <h3 class="card-header text-center font-weight-bold text-uppercase py-4"><?php echo $eks->kt; ?></h3>
                    <div class="card-body">
                        <div id="table" class="table-editable">
                            <span class="table-add float-right mb-3 mr-2"><a href="#!" class="text-success"><i class="fas fa-plus fa-2x" aria-hidden="true"></i></a></span>
                            <table width="100%" class="table table-striped table-bordered" id="tabeldata">
                                <thead>
                                    <tr>
                                        <th width="10px"><input type="checkbox" name="select-all" id="select-all" /></th>
                                        <th class="text-center">Nama Macam Bobot</th>
                                        <th class="text-center">Nilai</th>
                                        <th class="text-center" width="70px" id="aksi">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    $emparray = array();
                                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

                                    ?>
                                        <tr>
                                            <td style="vertical-align:middle;"><input type="checkbox" value="<?php echo $row['id_macam'] ?>" name="checkbox[]" /></td>
                                            <td data-th="nama_macam" style="vertical-align:middle;"><?php echo $row['nama_macam'] ?></td>
                                            <td data-th="nilai" style="vertical-align:middle;"><?php echo $row['nilai'] ?></td>
                                            <td>
                                                <button class="btn btn-warning" type="button" name="edit" id="edit" val-id="<?php echo $row['id_macam'] ?>" val-macam="<?php echo $row['nama_macam'] ?>" val-nilai="<?php echo $row['nilai'] ?>">
                                                    <span class="glyphicon glyphicon-pencil"></span>
                                                </button>
                                                <button class="btn btn-danger" type="button" name="delete" id="delete" val-id="<?php echo $row['id_macam'] ?>">
                                                    <span class="glyphicon glyphicon-trash"></span>
                                                </button>
                                            </td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 text-left">
                    </div>
                    <div class="col-md-6 text-right">
                        <button class="btn btn-success" type="button" name="add_macam" id="add_macam" data-toggle="modal" data-target="#userModal">
                            <span class="glyphicon glyphicon-plus"></span>
                    </div>
                </div>
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
<script type="text/javascript" src="../js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="../js/dataTables.select.min.js"></script>
<script type="text/javascript" src="../js/dataTables.editor.min.js"></script>

<script>
    $(document).ready(function() {
        $('#add_macam').click(function() {
            $('#user_form')[0].reset();
            $('.modal-title').text("Tambah Macam bobot kriteria");
            $('.modal-body').show();
            $('#action').val("Add");
            $('#operation').val("Add");
        });


        $(document).on('click', '#edit', function() {
            var id_macam = $(this).attr('val-id');
            var macam = $(this).attr('val-macam');
            var nilai = $(this).attr('val-nilai');
            $('.modal-title').text("Ubah Macam Kriteria");
            $('.modal-body').show();
            $('#nab').val(macam);
            $('#nib').val(nilai);
            $('#id_macam').val(id_macam);
            $('#action').val("Edit");
            $('#operation').val("Edit");
            $('#userModal').modal('show');
        });

        $(document).on('click', '#delete', function(){
            var id_macam = $(this).attr('val-id');
            $('.modal-title').text("Yakin hapus macam kriteria ini ?");
            $('.modal-body').hide();
            $('#id_macam').val(id_macam);
            $('#action').val("Hapus");
            $('#operation').val("Delete");
            $('#userModal').modal('show');
        });

    });
</script>

<?php
include_once '../admin/footer.php';
?>