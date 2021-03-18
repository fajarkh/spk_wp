<?php

include "../../includes/config.php";
$config = new Config();
$conn = $config->getConnection();

//perbaiki nama sposnya agar tidak error

if (isset($_POST['kt']) && isset($_POST['ktd']) && isset($_POST['id'])) {
    if (!empty($_POST['kt']) && !empty($_POST['id'])) {
        $query = "UPDATE wp_alternatif SET nama_alternatif = :kt, deskripsi = :ktd  WHERE id_alternatif = :id";
        $stmt = $conn->prepare($query);

        $stmt->bindParam(':kt', $_POST['kt']);
        $stmt->bindParam(':ktd', $_POST['ktd']);
        $stmt->bindParam(':id', $_POST['id']);

        if ($stmt->execute()) {
            $idKriteria = explode(',', $_POST['idkriteria']);
            $nilai = explode(',', $_POST['nilai']);
            foreach ($idKriteria as $i => $idk) {
                $id = $_POST['id'];

                $query2 = "INSERT INTO wp_rangking (id_alternatif,id_kriteria, nilai_rangking,nilai_normalisasi) ";
                $query2 .= "VALUES  (:ia,:ik,:nr,0) ON  DUPLICATE KEY UPDATE nilai_rangking = :nr";
                $stmt2 = $conn->prepare($query2);
                $stmt2->bindParam(':nr', $nilai[$i]);
                $stmt2->bindParam(':ia', $id);
                $stmt2->bindParam(':ik', $idk);

                if ($stmt2->execute()) {
                    $status = 'success';
                } else {
                    print_r($stmt->errorInfo());
                    $status = 'fail1';
                }
            }
        } else {
            $status = 'fail2';
        }
    } else {
        $status = 'fail3';
    }
} else {
    $status = 'fail4';
}
echo $status;
