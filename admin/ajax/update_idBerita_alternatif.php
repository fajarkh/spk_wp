<?php

include "../../includes/config.php";
$config = new Config();
$conn = $config->getConnection();


if (isset($_POST['idberita']) && isset($_POST['id_alternatif'])) {
    if (!empty($_POST['idberita']) && !empty($_POST['id_alternatif'])) {
        $query = "UPDATE wp_alternatif SET id_berita = :idberita WHERE id_alternatif = :id_alternatif";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':idberita', $_POST['idberita']);
        $stmt->bindParam(':id_alternatif', $_POST['id_alternatif']);

        if ($stmt->execute()) {
            $status = 'success';
        } else {
            $status = 'fail';
        }
    } else {
        $status = 'fail2';
    }
} else {
    $status = 'fail3';
}
echo $status;
