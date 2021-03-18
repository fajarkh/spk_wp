<?php 
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: PUT");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

session_start();
$id_user = $_SESSION['id_user'];

include "../../includes/config.php";
$config = new Config();
$conn = $config->getConnection();

$query = "SELECT id_alternatif, nama_alternatif FROM wp_alternatif WHERE id_pengguna = 1 AND id_berita = 0";
$stmt = $conn->prepare($query);
$stmt->bindParam(1, $id_user);
$stmt->execute();
if ($stmt->rowCount() > 0) {
    $post_array = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $post_data = [
            'id' => $row['id_alternatif'],
            'text' => $row['nama_alternatif']
        ];
        array_push($post_array, $post_data);
    }
    echo json_encode($post_array);
} else {
    echo json_encode(['pesan' => 'tidak ada data']);
}
