<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: PUT");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include "../../includes/config.php";
$config = new Config();
$conn = $config->getConnection();

$table_name = "wp_rangking";
$id = $_GET['id'];

$query = "SELECT id_alternatif, id_kriteria, nilai_rangking FROM " . $table_name . " WHERE id_alternatif=?";

$stmt = $conn->prepare($query);
$stmt->bindParam(1, $id);
$stmt->execute();
if ($stmt->rowCount() > 0) {
    $post_array = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $post_data = [
            'id_kriteria' => $row['id_kriteria'],
            'id_kriteria' => $row['id_kriteria'],
            'nilai_rangking' => $row['nilai_rangking']
        ];
        array_push($post_array, $post_data);
    }
    echo json_encode($post_array);
} else {
    echo json_encode(['pesan' => 'tidak ada data']);
}

?>