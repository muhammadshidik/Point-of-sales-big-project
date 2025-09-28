<?php
// Mengimpor file koneksi ke database
require_once 'admin/controller/koneksi.php';

// Fungsi untuk meng-handle proses login
function loginController($email, $password)
{
    global $config; // Menggunakan variabel koneksi global

    // Query untuk mencari data user berdasarkan email yang tidak dihapus (deleted_at = 0)
    $queryLogin = mysqli_query($config, "SELECT * FROM user WHERE email='$email' AND deleted_at=0");

    // Mengecek apakah ada data user yang ditemukan
    if (mysqli_num_rows($queryLogin) > 0) {
        // Mengambil data user dalam bentuk array asosiatif
        $rowLogin = mysqli_fetch_assoc($queryLogin);

        // Mengecek apakah password yang dimasukkan sama dengan password di database
        if ($password == $rowLogin['password']) {
            // Menyimpan data user ke dalam session
            $_SESSION['name'] = $rowLogin['name'];
            $_SESSION['id'] = $rowLogin['id'];

            return true; // Login berhasil
        } else {
            return false; // Password salah
        }
    } else {
        return false; // User tidak ditemukan
    }
}

// Fungsi untuk mengecek apakah user sudah login
function loginValidation()
{
    // Jika session id belum diset, berarti belum login
    if (!isset($_SESSION['id'])) {
        return false;
    } else {
        return true; // Sudah login
    }
}

// Fungsi untuk mengubah nilai status order menjadi label HTML
// Letakkan fungsi ini di file koneksi.php atau file fungsi utama Anda


// ... ini adalah kode koneksi database Anda yang sudah ada ...
// ... mysqli_connect(...) ...


// ===============================================================
// PASTE FUNGSI LENGKAP INI DI DALAM FILE koneksi.php ANDA
// ===============================================================
function getOrderStatus($status_text) {
    switch ($status_text) {
        case "Diterima": 
            return '<span class="badge badge-pill bg-success">Diterima</span>';
        case "Ditolak": 
            return '<span class="badge badge-pill bg-danger">Ditolak</span>';
        default: 
        return '<span class="badge badge-pill bg-secondary">Tidak Diketahui</span>';
    }
}
function getStatusList($status_code)
{
    switch ($status_code) {
        case 0:
            return '<span class="badge badge-pill bg-success">Ya</span>';
        case 1:
            return '<span class="badge badge-pill bg-danger">Tidak</span>';
        default:
            return '<span class="badge badge-pill bg-secondary">Tidak diketahui</span>';
    }
}

function status($status_code)
{
    switch ($status_code) {
        case 0:
            return '<span class="badge badge-pill bg-success">Aktif</span>';
        case 1:
            return '<span class="badge badge-pill bg-danger">Tidak Aktif</span>';
        default:
            return '<span class="badge badge-pill bg-secondary">Tidak diketahui</span>';
    }
}

function karyawan($status_code)
{
    switch ($status_code) {
        case 0:
            return '<span class="badge badge-pill bg-success">Aktif</span>';
        case 1:
            return '<span class="badge badge-pill bg-Danger">Resign</span>';
        default:
            return '<span class="badge badge-pill bg-secondary">Tidak diketahui</span>';
    }
}
function pembayaran($status_code)
{
    switch ($status_code) {
        case "Tempo":
            return '<span class="badge badge-pill bg-success">Tempo</span>';
        case "Transfer":
            return '<span class="badge badge-pill bg-success">Transfer</span>';
        case "Tunai":
            return '<span class="badge badge-pill bg-success">Tunai</span>';
        default:
            return '<span class="badge badge-pill bg-success">Tidak Diketahui</span>';
    }
}

function utang($status_code)
{
    switch ($status_code) {
        case 0:
            return '<span class="badge badge-pill badge-danger">Belom Bayar</span>';
        case 1:
            return '<span class="badge badge-pill badge-warning">Bayar Sebagian</span>';
        case 2:
            return '<span class="badge badge-pill badge-success">Lunas</span>';
        case 3:
            return '<span class="badge badge-pill badge-primary">Kelebihan dana</span>';
        default:
            return '<span class="bg bg-secondary">Tidak Diketahui</span>';
    }
}

function metodePembayaran($status_code)
{
    switch ($status_code) {
        case 'cash':
            return '<span class="badge badge-pill badge-success">Tunai (Cash)</span>';
        case 'card':
            return '<span class="badge badge-pill badge-primary">Kartu (Debit/Kredit)</span>';
        case 'transfer':
            return '<span class="badge badge-pill badge-info">Transfer Bank</span>';
        case 'ewallet':
            return '<span class="badge badge-pill badge-warning">E-Wallet / Dompet Digital</span>';
        case 'qris':
            return '<span class="badge badge-pill badge-secondary">QRIS</span>';
        case 'tempo':
            return '<span class="badge badge-pill badge-danger">Tempo / Cicilan</span>';
        case 'gateway':
            return '<span class="badge badge-pill badge-dark">Online Payment Gateway</span>';
        default:
            return '<span class="badge badge-pill badge-light">Tidak Diketahui</span>';
    }
}

function statusTransaksi($status)
{
    switch ($status) {
        case 'selesai':
            return '<span class="badge badge-success">Selesai</span>';
        case 'pending':
            return '<span class="badge badge-warning">Pending</span>';
        case 'batal':
            return '<span class="badge badge-danger">Batal</span>';
        default:
            return '<span class="badge badge-secondary">Tidak Diketahui</span>';
    }
}
