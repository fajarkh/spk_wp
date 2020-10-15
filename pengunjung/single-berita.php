<?php
include_once '../pengunjung/header.php';
include_once '../includes/berita.inc.php';

$berita = new Berita($db);
$post_id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: missing ID.');
$berita->post_id = $post_id;

$berita->readOne();
?>
<!-- Page Content -->
<div class="container">

    <div class="row">

        <!-- Title -->
        <h2 class="mt-4"><?php echo $berita->post_title ?></h1>

            <!-- Date/Time -->
            <p>Di posting pada <?php echo convertDate($berita->post_date) ?></p>

            <hr>

            <!-- Preview Image -->
            <?php echo "<img width='100%' height='500' src = '../uploads/" . $berita->image . "?t=" . time() . "' />" ?>

            <hr>

            <!-- Post Content -->
            <?php echo $berita->post_desc ?>

            <hr>

    </div>
</div>

<?php
include_once '../pengunjung/footer.php';
?>