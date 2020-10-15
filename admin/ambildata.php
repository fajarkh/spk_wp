<?php
$host = "localhost";
$db_name = "spk_wp2";
$username = "root";
$password = "";

$conn = new mysqli($host, $username, $password, $db_name);
if ($conn->connect_error) {
    die("Connection Failed " . $conn->connect_error);
}
$id = $_GET['id'];
$response = array();
if ($id) {
    $query = "SELECT * FROM wp_macam WHERE id_kriteria = '$id'";
    $result = mysqli_query($conn,$query);
    if (!empty($result)) {
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_array($result)) {
                $response[] = array(
                    'value' => $row['nilai'],
                    'name' => $row['nama_macam']
                );
            }
            echo json_encode($response);
        }
    }
}
