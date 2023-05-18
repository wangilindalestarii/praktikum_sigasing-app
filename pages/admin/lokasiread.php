<?php include_once "partials/cssdatatables.php" ?>
<div class="content-header">
      <div class="container-fluid">
            <div class="row mb-2">
                  <div class="col-sm-6">
                        <h1 class="m-0">Starter Page</h1>
                  </div>
                  <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                              <li class="breadcrumb-item"><a href="#">Home</a></li>
                              <li class="breadcrumb-item active">Starter Page</li>
                        </ol>
                  </div>
            </div>
      </div>
</div>
<div class="content">
      <div class="card">
            <div class="card-header">
                  <h3 class="card-title">Data Lokasi</h3>
                  <a href="?page=lokasicreate" class="btn btn-succes btn-sm float-right">
                        <i class="fa fa-plus-circle"></i> Tambah Data </a>
            </div>
            <div class="card-body">
                  <table id="mytable" class="table table-bordered table-hover">
                        <thead>
                              <tr>
                                    <th>No</th>
                                    <th>Nama Lokasi</th>
                                    <th>Opsi</th>
                              </tr>
                        </thead>
                        <tfoot>
                              <tr>
                                    <th>No</th>
                                    <th>Nama Lokasi</th>
                                    <th>Opsi</th>
                              </tr>
                        </tfoot>
                        <tbody>
                        </tbody>
                  </table>
            </div>
      </div>
</div>

<?php include_once "partials/scripts.php" ?>
<?php include_once "partials/scriptsdatatables.php" ?>
<script>
      $(function() {
            $('#mytable').DataTable()
      });
</script>