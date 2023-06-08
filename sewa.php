<?php
// Koneksi ke database
$servername = "localhost";
$username = "lahorasm_root";
$password = "@Lgarin211";
$dbname = "lahorasm_root";
$conn = new mysqli($servername, $username, $password, $dbname);

// Periksa koneksi
if ($conn->connect_error) {
  die("Koneksi gagal: " . $conn->connect_error);
}

// Periksa permintaan HTTP yang diterima
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Periksa tindakan yang diterima
  if (isset($_POST['action'])) {
    $action = $_POST['action'];

    // Periksa aksi "Update"
    if ($action === "update") {
      // Tangkap data yang diperbarui
      $id = $_POST['id'];
      $nama_peminjam = $_POST['nama_peminjam'];
      $tanggal_pinjam = $_POST['tanggal_pinjam'];
      $tanggal_kembali = $_POST['tanggal_kembali'];
      $jenis_mobil = $_POST['jenis_mobil'];
      $total_harga = $_POST['total_harga'];
      $status_peminjaman = "PENDING";

      // Query untuk memperbarui data peminjaman mobil berdasarkan ID
      $sql = "UPDATE peminjaman_mobil SET nama_peminjam='$nama_peminjam', tanggal_pinjam='$tanggal_pinjam', tanggal_kembali='$tanggal_kembali', jenis_mobil='$jenis_mobil', total_harga='$total_harga', status_peminjaman='$status_peminjaman' WHERE id='$id'";

      if ($conn->query($sql) === TRUE) {
        // Redirect ke halaman utama
        header("Location: index.php");
        exit();
      } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
      }
    }
    // Periksa aksi "Delete"
    elseif ($action === "delete") {
      // Periksa apakah ada parameter ID yang diterima
      if (isset($_POST['id'])) {
        $id = $_POST['id'];

        // Query untuk menghapus data peminjaman mobil berdasarkan ID
        $sql = "DELETE FROM peminjaman_mobil WHERE id='$id'";

        if ($conn->query($sql) === TRUE) {
          // Redirect ke halaman utama
          header("Location: index.php");
          exit();
        } else {
          echo "Error: " . $sql . "<br>" . $conn->error;
        }
      }
    }
    // Periksa aksi "Approve"
    elseif ($action === "approve") {
      // Periksa apakah ada parameter ID yang diterima
      if (isset($_POST['id'])) {
        $id = $_POST['id'];

        // Query untuk mengupdate status peminjaman menjadi "Approved" berdasarkan ID
        $sql = "UPDATE peminjaman_mobil SET status_peminjaman='Approved' WHERE id='$id'";

        if ($conn->query($sql) === TRUE) {
          // Kirim status HTTP 200 OK
          http_response_code(200);
        } else {
          // Kirim status HTTP 500 Internal Server Error jika gagal
          http_response_code(500);
        }
      }
    }elseif ($action==="create"){
      // var_dump($_POST);die;
      $nama_peminjam = $_POST['nama_peminjam'];
      $tanggal_pinjam = $_POST['tanggal_pinjam'];
      $tanggal_kembali = $_POST['tanggal_kembali'];
      $jenis_mobil = $_POST['id'];
      $total_harga = $_POST['total_harga'];
      $status_peminjaman = "PENDING";

      // Query untuk memperbarui data peminjaman mobil berdasarkan ID
      $sql = "INSERT INTO peminjaman_mobil (nama_peminjam, tanggal_pinjam, tanggal_kembali, jenis_mobil, total_harga, status_peminjaman) VALUES ('$nama_peminjam', '$tanggal_pinjam', '$tanggal_kembali', '$jenis_mobil', '$total_harga', '$status_peminjaman')";

      if ($conn->query($sql) === TRUE) {
        // Redirect ke halaman utama
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
      } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
      }
    }
  }
}

// Query untuk mendapatkan data peminjaman mobil
$sql = "SELECT * FROM peminjaman_mobil";
$result = $conn->query($sql);

// Tutup koneksi
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Panel</title>
  <!-- Tambahkan link CSS untuk Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"> 
</head>
<body>
  <div class="container mt-4">
    <h2>Daftar Peminjaman Mobil</h2>
    <div class="mb-3">
      <div class="input-group">
        <input type="text" id="searchInput" class="form-control" placeholder="Cari...">
        <button type="button" class="btn btn-primary" onclick="searchData()">Cari</button>
      </div>
      <button type="button" class="btn btn-primary" onclick="sortByNama()">Urutkan berdasarkan Nama</button>
      <button type="button" class="btn btn-primary" onclick="sortByStatus()">Urutkan berdasarkan Status</button>
    </div>
    <table class="table table-striped">
      <thead>
        <tr>
          <th>Nama Peminjam</th>
          <th>Tanggal Pinjam</th>
          <th>Tanggal Kembali</th>
          <th>Jenis Mobil</th>
          <th>Total Harga</th>
          <th>Status Peminjaman</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php
        if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
            $id = NULL;
            $nama_peminjam = $row['nama_peminjam'];
            $tanggal_pinjam = $row['tanggal_pinjam'];
            $tanggal_kembali = $row['tanggal_kembali'];
            $jenis_mobil = $row['id'];
            $total_harga = $row['total_harga'];
            $status_peminjaman = $row['status_peminjaman'];
        ?>
            <tr>
              <td><?php echo $nama_peminjam; ?></td>
              <td><?php echo $tanggal_pinjam; ?></td>
              <td><?php echo $tanggal_kembali; ?></td>
              <td><?php echo $jenis_mobil; ?></td>
              <td><?php echo $total_harga; ?></td>
              <td><?php echo $status_peminjaman; ?></td>
              <td>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="approveCheck<?php echo $id; ?>" onchange="approveData(<?php echo $id; ?>)" <?php if ($status_peminjaman == 'Approved') echo 'checked'; ?>>
                  <label class="form-check-label" for="approveCheck<?php echo $id; ?>">Approve</label>
                </div>
                <button type="button" class="btn btn-primary btn-sm" onclick="updateData(<?php echo $id; ?>)">Update</button>
                <button type="button" class="btn btn-danger btn-sm" onclick="deleteData(<?php echo $id; ?>)">Hapus</button>
              </td>
            </tr>
        <?php
          }
        } else {
          echo '<tr><td colspan="7">Tidak ada data peminjaman mobil.</td></tr>';
        }
        ?>
      </tbody>
    </table>
  </div>

  <!-- Tambahkan script JavaScript untuk Bootstrap, pencarian, dan pengurutan -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    function searchData() {
      var input = document.getElementById('searchInput').value.toUpperCase();
      var table = document.querySelector('table');
      var tbody = table.querySelector('tbody');
      var rows = tbody.querySelectorAll('tr');

      rows.forEach(function(row) {
        var nama = row.cells[0].innerText.toUpperCase();
        var status = row.cells[5].innerText.toUpperCase();

        if (nama.includes(input) || status.includes(input)) {
          row.style.display = '';
        } else {
          row.style.display = 'none';
        }
      });
    }

    function sortByNama() {
      var table = document.querySelector('table');
      var tbody = table.querySelector('tbody');
      var rows = Array.from(tbody.querySelectorAll('tr'));

      rows.sort(function(a, b) {
        var namaA = a.cells[0].innerText.toUpperCase();
        var namaB = b.cells[0].innerText.toUpperCase();

        if (namaA < namaB) {
          return -1;
        }
        if (namaA > namaB) {
          return 1;
        }
        return 0;
      });

      tbody.innerHTML = '';
      rows.forEach(function(row) {
        tbody.appendChild(row);
      });
    }

    function sortByStatus() {
      var table = document.querySelector('table');
      var tbody = table.querySelector('tbody');
      var rows = Array.from(tbody.querySelectorAll('tr'));

      rows.sort(function(a, b) {
        var statusA = a.cells[5].innerText.toUpperCase();
        var statusB = b.cells[5].innerText.toUpperCase();

        if (statusA < statusB) {
          return -1;
        }
        if (statusA > statusB) {
          return 1;
        }
        return 0;
      });

      tbody.innerHTML = '';
      rows.forEach(function(row) {
        tbody.appendChild(row);
      });
    }

    function approveData(id) {
      var checkbox = document.getElementById('approveCheck' + id);
      var status = checkbox.checked ? 'Approved' : 'Pending';

      // Kirim permintaan HTTP POST menggunakan AJAX
      var xhr = new XMLHttpRequest();
      xhr.open('POST', 'index.php', true);
      xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
      xhr.onload = function() {
        if (xhr.status === 200) {
          console.log('Status peminjaman berhasil diubah.');
        } else {
          console.error('Terjadi kesalahan saat mengubah status peminjaman.');
        }
      };
      xhr.send('action=approve&id=' + id);
    }

    function updateData(id) {
      // Dapatkan data dari baris yang diklik
      var row = document.getElementById('row' + id);
      var nama_peminjam = row.cells[0].innerText;
      var tanggal_pinjam = row.cells[1].innerText;
      var tanggal_kembali = row.cells[2].innerText;
      var jenis_mobil = row.cells[3].innerText;
      var total_harga = row.cells[4].innerText;
      var status_peminjaman = row.cells[5].innerText;

      // Tampilkan formulir pengeditan
      var form = '<form method="post" action="index.php">' +
        '<input type="hidden" name="action" value="update">' +
        '<input type="hidden" name="id" value="' + id + '">' +
        '<input type="text" name="nama_peminjam" value="' + nama_peminjam + '">' +
        '<input type="text" name="tanggal_pinjam" value="' + tanggal_pinjam + '">' +
        '<input type="text" name="tanggal_kembali" value="' + tanggal_kembali + '">' +
        '<input type="text" name="jenis_mobil" value="' + jenis_mobil + '">' +
        '<input type="text" name="total_harga" value="' + total_harga + '">' +
        '<input type="text" name="status_peminjaman" value="' + status_peminjaman + '">' +
        '<button type="submit">Simpan</button>' +
        '</form>';

      // Ganti baris dengan formulir pengeditan
      row.innerHTML = form;
    }

    function deleteData(id) {
      // Kirim permintaan HTTP POST menggunakan AJAX
      var xhr = new XMLHttpRequest();
      xhr.open('POST', 'index.php', true);
      xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
      xhr.onload = function() {
        if (xhr.status === 200) {
          console.log('Data peminjaman berhasil dihapus.');
        } else {
          console.error('Terjadi kesalahan saat menghapus data peminjaman.');
        }
      };
      xhr.send('action=delete&id=' + id);
    }
  </script>
</body>
</html>
