<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: PUT");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include "../../includes/config.php";
$config = new Config();
$conn = $config->getConnection();
$id = $_GET['id'];

$response = array();
$query = "SELECT nama_alternatif, deskripsi FROM wp_alternatif WHERE id_alternatif=?";
$stmt = $conn->prepare($query);
$stmt->bindParam(1, $id);
$stmt->execute();
if ($stmt->rowCount() > 0) {
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $response = array(
            'nama_alternatif' => $row['nama_alternatif'],
            'deskripsi' => $row['deskripsi']
        );
    }
    
    $query2 = "SELECT id_alternatif, id_kriteria, nilai_rangking FROM wp_rangking WHERE id_alternatif=?";
    $stmt2 = $conn->prepare($query2);
    $stmt2->bindParam(1, $id);
    $stmt2->execute();
    if ($stmt2->rowCount() > 0) {
        $response["kriteria"] = array();
        while ($row = $stmt2->fetch(PDO::FETCH_ASSOC)) {
            $kriteria = array();
            $kriteria["id_kriteria"] = $row["id_kriteria"];
            $kriteria["id_kriteria"] = $row["id_kriteria"];
            $kriteria["nilai_rangking"] = $row["nilai_rangking"];

            array_push($response["kriteria"], $kriteria);
        }
        echo json_encode($response);
    } else {
        echo json_encode(['pesan' => 'tidak ada data']);
    }
} else {
    echo json_encode(['pesan' => 'tidak ada data']);
}
