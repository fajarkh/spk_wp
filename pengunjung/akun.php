<?php
include_once '../pengunjung/header.php';
include_once '../includes/login.inc.php';
?>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <!-- <div class="header">
                        <h4 class="title">Edit Profile</h4>
                    </div> -->
                    <div class="content">
                        <form>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Nama Pengguna</label>
                                        <input type="text" class="form-control" placeholder="Username" value="<?php echo $_SESSION['username'] ?>" name="username" disabled>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Alamat Email</label>
                                        <input type="email" class="form-control" placeholder="Email" name="email" value="<?php echo $_SESSION['email'] ?>" disabled>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Nama Depan</label>
                                        <input type="text" class="form-control" value="<?php echo $_SESSION['first_name'] ?>" name="first_name" disabled>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Nama Belakang</label>
                                        <input type="text" class="form-control" value="<?php echo $_SESSION['last_name'] ?>" name="last_name" disabled>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Alamat</label>
                                        <input type="text" class="form-control" placeholder="Alamat" value="" name="address" disabled>
                                    </div>
                                </div>
                            </div>
                            <!-- <button type="submit" class="btn btn-info btn-fill pull-right">Perbaharui Informasi</button> -->
                            <div class="clearfix"></div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-user">
                    <div class="image">
                        <img src="../images/bg2.jpg" alt="..." />
                    </div>
                    <div class="content">
                        <div class="author">
                            <a href="#">
                                <img class="avatar border-gray" src="../images/avatar.jpg" alt="..." />

                                <h4 class="title"><?php echo $_SESSION['first_name'].' '.$_SESSION['last_name']  ?><br />
                                    <small><?php echo $_SESSION['email'] ?> </small>
                                </h4>
                            </a>
                        </div>
                    </div>
                    <hr>
                    <div class="text-center">
                    <a href="../logout.php" class="btn btn-info btn-fill">Logout</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<?php
include_once '../pengunjung/footer.php';
?>