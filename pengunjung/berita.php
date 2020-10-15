<?php
include_once '../pengunjung/header.php';
include_once '../includes/berita.inc.php';
$berita = new Berita($db);
$stmt = $berita->readAll();
?>

<div class="container">
    <div class="row">
        <?php
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        ?>
            <div class="col-md-4">
                <div class="card mb-4 box-shadow">
                <?php echo "<img class='center-block' width='330' height='225' src = '../uploads/" . $row['post_image'] . "?t=" . time() . "' alt = '' style = 'padding-top:10px;' />" ?>
                    <div class="card-body" style="padding: 10px;">
                        <p class="card-text "><?php echo $row['post_title'] ?></p>
                            <div class="btn-group">
                                <a href="../pengunjung/single-berita.php?id=<?php echo $row['post_id'] ?>" class="btn btn-sm btn-outline-secondary" >Baca Selengkapnya</a>
                            </div>
                            <small class="text-muted"><?php echo convertDate($row['post_date']) ?></small>
                    </div>
                </div>
            </div>
        <?php
        }
        ?>
    </div>
</div>

<?php
include_once '../pengunjung/footer.php';
?>