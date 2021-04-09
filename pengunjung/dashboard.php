<?php
include_once '../pengunjung/header.php';
include_once '../includes/alternatif.inc.php';

$alternatif = new Alternatif($db); 
 $alternatif->analisaWP($user_id);
$alternatif->analisaWP($user_id);
?>

<div class="modal fade" id="IkanModal" tabindex="-1" role="dialog" aria-labelledby="IKanModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="IkanModalLabel">Identifikasi Baru</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="nama-ikan" class="col-form-label">Nama :</label>
                        <input type="text" class="form-control" id="nama-ikan">
                    </div>
                    <div class="form-group">
                        <label for="keterangan-ikan" class="col-form-label">Keterangan Tambahan :</label>
                        <textarea class="form-control" id="keterangan-ikan"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="ActionModalIkan">Tambah</button>
                <input type="hidden" name="operation" id="operation" />
                <input type="hidden" name="id-ikan" id="id-ikan" />
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card ">
                    <div class="header">
                        <h4 class="title">Data Rekomendasi</h4>
                        <p class="category">Data rekomendasi saat ini</p>
                    </div>
                    <div class="content">
                        <table class="table table-striped" id="tabeldata">
                            <thead>
                                <tr>
                                    <!-- <th width="10px" >Id</th> -->
                                    <th>Nama</th>
                                    <th>Status Identifikasi</th>
                                    <th width="120px" style="text-align: center;">Aksi</th>
                                </tr>
                            </thead>
                        </table>
                        <div class="footer">
                            <hr>
                            <div class="stats">
                                <button class="btn btn-default btn-block" data-toggle="modal" data-target="#IkanModal" modal-action="insert" data-backdrop="false">Tambah Data</button>
                            </div>
                            <div class="stats pull-right">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="embed-responsive embed-responsive-16by9" >
            <iframe class="embed-responsive-item" id="analisisFrame" src=""></iframe>
        </div>

    </div>

    <?php
    include_once '../pengunjung/footer.php';
    ?>