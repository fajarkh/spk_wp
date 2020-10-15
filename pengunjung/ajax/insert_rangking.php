<?php
include "../../includes/config.php";
$config = new Config();
$conn = $config->getConnection();

$idKriteria = explode(',', $_POST['idkriteria']);
$nilai = explode(',', $_POST['nilai']);
$id = $_POST['id'];
foreach ($idKriteria as $i => $idk) {
    $query = "INSERT INTO wp_rangking (id_alternatif, id_kriteria, nilai_rangking, nilai_normalisasi) VALUES (?, ?, ?, '0')";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(1, $id);
    $stmt->bindParam(2, $idk);
    $stmt->bindParam(3, $nilai[$i]);

    if ($stmt->execute()) {
        $query = "UPDATE wp_alternatif SET sts_identifikasi = 1 WHERE id_alternatif = $id";
        $stmt1 = $conn->prepare($query);
        $stmt1->execute();
        $status = 'success';
    } else {
        $status = 'fail';
        $err = $stmt->errorInfo();
        if (isset($err[1])) {
            if ($err[1] == 1062) {
                $status = 'duplicated';
            }
        }
    }
}
echo $status;

?>