<?php

$database = new Database();
$connection = $database->getConnection();

if (isset($_GET['id'])) {
      $id = $_GET['id'];
      $findSQL = "SELECT * FROM bagian WHERE id=?";
      $statement = $connection->prepare($findSQL);
      $statement->bindParam(1, $_GET['id']);
      $statement->execute();
      $row = $statement->fetch();

      if (isset($row['id'])) {
            if (isset($_POST['button_update'])) {
                  $validateSQL = "SELECT * FROM bagian WHERE nama_bagian = ? AND id != ?";
                  $statement = $connection->prepare($validateSQL);
                  $statement->bindParam(1, $_POST['nama_bagian']);
                  $statement->bindParam(2, $_GET['id']);
                  $statement->execute();
                  if ($statement->rowCount() > 0) {
?>
                        <div class="alert alert-danger alert-dismissable">
                              <button type="button" class="close" data-dismis="alert" aria-hidden="true">x</button>
                              <h5><i class="icon fas fa-ban"></i> Gagal</h5>
                              Nama Bagian sudah ada
                        </div>

            <?php
                  } else {
                        $id = htmlspecialchars($_POST['id']);
                        $namaBagian = htmlspecialchars($_POST['nama_bagian']);
                        $karyawanId = htmlspecialchars($_POST['karyawan_id']);
                        $lokasiId = htmlspecialchars($_POST['lokasi_id']);

                        $updateSQL = "UPDATE bagian SET nama_bagian = ?, karyawan_id = ?, lokasi_id = ? WHERE id = ?";
                        $statement = $connection->prepare($updateSQL);
                        $statement->bindParam(1, $namaBagian);
                        $statement->bindParam(2, $karyawanId);
                        $statement->bindParam(3, $lokasiId);
                        $statement->bindParam(4, $id);
                        if ($statement->execute()) {
                              $_SESSION['hasil'] = true;
                              $_SESSION['pesan'] = 'Berhasil ubah data';
                        } else {
                              $_SESSION['hasil'] = false;
                              $_SESSION['pesan'] = 'Gagal ubah data';
                        }
                        echo '<meta http-equiv="refresh" content="0;url=?page=bagianread">';
                  }
            }
            ?>
            <section class="content-header">
                  <div class="container-fluid">
                        <div class="row mb2">
                              <div class="col-sm-6">
                                    <h1>Ubah Data Bagian</h1>
                              </div>
                              <div class="col-sm-6">
                                    <ol class="breadcrumb float-sm-right">
                                          <li class="breadcrumb-item"><a href="?page=home">Home</a></li>
                                          <li class="breadcrumb-item"><a href="?page=bagianread">Bagian</a></li>
                                          <li class="breadcrumb-item active">Ubah Data</li>
                                    </ol>
                              </div>
                        </div>
                  </div>
            </section>
            <section class="content">
                  <div class="card">
                        <div class="card-header">
                              <h3 class="card-title">Tambah Bagian</h3>
                        </div>
                        <div class="card-body">
                              <form method="post">
                                    <div class="form-group">
                                          <label for="nama_bagian">Nama Bagian</label>
                                          <input type="text" class="form-control" name="nama_bagian" value="<?= $row['nama_bagian'] ?>">
                                    </div>
                                    <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                    <div class="form-group">
                                          <?php
                                          $selectSql = "SELECT * FROM karyawan";
                                          $statementKaryawan = $connection->prepare($selectSql);
                                          $statementKaryawan->execute();
                                          ?>
                                          <label for="karyawan_id">Kepala Bagian</label>
                                          <select name="karyawan_id" class="form-control">
                                                <option value="">-- Pilih Kepala Bagian --</option>
                                                <?php while ($karyawan = $statementKaryawan->fetch(PDO::FETCH_ASSOC)) : ?>
                                                      <option <?= ($row['karyawan_id'] == $karyawan['id']) ? 'selected' : '' ?> value="<?= $karyawan['id'] ?>"><?= $karyawan['nama_lengkap'] ?></option>
                                                <?php endwhile ?>
                                          </select>
                                    </div>
                                    <div class="form-group">
                                          <?php
                                          $selectSql = "SELECT * FROM lokasi";
                                          $statementLokasi = $connection->prepare($selectSql);
                                          $statementLokasi->execute();
                                          ?>
                                          <label for="lokasi_id">Kepala Bagian</label>
                                          <select name="lokasi_id" class="form-control">
                                                <option value="">-- Pilih Lokasi --</option>
                                                <?php while ($lokasi = $statementLokasi->fetch(PDO::FETCH_ASSOC)) : ?>
                                                      <option <?= ($row['lokasi_id'] == $lokasi['id']) ? 'selected' : '' ?> value="<?= $lokasi['id'] ?>"><?= $lokasi['nama_lokasi'] ?></option>
                                                <?php endwhile ?>
                                          </select>
                                    </div>
                                    <a href="?page=bagianread" class="btn btn-danger btn-sm float-right">Batal</a>
                                    <button name="button_update" type="submit" class="btn btn-success btn-sm float-right">
                                          <i class="fa fa-save"></i> Simpan
                                    </button>
                              </form>
                        </div>
                  </div>
            </section>
<?php
      } else {
            echo '<meta http-equiv="refresh" content="0;url=?page=jabatanread">';
      }
} else {
      echo '<meta http-equiv="refresh" content="0;url=?page=jabatanread">';
}
?>