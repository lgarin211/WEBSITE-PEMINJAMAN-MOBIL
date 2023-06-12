<?php
  $host = '103.219.251.244'; // Ganti dengan host database Anda
  $username = 'lahorasm_root'; // Ganti dengan username database Anda
  $password = '@Lgarin211'; // Ganti dengan password database Anda
  $database = 'lahorasm_root'; // Ganti dengan nama database Anda

  // $host = 'localhost'; // Ganti dengan host database Anda
  // $username = 'root'; // Ganti dengan username database Anda
  // $password = ''; // Ganti dengan password database Anda
  // $database = 'sewamobil'; // Ganti dengan nama database Anda

  $conn = mysqli_connect($host, $username, $password, $database);
  $result;
  function dd($data)
  {
    var_dump($data);die;
  }

  if(!empty($_GET)&&$_GET['ac']=='true'){
    $platNomor = $_GET['platNomor'];
    $jenisMobil = $_GET['jenisMobil'];
    $linkGambar = $_GET['linkGambar'];
    $kondisi = $_GET['kondisi'];
    $harga = $_GET['harga'];
    $publish = isset($_GET['publishCheck']) ? 1 : 0;
    $query = "INSERT INTO mobil (plat_nomor, jenis_mobil, link_gambar, kondisi, harga, publish) VALUES ('$platNomor', '$jenisMobil', '$linkGambar', '$kondisi', $harga, $publish)";
    mysqli_query($conn, $query);
    // back to last page
    header('Location: ' . $_SERVER['HTTP_REFERER']);
  }else if (!empty($_GET) && $_GET['ac'] == 'update') {
    $updatePlatNomor = $_GET['updatePlatNomor'];
    $updateJenisMobil = $_GET['updateJenisMobil'];
    $updateLinkGambar = $_GET['updateLinkGambar'];
    $updateKondisi = $_GET['updateKondisi'];
    $updateHarga = $_GET['updateHarga'];
    $updatePublish = isset($_GET['updatePublishCheck']) ? 1 : 0;

    $query = "UPDATE mobil SET jenis_mobil = '$updateJenisMobil', link_gambar = '$updateLinkGambar', kondisi = '$updateKondisi', harga = $updateHarga, publish = $updatePublish WHERE plat_nomor = '$updatePlatNomor'";
    $a1=mysqli_query($conn, $query);
    // back to last page
    header('Location: ' . $_SERVER['HTTP_REFERER']);
  }else{
    if(!empty($_GET)&&$_GET['ac']=='dell'){
      $id = $_GET['id'];
      $query = "DELETE FROM mobil WHERE id = $id";
      mysqli_query($conn, $query);
      // back to last page
      header('Location: ' . $_SERVER['HTTP_REFERER']);
    }
  }

  $query = "SELECT * FROM mobil";
  $result = $conn->query($query);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Data Mobil</title>
    <!-- Tambahkan link CSS untuk Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <nav class="container navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand " href="#">Daftar Mobil</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="./index.php">Beranda</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./sewa.php">Daftar Sewa</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./mobil.php">Daftar Mobil</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container mt-4">
        <h2>Data Mobil</h2>
        <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createModal"> Create
            Data Baru </button>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Plat Nomor</th>
                    <th>Jenis Mobil</th>
                    <th>Link Gambar</th>
                    <th>Deskripsi</th>
                    <th>Harga</th>
                    <th>Publish</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody> <?php
        if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
            // dd($row);
            $id = $row['id'];
            $plat_nomor = $row['plat_nomor'];
            $jenis_mobil = $row['jenis_mobil'];
            $link_gambar = $row['link_gambar'];
            $kondisi = $row['kondisi'];
            $harga = $row['harga'];
            $publish = $row['publish'];
        ?> <tr>
                    <td> <?=$plat_nomor?> </td>
                    <td> <?=$jenis_mobil?> </td>
                    <td>
                        <img src="
											<?=$link_gambar?>" alt="" width="100px">
                    </td>
                    <td> <?=$kondisi?> </td>
                    <td> <?=$harga?> </td>
                    <td> <?=$publish?> </td>
                    <td>
                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                            data-bs-target="#updateModal<?=$id?>">
                            Update
                        </button>
                        <a href="?id=<?=$id?>&ac=dell" class="btn btn-danger btn-sm">
                            Hapus
                        </a>
                    </td>
                </tr>
                <!-- Modal Update Data <?=$id?> -->
                <div class="modal fade" id="updateModal<?=$id?>" tabindex="-1"
                    aria-labelledby="updateModalLabel<?=$id?>" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="updateModalLabel">Update Data</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <form action="?ac=update" method="get">
                                <input type="hidden" name="ac" value="update">
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="updatePlatNomor" class="form-label">Plat Nomor</label>
                                        <input type="text" class="form-control" id="updatePlatNomor"
                                            value="<?=$plat_nomor?>" name="updatePlatNomor" readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label for="updateJenisMobil" class="form-label">Jenis Mobil</label>
                                        <input type="text" class="form-control" id="updateJenisMobil"
                                            value="<?=$jenis_mobil?>" name="updateJenisMobil">
                                    </div>
                                    <div class="mb-3">
                                        <label for="updateLinkGambar" class="form-label">Link Gambar</label>
                                        <input type="text" class="form-control" id="updateLinkGambar"
                                            value="<?=$link_gambar?>" name="updateLinkGambar">
                                    </div>
                                    <div class="mb-3">
                                        <label for="updateKondisi" class="form-label">Deskripsi</label><br>
                                        <textarea name="updateKondisi" name="form-control" id="updateKondisi" cols="50"
                                            rows="10"><?=$kondisi?></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="updateHarga" class="form-label">Harga</label>
                                        <input type="text" class="form-control" id="updateHarga" value="<?=$harga?>"
                                            name="updateHarga">
                                    </div>
                                    <div class="mb-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="updatePublishCheck"
                                                name="updatePublishCheck">
                                            <label class="form-check-label" for="updatePublishCheck">Publish</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div> <?php
        }
        } else {
          echo '
																<tr>
																	<td colspan="7">Tidak ada data peminjaman mobil.</td>
																</tr>';
        }
        ?>
                <!-- Tambahkan baris lain sesuai dengan data yang ada -->
            </tbody>
        </table>
    </div>
    <!-- Modal Create Data -->
    <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createModalLabel">Create Data Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="?ac=true" method="get">
                    <input type="hidden" name="ac" value="true">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="platNomor" class="form-label">Plat Nomor</label>
                            <input type="text" class="form-control" id="platNomor" name="platNomor">
                        </div>
                        <div class="mb-3">
                            <label for="jenisMobil" class="form-label">Jenis Mobil</label>
                            <input type="text" class="form-control" id="jenisMobil" name="jenisMobil">
                        </div>
                        <div class="mb-3">
                            <label for="linkGambar" class="form-label">Link Gambar</label>
                            <input type="text" class="form-control" id="linkGambar" name="linkGambar">
                        </div>
                        <div class="mb-3">
                            <label for="kondisi" class="form-label">Kondisi</label>
                            <input type="text" class="form-control" id="kondisi" name="kondisi">
                        </div>
                        <div class="mb-3">
                            <label for="harga" class="form-label">Harga</label>
                            <input type="text" class="form-control" id="harga" name="harga">
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="publishCheck" name="publishCheck">
                                <label class="form-check-label" for="publishCheck">Publish</label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Tambahkan script JavaScript untuk Bootstrap dan logika aksi -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>