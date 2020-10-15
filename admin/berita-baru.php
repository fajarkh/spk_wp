<?php
include_once '../admin/header.php';
if ($_POST) {

    include_once '../includes/berita.inc.php';
    $berita = new Berita($db);

    $berita->post_author = 1;
    $berita->post_title = $_POST['post_title'];
    $berita->post_desc = $_POST['post_description'];
    if (isset($_FILES['post_image']['name']) && !empty($_FILES['post_image']['name'])) {
        $berita->image = $_FILES['post_image'];
    }

    if ($berita->insert()) {
        ?>
                <script type="text/javascript">
                    window.onload = function() {
                        showStickySuccessToast();
                    };
                </script>
            <?php
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
                        <h3>Tambah Berita</h3>
                    </div>
                    <div class="col-md-6 text-right">
                        <h3>
                            <button type="button" onclick="location.href='../admin/berita.php'" class="btn btn-success">Kembali</button>
                        </h3>
                    </div>
                </div>

                <form method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="post_title">Judul Berita</label>
                        <input type="text" class="form-control" id="post_title" name="post_title" required>
                        <label for="post_description">Isi Berita</label>
                        <textarea class="form-control" id="post_description" name="post_description"></textarea>
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
                        <label for="post_image">Gambar Tajuk</label>
                        <input type="file" id="post_image" name="post_image" value="" />
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>

            </div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-2">
    </div>
</div>

<?php
include_once '../admin/footer.php';
?>