<?php

include "../../includes/config.php";
$config = new Config();
$conn = $config->getConnection();


if (isset($_POST['na']) && isset($_POST['ki']) && isset($_POST['id'])) {
    if (!empty($_POST['na']) && !empty($_POST['ki']) && !empty($_POST['id'])) {
        $query = "UPDATE wp_alternatif SET nama_alternatif = :na, deskripsi = :ki  WHERE id_alternatif = :id";
        $stmt = $conn->prepare($query);

        $stmt->bindParam(':na', $_POST['na']);
        $stmt->bindParam(':ki', $_POST['ki']);
        $stmt->bindParam(':id', $_POST['id']);

        if ($stmt->execute()) {
            $status = 'success';
        } else {
            $status = 'fail';
        }
    } else {
        $status = 'fail';
    }
} else {
    $status = 'fail3';
}
echo $status;
