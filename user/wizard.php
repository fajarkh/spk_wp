<?php
session_start();
include "../includes/config.php";
$config = new Config();
$db = $config->getConnection();

include_once '../includes/alternatif.inc.php';
$alternatif = new Alternatif($db);
$stmt_alternatif = $alternatif->readAllByUser(6);
$stmt_alternatifx = $alternatif->readAllByUser(6);
$stmt_alternatify = $alternatif->readAllByUser(6);;
// $stmt_alternatif_recom = $alternatif->readRekomendasi(6);
// $stmt_alternatif_recom2 = $alternatif->readRekomendasi2(6);

include_once '../includes/bobot.inc.php';
$bobot = new Bobot($db);
$stmt_bobot = $bobot->readAll();
$stmt_bobotx = $bobot->readAll();
$stmt_boboty = $bobot->readAll();
$stmt_bobotyx = $bobot->readAll();

include_once '../includes/rangking.inc.php';
$rangking = new Rangking($db);

while ($row1 = $stmt_alternatif->fetch(PDO::FETCH_ASSOC)) {
    $a = $row1['id_alternatif'];
    $stmt_rangkingr = $rangking->readR($a);
    while ($rowr = $stmt_rangkingr->fetch(PDO::FETCH_ASSOC)) {
        $b = $rowr['id_kriteria'];
        $tipe = $rowr['tipe_kriteria'];
        $bobot = $rowr['hasil_bobot'];

        if ($tipe == 'benefit') {
            $nor = pow($rowr['nilai_rangking'], $bobot);
        } else {
            $nor = pow($rowr['nilai_rangking'], -$bobot);
        }

        $rangking->ia = $a;
        $rangking->ik = $b;
        $rangking->nn4 = $nor;
        $rangking->normalisasi1();
    }

    $stmthasil = $rangking->readHasil1($a);
    $hasil = $stmthasil->fetch(PDO::FETCH_ASSOC);
    $hasil['bbn'];
    $rangking->has1 = $hasil['bbn'];
    $rangking->hasil1(); //save vector s

    $stmtmax = $rangking->readMax();
    $maxnr = $stmtmax->fetch(PDO::FETCH_ASSOC);
    $hasil['bbn'] / $maxnr['mnr1'];
    $rangking->has2 = $hasil['bbn'] / $maxnr['mnr1']; //kunci utama
    $rangking->hasil2(); //save vector v
}
