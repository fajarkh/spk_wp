<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include "../../includes/config.php";
$config = new Config();
$conn = $config->getConnection();

$status = '';
session_start();
$id_user = $_SESSION['id_user'];

if (isset($_POST['na']) && isset($_POST['d'])) {
    if (!empty($_POST['na']) && !empty($_POST['na'])) {
        $query = "INSERT INTO `wp_alternatif`(id_alternatif,id_pengguna,sts_identifikasi,nama_alternatif,deskripsi,vektor_s,vektor_v)";
        $query .= " VALUES(null,:id_pengguna,:sts_identifikasi,:nama_alternatif,:deskripsi,:vektor_s,:vektor_v)";

        $stmt = $conn->prepare($query);
        $stmt->bindValue(':id_pengguna', $id_user, PDO::PARAM_INT);
        $stmt->bindValue(':sts_identifikasi', 0, PDO::PARAM_INT);
        $stmt->bindValue(':nama_alternatif', htmlspecialchars(strip_tags($_POST['na'])), PDO::PARAM_STR);
        $stmt->bindValue(':deskripsi', htmlspecialchars(strip_tags($_POST['na'])), PDO::PARAM_STR);
        $stmt->bindValue(':vektor_s', 0, PDO::PARAM_INT);
        $stmt->bindValue(':vektor_v', 0, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $status = 'success';
        } else {
            $status = 'fail';
        }
    } else {
        $status = 'fail';
    }
} else {
    $status = 'fail';
}
echo $status;
