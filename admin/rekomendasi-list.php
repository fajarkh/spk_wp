<?php
include_once '../admin/header.php';
include_once '../includes/alternatif.inc.php';
include_once '../includes/rekomendasi.inc.php';
$post_id = isset($_GET['post_id']) ? $_GET['post_id'] : die('ERROR: missing ID.');
$alternatif = new Alternatif($db);
$rekomendasi = new Rekomendasi($db);

$rekomendasi->post_id = $post_id;
$rekomendasi->readOne();

$alternatif->post_id = $post_id;
$stmtAlternatif = $alternatif->readByRekomendasi();
$stmtAlternatifRekomendasi = $alternatif->listRekomendasi();

if ($_POST) {
    $alternatif->id = $_POST['id_alternatif'];

    if ($_POST["operation"] == "Delete") {
        if ($alternatif->resetIdBerita()) {
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

<div id="alternatifModal" class="modal fade">
    <div class="modal-dialog" style="width: auto; max-width: 960px;">
        <form method="post" id="user_form" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <table width="100%" class="table table-striped table-bordered" id="tabeldataModal">
                        <thead>
                            <tr>
                                <th class="text-center">Nama Alternatif</th>
                                <th class="text-center">Detail Alternatif</th>
                                <th class="text-center">Vektor S</th>
                                <th class="text-center">Vektor V</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            $emparray = array();
                            while ($row = $stmtAlternatifRekomendasi->fetch(PDO::FETCH_ASSOC)) {

                            ?>
                                <tr>
                                    <td style="vertical-align:middle;"><?php echo $row['nama_alternatif'] ?></td>
                                    <td style="vertical-align:middle;"><?php echo $row['macam'] ?></td>
                                    <td style="vertical-align:middle;"><?php echo $row['vektor_s'] ?></td>
                                    <td style="vertical-align:middle;"><?php echo $row['vektor_v'] ?></td>
                                    <td>
                                        <button class="btn btn-success addAlternatif" type="button" val="<?php echo $row['id_alternatif'] ?>">
                                            <span class="glyphicon glyphicon-ok"></span>
                                        </button>
                                    </td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="id_alternatif" id="id_alternatif" />
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
                        <h3>Ubah List Rekomendasi</h3>
                    </div>
                    <div class="col-md-6 text-right">
                        <h3>
                            <button type="button" onclick="location.href='../admin/rekomendasi.php'" class="btn btn-success">Kembali</button>
                        </h3>
                    </div>
                </div>

                <div class="card">
                    <h3 class="card-header text-center font-weight-bold text-uppercase py-4"><?php echo $rekomendasi->post_title; ?></h3>
                    <div class="card-body">
                        <div id="table" class="table-editable">
                            <span class="table-add float-right mb-3 mr-2"><a href="#!" class="text-success"><i class="fas fa-plus fa-2x" aria-hidden="true"></i></a></span>
                            <table width="100%" class="table table-striped table-bordered" id="tabeldata">
                                <thead>
                                    <tr>
                                        <th width="10px"><input type="checkbox" name="select-all" id="select-all" /></th>
                                        <th class="text-center">Nama Alternatif</th>
                                        <th class="text-center">Detail Alternatif</th>
                                        <th class="text-center">Vektor S</th>
                                        <th class="text-center">Vektor V</th>
                                        <th class="text-center" width="30px" id="aksi">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    $emparray = array();
                                    while ($row = $stmtAlternatif->fetch(PDO::FETCH_ASSOC)) {

                                    ?>
                                        <tr>
                                            <td style="vertical-align:middle;"><input type="checkbox" value="<?php echo $row['id_alternatif'] ?>" name="checkbox[]" /></td>
                                            <td style="vertical-align:middle;"><?php echo $row['nama_alternatif'] ?></td>
                                            <td style="vertical-align:middle;"><?php echo $row['macam'] ?></td>
                                            <td style="vertical-align:middle;"><?php echo $row['vektor_s'] ?></td>
                                            <td style="vertical-align:middle;"><?php echo $row['vektor_v'] ?></td>
                                            <td>
                                                <button class="btn btn-danger" type="button" name="delete" id="delete" val-id="<?php echo $row['id_alternatif'] ?>">
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
                        <button class="btn btn-success" type="button" name="add_list_alternatif" id="add_list_alternatif" data-toggle="modal" data-target="#alternatifModal">
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

<script>
    var id_berita = new URLSearchParams(window.location.search).get('post_id');
    $(document).ready(function() {
        var tabeldataModal = $('#tabeldataModal').DataTable();

        //event ketika tombol tambah di halaman rekomdasi-list di tekan
        $('#add_list_alternatif').click(function() {
            $('.modal-title').text("Tambah Alternatif Rekomendasi");
            $('.modal-body').show();
            $('#action').hide();
            $('#operation').val("Add");
        });

        //event ketika tombol hapus pada modal di halaman rekomdasi-list di tekan
        $(document).on('click', '#delete', function() {
            var id_alternatif = $(this).attr('val-id');
            $('.modal-title').text("Yakin hapus Alternatif ini dari rekomendasi ?");
            $('.modal-body').hide();
            $('#id_alternatif').val(id_alternatif);
            $('#action').val("Hapus");
            $('#action').show();
            $('#operation').val("Delete");
            $('#alternatifModal').modal('show');
        });

        //ajax update id berita sesuai dgn saat memilih alternatif dalam modal rekomendasi-list
        $('.addAlternatif').click(function() {
            $.ajax({
                type: "POST",
                url: "ajax/update_idBerita_alternatif.php",
                data: {
                    idberita: id_berita,
                    id_alternatif: $(this).attr('val')
                }
            }).done(function(msg) {
                location.reload();
            });
        });

    });
</script>

<?php
include_once '../admin/footer.php';
?>