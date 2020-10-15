<?php

include "../../includes/config.php";
$config = new Config();
$conn = $config->getConnection();

$id = $_POST['id'];
$query = "DELETE FROM wp_alternatif WHERE id_alternatif = ?";
		
		$stmt = $conn->prepare($query);
		$stmt->bindParam(1, $id);
        
        if ($stmt->execute()) {
            $status = 'success';
        } else {
            $status = 'fail';
        }
    echo $status;
