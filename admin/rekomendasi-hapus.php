<?php
include_once "../includes/config.php";
$database = new Config();
$db = $database->getConnection();

include_once '../includes/rekomendasi.inc.php';
$rekomendasi = new Rekomendasi($db);
$post_id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: missing ID.');
$rekomendasi->post_id = $post_id;
	
if($rekomendasi->delete()){
	echo "<script>location.href='../admin/rekomendasi.php';</script>";
} else{
	echo "<script>alert('Gagal Hapus Data');location.href='../admin/rekomendasi.php';</script>";
		
}
?>
