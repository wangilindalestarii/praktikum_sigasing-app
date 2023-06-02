<?php include_once "partials/cssdatatables.php" ?>

<div class="content-header">
      <div class="container-fluid">
            <?php if (isset($_SESSION['hasil'])) : ?>
                  <?php if ($_SESSION['hasil']) : ?>
                        <div class="alert alert-success alert-dismissable">
                              <button type="button" class="close" data-dismis="alert" aria-hidden="true">x</button>
                              <h5><i class="icon fas fa-check"></i> Berhasil</h5>
                              <?= $_SESSION['pesan'] ?>
                        </div>
                  <?php else : ?>
                        <div class="alert alert-danger alert-dismissable">
                              <button type="button" class="close" data-dismis="alert" aria-hidden="true">x</button>
                              <h5><i class="icon fas fa-ban"></i> Gagal</h5>
                              <?= $_SESSION['pesan'] ?>
                        </div>
                  <?php endif ?>
                  <?php unset($_SESSION['hasil'], $_SESSION['pesan']) ?>
            <?php endif ?>
            <div class="row mb-2">
                  <div class="col-sm-6">
                        <h1 class="m-0">Bagian</h1>
                  </div>
                  <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                              <li class="breadcrumb-item">
                                    <a href="?page=home"> Home</a>
                              </li>
                              <li class="breadcrumb-item">Bagian</li>
                        </ol>
                  </div>
            </div>
      </div>
</div>

<div class="content">
      <div class="card">
            <div class="card-header">
                  <h3 class="card-title">Data Bagian</h3>
                  <a href="?page=bagiancreate" class="btn btn-success btn-sm float-right">
                        <i class="fa fa-plus-circle"></i> Tambah Data</a>
            </div>
            <div class="card-body">
                  <table id="mytable" class="table table-bordered table-hover">
                        <thead>
                              <tr>
                                    <th>No</th>
                                    <th>Nama Bagian</th>
                                    <th>Nama Kepala Bagian</th>
                                    <th>Nama Lokasi Bagian</th>
                                    <th>Opsi</th>
                              </tr>
                        </thead>
                        <tfoot>
                              <tr>
                                    <th>No</th>
                                    <th>Nama Bagian</th>
                                    <th>Nama Kepala Bagian</th>
                                    <th>Nama Lokasi Bagian</th>
                                    <th>Opsi</th>
                              </tr>
                        </tfoot>
                        <tbody>
                              <?php
                              $database = new Database();
                              $db = $database->getConnection();
                              $selectSql = "SELECT B.*, K.nama_lengkap nama_kepala_bagian, L.nama_lokasi nama_lokasi_bagian FROM bagian B LEFT JOIN karyawan K ON B.karyawan_id = K.id LEFT JOIN lokasi L ON B.lokasi_id = L.id";
                              $stmt = $db->prepare($selectSql);
                              $stmt->execute();
                              $no = 1;
                              while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                              ?>
                                    <tr>
                                          <td><?= $no++ ?></td>
                                          <td><?= $row['nama_bagian'] ?></td>
                                          <td><?= $row['nama_kepala_bagian'] ?></td>
                                          <td><?= $row['nama_lokasi_bagian'] ?></td>
                                          <td>
                                                <a href="?page=bagianupdate&id=<?= $row['id'] ?>" class="btn btn-primary btn-sm mr-1">
                                                      <i class="fa fa-edit"></i> Ubah
                                                </a>
                                                <a href="?page=bagiandelete&id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onClick="javascript: return confirm('Konfirmasi data akan dihapus?');">
                                                      <i class="fa fa-trash"></i> Hapus
                                                </a>
                                          </td>
                                    </tr>
                              <?php
                              }
                              ?>

                        </tbody>
                  </table>
            </div>
      </div>
</div>