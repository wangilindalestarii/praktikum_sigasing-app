<?php
if (isset($_GET['id'])) {

      $database = new Database();
      $db = $database->getConnection();

      $id = $_GET['id'];
      $findSQL = "SELECT * FROM karyawan WHERE id=?";
      $stmt = $db->prepare($findSQL);
      $stmt->bindParam(1, $_GET['id']);
      $stmt->execute();
      $row = $stmt->fetch();
      if (isset($row['id'])) {
            if (isset($_POST['button_update'])) {

                  $database = new Database();
                  $db = $database->getConnection();

                  $validateSQL = "SELECT * FROM karyawan where nik=? AND id != ?";
                  $stmt = $db->prepare($validateSQL);
                  $stmt->bindParam(1, $_POST['nik']);
                  $stmt->bindParam(2, $_POST['id']);
                  $stmt->execute();
                  if ($stmt->rowCount() > 0) {
?>
                        <div class="alert alert-danger alert-dismissible">
                              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                              <h5><i class="icon fas-ban"></i> Gagal</h5>
                              NIK Sudah Ada
                        </div>
            <?php
                  } else {
                        $md5Password = md5($_POST['password']);

                        $insertSQL = "UPDATE pengguna SET id=NULL, username=?, password=?, peran=?, login_terakhir=NULL";
                        $stmt = $db->prepare($insertSQL);
                        $stmt->bindParam(1, $_POST['username']);
                        $stmt->bindParam(2, $md5Password);
                        $stmt->bindParam(3, $_POST['peran']);

                        if ($stmt->execute()) {

                              $pengguna_id = $db->lastInsertId();

                              $updateSQL = "UPDATE karyawan SET nik = ?, nama_lengkap=?, handphone=?, email=?, tanggal_masuk=?  WHERE id=?";
                              $stmt = $db->prepare($updateSQL);
                              $stmt->bindParam(1, $_POST['nik']);
                              $stmt->bindParam(2, $_POST['nama_lengkap']);
                              $stmt->bindParam(3, $_POST['handphone']);
                              $stmt->bindParam(4, $_POST['email']);
                              $stmt->bindParam(5, $_POST['tanggal_masuk']);
                              $stmt->bindParam(6, $pengguna_id);
                              if ($stmt->execute()) {
                                    $_SESSION['hasil'] = true;
                                    $_SESSION['pesan'] = "Berhasil Simpan Data";
                              } else {
                                    $_SESSION['hasil'] = true;
                                    $_SESSION['pesan'] = "Gagal Simpan Data";
                              }
                              echo "<meta http-equiv='refresh' content='0;url=?page=karyawanread'>";
                        }
                  }
            }
            ?>

            <div class="content-header">
                  <div class="container-fluid">
                        <div class="row mb-2">
                              <div class="col-sm-6">
                                    <h1>Ubah Data Karyawan</h1>
                              </div>
                              <div class="col-sm-6">
                                    <ol class="breadcrumb float-sm-right">
                                          <li class="breadcrumb-item">
                                                <a href="?page=home">Home</a>
                                          </li>
                                          <li class="breadcrumb-item">
                                                <a href="?page=karyawanread"> Karyawan</a>
                                          </li>
                                          <li class="breadcrumb-item active">
                                                Ubah Data
                                          </li>
                                    </ol>
                              </div>
                        </div>
                  </div>
            </div>

            <section class="content">
                  <div class="card">
                        <div class="card-header">
                              <h3 class="card-title">Ubah Karyawan</h3>
                        </div>
                        <div class="card-body">
                              <form method="POST">
                                    <div class="form-group">
                                          <label for="nik">Nomor Induk Karyawan</label>
                                          <input type="hidden" class="form-control" name="id" value="<?php echo $row['id'] ?>">
                                          <input type="text" class="form-control" name="nik" value="<?php echo $row['nik'] ?>">
                                    </div>
                                    <div class="form-group">
                                          <label for="nama_lengkap">Nama Lengkap</label>
                                          <input type="hidden" class="form-control" name="id" value="<?php echo $row['id'] ?>">
                                          <input type="text" class="form-control" name="nama_lengkap" value="<?php echo $row['nama_lengkap'] ?>">
                                    </div>
                                    <div class="form-group">
                                          <label for="handphone">Handphone</label>
                                          <input type="hidden" class="form-control" name="id" value="<?php echo $row['id'] ?>">
                                          <input type="text" class="form-control" name="handphone" value="<?php echo $row['handphone'] ?>">
                                    </div>
                                    <div class="form-group">
                                          <label for="email">Email</label>
                                          <input type="hidden" class="form-control" name="id" value="<?php echo $row['id'] ?>">
                                          <input type="text" class="form-control" name="email" value="<?php echo $row['email'] ?>">
                                    </div>
                                    <div class="form-group">
                                          <label for="tanggal_masuk">Tanggal Masuk</label>
                                          <input type="hidden" class="form-control" name="id" value="<?php echo $row['id'] ?>">
                                          <input type="date" class="form-control" name="tanggal_masuk" value="<?php echo $row['tanggal_masuk'] ?>">
                                    </div>
                                    <div class="form-group">
                                          <label for="username">Username</label>
                                          <input type="hidden" class="form-control" name="id" value="<?php echo $row['id'] ?>">
                                          <input type="date" class="form-control" name="username" value="<?php echo $row['username'] ?>">
                                    </div>
                                    <div class="form-group">
                                          <label for="tanggal_masuk">Tanggal Masuk</label>
                                          <input type="hidden" class="form-control" name="id" value="<?php echo $row['id'] ?>">
                                          <input type="date" class="form-control" name="tanggal_masuk" value="<?php echo $row['tanggal_masuk'] ?>">
                                    </div>

                                    <a href="?page=karyawanread" class="btn btn-danger btn-sm float-right">
                                          <i class="fa fa-times"></i> Batal
                                    </a>
                                    <button type="submit" name="button_update" class="btn btn-success btn-sm float-right">
                                          <i class="fa fa-save"></i> Simpan
                                    </button>
                              </form>
                        </div>
                  </div>
            </section>
<?php
      } else {
            echo "<meta http-equiv='refresh' content='0;url=?page=lokasiread'>";
      }
} else {
      echo "<meta http-equiv='refresh' content='0;url=?page=lokasiread'>";
}
?>