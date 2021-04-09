<?php
include_once '../admin/header.php';
include_once '../includes/alternatif.inc.php';
$alternatif = new Alternatif($db);
$stmtAlternatif = $alternatif->readAllAdmin();
$count = $alternatif->countAll();

// include_once '../includes/rangking.inc.php';
// $rangking = new Rangking($db);


if (isset($_POST['hapus-contengan'])) {
    $imp = "('" . implode("','", array_values($_POST['checkbox'])) . "')";
    $result = $alternatif->hapusell($imp);
    if ($result) {
        ?>
        <script type="text/javascript">
            window.onload = function() {
                showSuccessToast();
                setTimeout(function() {
                    window.location.reload(1);
                    history.go(0)
                    location.href = location.href
                }, 5000);
            };
        </script>
    <?php
        } else {
            ?>
        <script type="text/javascript">
            window.onload = function() {
                showErrorToast();
                setTimeout(function() {
                    window.location.reload(1);
                    history.go(0)
                    location.href = location.href
                }, 5000);
            };
        </script>
<?php
    }
}
?>

<!-- <style>
    .load-spinner .modal-dialog {
        display: table;
        position: relative;
        margin: 0 auto;
        top: calc(53% - 54px);
    }

    .load-spinner .modal-dialog .modal-content {
        background-color: transparent;
        border: none;
    }

    .glyphicon.normal-right-spinner {
        font-size: 50px;
        -webkit-animation: glyphicon-spin-r 2s infinite linear;
        animation: glyphicon-spin-r 2s infinite linear;
    }

    @-webkit-keyframes glyphicon-spin-r {
        0% {
            -webkit-transform: rotate(0deg);
            transform: rotate(0deg);
        }

        100% {
            -webkit-transform: rotate(359deg);
            transform: rotate(359deg);
        }
    }

    @keyframes glyphicon-spin-r {
        0% {
            -webkit-transform: rotate(0deg);
            transform: rotate(0deg);
        }

        100% {
            -webkit-transform: rotate(359deg);
            transform: rotate(359deg);
        }
    }

    @-webkit-keyframes glyphicon-spin-l {
        0% {
            -webkit-transform: rotate(359deg);
            transform: rotate(359deg);
        }

        100% {
            -webkit-transform: rotate(0deg);
            transform: rotate(0deg);
        }
    }

    @keyframes glyphicon-spin-l {
        0% {
            -webkit-transform: rotate(359deg);
            transform: rotate(359deg);
        }

        100% {
            -webkit-transform: rotate(0deg);
            transform: rotate(0deg);
        }
    }
</style> -->

<!-- <div class="modal fade load-spinner" data-backdrop="static" data-keyboard="false" tabindex="-1">
    <div class="modal-dialog modal-sm">
        <div class="modal-content" style="text-align: center;">
            <span class="glyphicon glyphicon-repeat normal-right-spinner"></span>
            <h1>Memproses Data</h1>
        </div>
    </div>
</div>

<button type="button" class="btn btn-primary" onclick="modal();">Open and close in 3 secs</button> -->


<form method="post">
    <div class="row">
        <div class="col-md-6 text-left">
            <h4>Data Alternatif</h4>
        </div>
        <div class="col-md-6 text-right">
            <button type="submit" name="hapus-contengan" class="btn btn-danger">Hapus Contengan</button>
            <button type="button" onclick="location.href='alternatif-baru.php'" class="btn btn-primary">Tambah Data</button>
        </div>
    </div>
    <br />

    <table width="100%" class="table table-striped table-bordered" id="tabeldata">
        <thead>
            <tr>
                <th width="10px"><input type="checkbox" name="select-all" id="select-all" /></th>
                <th>Nama Alternatif</th>
                <th>Detail Kriteria</th>
                <th>Vektor S</th>
                <th>Vektor V</th>
                <th width="100px">Aksi</th>
            </tr>
        </thead>

        <tfoot>
            <tr>
                <th><input type="checkbox" name="select-all2" id="select-all2" /></th>
                <th>Nama Alternatif</th>
                <th>Detail Kriteria</th>
                <th>Vektor S</th>
                <th>Vektor V</th>
                <th>Aksi</th>
            </tr>
        </tfoot>

        <tbody>
            <?php
            $alternatif->analisaWP(1);
            $alternatif->analisaWP(1);
            while ($row = $stmtAlternatif->fetch(PDO::FETCH_ASSOC)) {
                ?>
                <tr>
                    <td style="vertical-align:middle;"><input type="checkbox" value="<?php echo $row['id_alternatif'] ?>" name="checkbox[]" /></td>
                    <td style="vertical-align:middle;"><?php echo $row['nama_alternatif'] ?></td>
                    <td style="vertical-align:middle;"><?php echo $row['macam'] ?></td>
                    <td style="vertical-align:middle;"><?php echo $row['vektor_s'] ?></td>
                    <td style="vertical-align:middle;"><?php echo $row['vektor_v'] ?></td>
                    <td class="text-center" style="vertical-align:middle;">
                        <a href="../admin/alternatif-ubah.php?id=<?php echo $row['id_alternatif'] ?>" class="btn btn-warning"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
                        <a href="../admin/alternatif-hapus.php?id=<?php echo $row['id_alternatif'] ?>" onclick="return confirm('Yakin ingin menghapus data')" class="btn btn-danger"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
                    </td>
                </tr>
            <?php
            }
            ?>
        </tbody>

    </table>
</form>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="../js/jquery-1.11.3.min.js"></script>

<!-- <script>
    function modal() {
        $('.modal').modal('show');
        setTimeout(function() {
            console.log('hejsan');
            $('.modal').modal('hide');
        }, 3000);
    }
</script> -->

<?php
include_once '../admin/footer.php';
?>