<?php
include_once '../admin/header.php';
include_once '../includes/rekomendasi.inc.php';

$rekomendasi = new Rekomendasi($db);

$post_id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: missing ID.');
$rekomendasi->post_id = $post_id;

$rekomendasi->readOne();

if ($_POST) {

    $rekomendasi->post_id = $_POST['post_id'];
    $rekomendasi->post_title = $_POST['post_title'];
    $rekomendasi->post_desc = $_POST['post_description'];
    if (isset($_FILES['post_image']['name']) && !empty($_FILES['post_image']['name'])) {
        $rekomendasi->image = $_FILES['post_image'];
    }

    if ($rekomendasi->update()) {
        echo "<script>location.href='../admin/rekomendasi.php'</script>";
    } else {
?>
        <script type="text/javascript">
            window.onload = function() {
                showStickyErrorToast();
            };
        </script>
<?php
    }
}
?>

<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-2"></div>
    <div class="col-xs-12 col-sm-12 col-md-8">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-6 text-left">
                        <h3>Ubah rekomendasi</h3>
                    </div>
                    <div class="col-md-6 text-right">
                        <h3>
                            <button type="button" onclick="location.href='../admin/rekomendasi.php'" class="btn btn-success">Kembali</button>
                        </h3>
                    </div>
                </div>

                <form method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="post_title">Nama Ikan</label>
                        <input type="text" class="form-control" id="post_title" name="post_title" value="<?php echo $rekomendasi->post_title ?>" required>
                        <label for="post_description">Detail</label>
                        <textarea class="form-control" id="post_description" name="post_description"><?php echo $rekomendasi->post_desc ?></textarea>
                        <script type="text/javascript">
                            if (typeof CKEDITOR == 'undefined') {
                                document.write(
                                    '<strong><span style="color: #ff0000">Error</span>: CKEditor not found</strong>.' +
                                    'This sample assumes that CKEditor (not included with CKFinder) is installed in' +
                                    'the "/ckeditor/" path. If you have it installed in a different place, just edit' +
                                    'this file, changing the wrong paths in the &lt;head&gt; (line 5) and the "BasePath"' +
                                    'value (line 32).');
                            } else {
                                var editor = CKEDITOR.replace('post_description');
                            }
                        </script>

                        <div class="form-group">
                            <table class="table table-borderless">
                                <tr>
                                    <td>
                                        <?php echo "<img src = '../uploads/" . $rekomendasi->image . "?t=" . time() . "' alt = '' style = 'width:600px;' />" ?>

                                    </td>
                                    <td>
                                        <label for="post_image">Gambar Tajuk Terbaru</label>
                                        <input type="file" id="post_image" name="post_image" value="" />
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <input type="hidden" id="post_id" name="post_id" value="<?php echo $rekomendasi->post_id ?>">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>

            </div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-2">
    </div>
</div>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="../js/jquery-1.11.3.min.js"></script>

<?php
include_once '../admin/footer.php';
?>