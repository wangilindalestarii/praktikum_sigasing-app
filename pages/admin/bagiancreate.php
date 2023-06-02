<section class="content-header">
      <div class="container-fluid">
            <?php
            $database = new Database();
            $connection = $database->getConnection();
            if (isset($_POST['button_create'])) {
                  $namaBagian = htmlspecialchars($_POST['nama_bagian']);
                  $karyawanId = htmlspecialchars($_POST['karyawan_id']);
                  $lokasiId = htmlspecialchars($_POST['lokasi_id']);

                  $validateSQL = "SELECT * FROM bagian WHERE nama_bagian = ?";
                  $statement = $connection->prepare($validateSQL);
                  $statement->bindParam(1, $namaBagian);
                  $statement->execute();
                  if ($statement->rowCount() > 0) {
            ?>
                        <div class="alert alert-danger alert-dismissable">
                              <button type="button" class="close" data-dismis="alert" aria-hidden="true">x</button>
                              <h5><i class="icon fas fa-ban"></i> Gagal</h5>
                              Nama bagian sudah ada
                        </div>
            <?php
                  } else {
                        $insertSQL = "INSERT INTO bagian SET nama_bagian = ?, karyawan_id = ?, lokasi_id = ?";
                        $statement = $connection->prepare($insertSQL);
                        $statement->bindParam(1, $namaBagian);
                        $statement->bindParam(2, $karyawanId);
                        $statement->bindParam(3, $lokasiId);
                        if ($statement->execute()) {
                              $_SESSION['hasil'] = true;
                              $_SESSION['pesan'] = 'Berhasil simpan data';
                        } else {
                              $_SESSION['hasil'] = false;
                              $_SESSION['pesan'] = 'Gagal simpan data';
                        }
                        echo '<meta http-equiv="refresh" content="0;url=?page=bagiancreate">';
                  }
            }
            ?>

            <div class="row mb2">
                  <div class="col-sm-6">
                        <h1>Tambah Data Bagian</h1>
                  </div>
                  <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                              <li class="breadcrumb-item"><a href="?page=home">Home</a></li>
                              <li class="breadcrumb-item"><a href="?page=bagianread">Bagian</a></li>
                              <li class="breadcrumb-item active">Tambah Data</li>
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
                              <input type="text" class="form-control" name="nama_bagian">
                        </div>
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
                                          <option value="<?= $karyawan['id'] ?>"><?= $karyawan['nama_lengkap'] ?></option>
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
                                          <option value="<?= $lokasi['id'] ?>"><?= $lokasi['nama_lokasi'] ?></option>
                                    <?php endwhile ?>
                              </select>
                        </div>
                        <a href="?page=bagianread" class="btn btn-danger btn-sm float-right">Batal</a>
                        <button name="button_create" type="submit" class="btn btn-success btn-sm float-right">
                              <i class="fa fa-save"></i> Simpan
                        </button>
                  </form>
            </div>
      </div>
</section>