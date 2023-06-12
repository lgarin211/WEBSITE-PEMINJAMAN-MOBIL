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
  $query = "SELECT * FROM mobil WHERE Publish=1";
  $result = $conn->query($query);
  $result2=$result;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Mobil</title>
    <!-- Tambahkan link CSS untuk Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <nav class="container navbar navbar-expand-lg navbar-light bg-light fixed-top">
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
        <div class="row">
            <!-- while result -->
            <?php while($row = $result2->fetch_assoc()): ?>
            <div class="col-md-4">
                <div class="card">
                    <img src="<?=$row['link_gambar']?>" class="card-img-top" alt="Gambar Mobil <?=$row['id']?>" style="height: 300px;object-fit: scale-down;">
                    <div class="card-body">
                        <h5 class="card-title"><?=$row['jenis_mobil']."-".$row['kondisi']?></h5>
                        <p class="card-text">Harga: <?=$row['harga']?></p>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#CosMol<?=$row['id']?>">Pesan Sekarang</button>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
    </div>
    <?php foreach($result as $row): ?>
    <div class="modal fade" id="CosMol<?=$row['id']?>" tabindex="-1" aria-labelledby="exampleModalLabel<?=$row['id']?> "
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Form Pemesanan Mobil</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="http://localhost/WEBSITE-PEMINJAMAN-MOBIL/sewa.php" enctype="multipart/form-data"
                    method="POST" onsubmit="return confirm('Apakah Anda yakin ingin memesan mobil ini?')">
                    <input type="hidden" name="idcard" value="<?=$row['id']?>">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input type="text" class="form-control" id="nama" name="nama_peminjam"
                                placeholder="Masukkan Nama">
                        </div>
                        <div class="form-group">
                            <label for="tanggal_lahir">Tanggal Lahir</label>
                            <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir">
                        </div>
                        <div class="form-group">
                            <label for="tanggal_pinjam">Tanggal Pinjam</label>
                            <input type="date" class="form-control" id="tanggal_pinjam" name="tanggal_pinjam">
                        </div>
                        <div class="form-group">
                            <label for="tanggal_kembali">Tanggal Kembali</label>
                            <input type="date" class="form-control" id="tanggal_kembali" name="tanggal_kembali">
                        </div>
                        <input type="hidden" name="id" value="<?=$row['id']?>">
                        <input type="hidden" name="total_harga" value="" id="totalHarga">
                        <input type="hidden" name="action" value="create">
                    </div>
                    <div class="modal-footer">
                        <div class="total-harga"></div>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary" onclick="hitungTotalHarga()">Pesan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php endforeach;?>

    <footer class="text-body-secondary py-5 fixed-bottom">
        <div class="container">
            <p class="float-end mb-1">
                <a href="#">Back to top</a>
            </p>
            <p class="mb-1">2023 © PT.Afra Car Indonesia. All rights reserved.</p>
        </div>
    </footer>

    <!-- Tambahkan script JavaScript untuk Bootstrap dan perhitungan total harga -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script>
    function hitungTotalHarga() {
        var harga = 10000; // Harga mobil per hari
        var tanggalPinjam = new Date(document.getElementById('tanggal_pinjam').value);
        var tanggalKembali = new Date(document.getElementById('tanggal_kembali').value);
        var durasiPinjam = Math.floor((tanggalKembali - tanggalPinjam) / (1000 * 60 * 60 *
        24)); // Menghitung durasi pinjam dalam hari
        var totalHarga = harga * durasiPinjam;
        document.querySelector('.total-harga').innerHTML = 'Total Harga: $' + totalHarga.toLocaleString();
        document.querySelector('#totalHarga').value = totalHarga.toLocaleString();
    }
    </script>
</body>

</html>