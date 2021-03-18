<?php
include "../../includes/config.php";
$config = new Config();
$conn = $config->getConnection();

$kt = $_POST['kt'];
$ktd = $_POST['ktd'];

$query = "INSERT INTO wp_alternatif (id_alternatif, id_pengguna, sts_identifikasi, nama_alternatif, deskripsi, vektor_s, vektor_v) VALUES (null, 1, 1, ?, ?, 0, 0)";
$stmt = $conn->prepare($query);
$stmt->bindParam(1, $kt);
$stmt->bindParam(2, $ktd);

if ($stmt->execute()) {
    $idKriteria = explode(',', $_POST['idkriteria']);
    $nilai = explode(',', $_POST['nilai']);
    $id = $conn->lastInsertId();
    foreach ($idKriteria as $i => $idk) {
        $query = "INSERT INTO wp_rangking (id_alternatif, id_kriteria, nilai_rangking, nilai_normalisasi) VALUES (?, ?, ?, '0')";
        $stmt2 = $conn->prepare($query);
        $stmt2->bindParam(1, $id);
        $stmt2->bindParam(2, $idk);
        $stmt2->bindParam(3, $nilai[$i]);
        if ($stmt2->execute()) {
            $status = 'success';
        } else {
            $status = 'fail';
        }
    }
} else {
    $status = 'fail';
    $err = $stmt->errorInfo();
    print_r($err);
}
echo $status;
