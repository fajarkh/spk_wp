<?php
include_once '../includes/alternatif.inc.php';

include "../includes/config.php";
$config = new Config();
$db = $config->getConnection();
$vektor_s = isset($_GET['vektor_s']) ? $_GET['vektor_s'] : die('ERROR: Failed URL.');
$alternatif = new Alternatif($db);
$alternatif_rincian = new Alternatif($db);
$alternatif_list_rekomendasi = new Alternatif($db);

$alternatif->vektor_s = $vektor_s;
$alternatif->userRekomendasi();

if (is_null($alternatif->post_title)) {
    header("location:../pengunjung/not-found-rangking.php");
    die();
}

$alternatif_rincian->vektor_s = $vektor_s;
$stmt_rincianKriteria = $alternatif_rincian->readRincianKriteria($alternatif->id);
$stmt_listRekomendasi = $alternatif_list_rekomendasi->listRankRekomendasi($alternatif->vektor_v);
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Hasil Rekomendasi | SPK WP</title>

    <link rel="stylesheet" href="assets/rangking/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/rangking/css/fontawsom-all.min.css">
    <link rel="stylesheet" type="text/css" href="assets/rangking/css/style.css" />

    <style>
        .post_desc {
            margin-right: 18px;
        }
    </style>

</head>

<body>
    <div class="container-fluid overcover">
        <div class="container profile-box">
            <div class="row">
                <div class="col-md-4 left-co">
                    <div class="left-side">
                        <div class="profile-info">
                            <?php echo "<img width='195' height='195' src = '../uploads/" . $alternatif->post_image . "?t=" . time() . "' />" ?>
                            <h3><?php echo $alternatif->post_title ?></h3>
                        </div>
                        <h4 class="ltitle">Urutan Rangking Rekomendasi</h4>
                        <?php
                        $unique_post_title = array();
                        while ($row_listRekomendasi = $stmt_listRekomendasi->fetch(PDO::FETCH_ASSOC)) {
                            $unique_post_title[] = $row_listRekomendasi['post_title'];
                        }
                        $unique_post_title = array_unique($unique_post_title);
                        $num = 1;
                        foreach ($unique_post_title as $i) { ?>
                            <div class="contact-box pb0">
                                <span class="fa-stack fa-2x">
                                    <i class="fa fa-calendar-o fa-stack-2x"></i>
                                    <strong class="fa-stack-1x calendar-text"><?php echo $num; ?></strong>
                                </span>
                                <div class="detail">
                                    <?php echo $i; ?>
                                </div>
                            </div>
                        <?php
                            if ($num++ == 3) break;
                        } ?>

                    </div>
                </div>

                <div class="col-md-8 rt-div">
                    <div class="rit-cover">
                        <h2 class="rit-titl"><i class="fas fa-poll"></i>Hasil Rekomendasi</h2>
                        <div class="row no-margin">
                            <p>Berdasarkan kriteria yg dipilih jenis lele yg cocok adalah jenis ikan lele :</p>
                            <div class="hotkey">
                                <h1 class=""><?php echo $alternatif->post_title; ?></h1>
                                <!-- <small>Vector V : 0.99764545</small> -->
                            </div>
                        </div>

                        <!-- <h2 class="rit-titl"><i class="fas fa-briefcase"></i>Detail Rekomendasi</h2>
                        <div class="work-exp">
                            <h6>Ph Air <span>0-3</span></h6>
                            <i>Ikan Lele dumbo <b>sangat baik</b> hidup di Ph air 0-3, selain itu ikan ini dapat hidup pada Ph air lainnya dengan rincian berikut : </i>
                            <ul>
                                <li><i class="far fa-hand-point-right"></i> Ikan ini <b>sangat baik</b> pada Ph air 0-3 </li>
                                <li><i class="far fa-hand-point-right"></i> Ikan ini <b>cukup baik</b> pada Ph air 4-6  </li>
                                <li><i class="far fa-hand-point-right"></i> Ikan ini <b>kurang baik</b> pada Ph air 7-9 </li>
                            </ul>
                        </div> -->

                        <h2 class="rit-titl"><i class="fas fa-info-circle"></i>Rincian Pilihan Kriteria</h2>
                        <div class="education">
                            <ul class="row no-margin">
                                <?php while ($row_rincianKriteria = $stmt_rincianKriteria->fetch(PDO::FETCH_ASSOC)) { ?>
                                    <li class="col-md-6"><span><?php echo $row_rincianKriteria['nama_kriteria'] ?></span> <br>
                                        <?php echo $row_rincianKriteria['pilihan_kriteria'] ?></li>
                                <?php } ?>
                            </ul>
                        </div>

                        <h2 class="rit-titl"><i class="far fa-file-alt"></i>Deskripsi Ikan</h2>
                        <div class="about">
                            <div class="post_desc"><?php echo $alternatif->post_desc ?></div>

                            <div class="btn-ro row no-margin">
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

<script src="assets/rangking/js/jquery-3.2.1.min.js"></script>
<script src="assets/rangking/js/popper.min.js"></script>
<script src="assets/rangking/js/bootstrap.min.js"></script>
<script src="assets/rangking/js/script.js"></script>


</html>