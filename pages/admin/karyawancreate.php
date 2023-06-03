<?php
if (isset($_POST['button_create'])) {

    $database = new Database();
    $db = $database->getConnection();

    $validateSQL = "SELECT * FROM karyawan WHERE nik = ?";
    $stmt = $db->prepare($validateSQL);
    $stmt->bindParam(1, $nik);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
?>
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismis="alert" aria-hidden="true">x</button>
            <h5><i class="icon fas fa-ban"></i>Gagal</h5>
            Nik sama sudah ada
        </div>
        <?php
    } else {
        $validateSQL = "SELECT * FROM pengguna WHERE username = ?";
        $stmt = $db->prepare($validateSQL);
        $stmt->bindParam(1, $username);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
        ?>
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismis="alert" aria-hidden="true"></button>
                <h5><i class="icon fas fa-ban"></i>Gagal</h5>
                Username sama sudah ada
            </div>
            <?php
        } else {
            if ($_POST['password'] != $_POST['password_ulangi']) {
            ?>
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismis="alert" aria-hidden="true"></button>
                    <h5><i class="icon fas fa-ban"></i>Gagal</h5>
                    Password tidak sama
                </div>
<?php
            } else {
                $md5Password = md5($_POST['password']);

                $insertSql = "INSERT INTO pengguna VALUES (NULL, ?, ?, ?, NUL)";
                $stmt = $db->prepare($insertSql);
                $stmt->bindParam(1, $username);
                $stmt->bindParam(2, $md5Password);
                $stmt->bindParam(3, $peran);

                if ($stmt->execute()) {

                    $pengguna_id = $db->lastInsertId();

                    $insertKaryawanSql = "INSERT INTO karyawan VALUES (NULL, ?, ?, ?, ?, ?, ?)";
                    $stmtKaryawan = $db->prepare($insertKaryawanSql);
                    $stmtKaryawan->bindParam(1, $_POST['nik']);
                    $stmtKaryawan->bindParam(2, $_POST['nama_lengkap']);
                    $stmtKaryawan->bindParam(3, $_POST['handphone']);
                    $stmtKaryawan->bindParam(4, $_POST['email']);
                    $stmtKaryawan->bindParam(5, $_POST['tanggal_masuk']);
                    $stmtKaryawan->bindParam(6, $_POST['pengguna_id']);

                    if ($stmtKaryawan->execute()) {
                        $_SESSION['hasil'] = true;
                        $_SESSION['pesan'] = "Simpan Berhasil";
                    } else {
                        $_SESSION['hasil'] = false;
                        $_SESSION['pesan'] = "Gagal Simpan Data";
                    }
                } else {
                    $_SESSION['hasil'] = false;
                    $_SESSION['pesan'] = "Gagal Simpan Data";
                }
                echo "<meta http-equiv='refresh' content='0;url=?page=karyawanread'>";
            }
        }
    }
}

?>

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb2">
            <div class="col-sm-6">
                <h1>Tambah Data Karyawan</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="?page=home">Home</a></li>
                    <li class="breadcrumb-item"><a href="?page=karyawanread">Karyawan</a></li>
                    <li class="breadcrumb-item">Tambah Data</li>
                </ol>
            </div>
        </div>
    </div>
</section>




<section class="content">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Tambah Karyawan</h3>
        </div>
        <div class="card-body">
            <form method="POST">
                <div class="form-group">
                    <label for="nik">Nomor Induk Kayawan</label>
                    <input type="text" class="form-control" name="nik" id="nik">
                </div>
                <div class="form-group">
                    <label for="nama_lengkap">Nama Lengkap</label>
                    <input type="text" class="form-control" name="nama_lengkap" id="nama_lengkap">
                </div>
                <div class="form-group">
                    <label for="handphone">Handphone</label>
                    <input type="text" class="form-control" name="handphone" id="handphone">
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" name="email" id="email">
                </div>
                <div class="form-group">
                    <label for="tanggal_masuk">Tanggal Masuk</label>
                    <input type="date" class="form-control" name="tanggal_masuk" id="tanggal_masuk">
                </div>
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" name="username" id="username">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="text" class="form-control" name="password" id="password">
                </div>
                <div class="form-group">
                    <label for="passwordulangi">Password Ulangi</label>
                    <input type="text" class="form-control" name="passwordulangi" id="passwordulangi">
                </div>
                <div class="form-group">
                    <label for="peran">Peran</label>
                    <select class="form-control" name="peran" id="peran">
                        <option value="">Pilih Peran</option>
                        <option value="ADMIN">ADMIN</option>
                        <option value="USER">USER</option>
                    </select>
                </div>
                <div class="mt-3">
                    <a href="?page=lokasiread" class="btn btn-danger btn-sm float-right ml-3">
                        <i class="fa fa-times"></i>
                        Batal
                    </a>
                    <button type="submit" name="button_create" class="btn btn-success btn-sm float-right">
                        <i class="fa fa-save"></i>
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>

<?php include_once "partials/scripts.php" ?>