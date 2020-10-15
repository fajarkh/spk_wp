<?php
include "../../includes/config.php";
$config = new Config();
$conn = $config->getConnection();

$idKriteria = explode(',', $_POST['idkriteria']);
$nilai = explode(',', $_POST['nilai']);
foreach ($idKriteria as $i => $idk) {
    $id = $_POST['id'];
    
    $query = "INSERT INTO wp_rangking (id_alternatif,id_kriteria, nilai_rangking,nilai_normalisasi) ";
    $query .= "VALUES  (:ia,:ik,:nr,0) ON  DUPLICATE KEY UPDATE nilai_rangking = :nr";
    $stmt = $conn->prepare($query);

    $stmt->bindParam(':nr', $nilai[$i]);
    $stmt->bindParam(':ia', $id);
    $stmt->bindParam(':ik', $idk);

    if ($stmt->execute()) {
        $status = 'success';
    } else {
        $status = 'fail';
    }
}
echo $status;
