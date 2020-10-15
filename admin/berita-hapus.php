<?php
include_once "../includes/config.php";
$database = new Config();
$db = $database->getConnection();

include_once '../includes/berita.inc.php';
$berita = new Berita($db);
$post_id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: missing ID.');
$berita->post_id = $post_id;
	
if($berita->delete()){
	echo "<script>location.href='../admin/berita.php';</script>";
} else{
	echo "<script>alert('Gagal Hapus Data');location.href='../admin/berita.php';</script>";
		
}
?>
