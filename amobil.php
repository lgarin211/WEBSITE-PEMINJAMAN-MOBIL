<?php
// Koneksi ke database
$host = 'localhost'; // Ganti dengan host database Anda
$username = 'username'; // Ganti dengan username database Anda
$password = 'password'; // Ganti dengan password database Anda
$database = 'nama_database'; // Ganti dengan nama database Anda

$conn = mysqli_connect($host, $username, $password, $database);

// Fungsi untuk menyimpan data mobil baru ke database
function createMobil($data)
{
    global $conn;

    $platNomor = $data['platNomor'];
    $jenisMobil = $data['jenisMobil'];
    $linkGambar = $data['linkGambar'];
    $kondisi = $data['kondisi'];
    $harga = $data['harga'];
    $publish = isset($data['publishCheck']) ? 1 : 0;

    $query = "INSERT INTO mobil (plat_nomor, jenis_mobil, link_gambar, kondisi, harga, publish) VALUES ('$platNomor', '$jenisMobil', '$linkGambar', '$kondisi', $harga, $publish)";
    mysqli_query($conn, $query);
}

// Fungsi untuk memperbarui data mobil di database
function updateMobil($data)
{
    global $conn;

    $platNomor = $data['updatePlatNomor'];
    $jenisMobil = $data['updateJenisMobil'];
    $linkGambar = $data['updateLinkGambar'];
    $kondisi = $data['updateKondisi'];
    $harga = $data['updateHarga'];
    $publish = isset($data['updatePublishCheck']) ? 1 : 0;

    $query = "UPDATE mobil SET jenis_mobil='$jenisMobil', link_gambar='$linkGambar', kondisi='$kondisi', harga=$harga, publish=$publish WHERE plat_nomor='$platNomor'";
    mysqli_query($conn, $query);
}

// Fungsi untuk menghapus data mobil dari database
function deleteMobil($platNomor)
{
    global $conn;

    $query = "DELETE FROM mobil WHERE plat_nomor='$platNomor'";
    mysqli_query($conn, $query);
}

function getgatasewa()
{
    # code...
}

// Proses data yang dikirim dari JavaScript
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
        // Permintaan datang dari JavaScript (AJAX)
        $data = json_decode(file_get_contents('php://input'), true);

        if (isset($_GET['ac']) && $_GET['ac'] === 'create') {
            createMobil($data);
        } elseif (isset($_GET['ac']) && $_GET['ac'] === 'update') {
            updateMobil($data);
        } elseif (isset($_GET['ac']) && $_GET['ac'] === 'hapus') {
            $platNomor = $data['platNomor'];
            deleteMobil($platNomor);
        }
    }
}
?>
