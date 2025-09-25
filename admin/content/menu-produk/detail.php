<?php
include 'admin/controller/koneksi.php';

// ambil id dari URL
$id = $_GET['id'];

// query produk detail
$queryDetail = mysqli_query($config, "SELECT * FROM produk WHERE id='$id'");
$rel = mysqli_fetch_assoc($queryDetail);

// ambil kategori produk tsb
$kategori_id = $rel['kategori_id'];

// query produk terkait berdasarkan kategori (tapi exclude id yang sama)
$queryRelated = mysqli_query($config, "SELECT * FROM produk WHERE kategori_id='$kategori_id' AND id!='$id' LIMIT 4");

// --- Logika PHP untuk Detail Produk ---

// Inisialisasi variabel untuk menampung data produk
$produk = null;

// Periksa apakah ada parameter 'id' di URL dan apakah nilainya valid
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id_produk = $_GET['id'];

    // Query untuk mengambil detail produk berdasarkan ID
    // Menggunakan Prepared Statement untuk mencegah SQL Injection
    $queryprodukDetail = "SELECT p.id, p.nama_produk, p.deskripsi, p.harga_jual, p.gambar, p.stok, p.kode_produk, k.nama_kategori, k.id as kategori_id
                          FROM produk p
                          JOIN kategori k ON p.kategori_id = k.id
                          WHERE p.id = ?";

    $rowprodukDetail = mysqli_prepare($config, $queryprodukDetail);

    if ($rowprodukDetail) {
        mysqli_stmt_bind_param($rowprodukDetail, "i", $id_produk); // "i" untuk integer
        mysqli_stmt_execute($rowprodukDetail);
        $result_produk_detail = mysqli_stmt_get_result($rowprodukDetail);

        // Ambil hasil kueri
        if ($result_produk_detail && mysqli_num_rows($result_produk_detail) > 0) {
            $produk = mysqli_fetch_assoc($result_produk_detail);
        }
        mysqli_stmt_close($rowprodukDetail);
    } else {
        // Log error jika prepared statement gagal
        error_log("Gagal menyiapkan statement untuk detail produk: " . mysqli_error($config));
    }
}


?>
<!-- CSS Deskripsi -->
<style>
    .note-box {
        border: 1px dashed #999;
        /* garis kotaknya */
        background: #fdfdfd;
        /* warna latar lembut */
        padding: 8px 12px;
        border-radius: 6px;
        font-size: 14px;
        color: #333;
        margin-top: 5px;
        position: relative;
    }

    .note-box::before {
        content: "📝 Deskripsi:";
        font-size: 13px;
        font-weight: 600;
        color: #555;
        display: block;
        margin-bottom: 4px;
    }
</style>

<!-- penyesuaian mode -->
<style>
    /* Default (Light mode) */
    :root {
        --breadcrumb-text: #333;
        --breadcrumb-separator: #888;
        --breadcrumb-active: #000;
    }

    /* Dark Mode (kalau pakai toggle manual) */
    [data-theme="dark"] {
        --breadcrumb-text: #ddd;
        --breadcrumb-separator: #aaa;
        --breadcrumb-active: #fff;
    }

    /* Kalau mau otomatis tanpa toggle (ikut sistem OS/browser) */
    @media (prefers-color-scheme: dark) {
        :root {
            --breadcrumb-text: #ddd;
            --breadcrumb-separator: #aaa;
            --breadcrumb-active: #fff;
        }
    }

    .bread-crumb {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
        font-size: 14px;
        align-items: center;
    }

    /* Link breadcrumb */
    .bread-crumb a {
        color: var(--breadcrumb-text);
        text-decoration: none;
        position: relative;
        padding-right: 16px;
        transition: color 0.3s ease;
    }

    /* Separator */
    .bread-crumb a::after {
        content: "›";
        /* bisa ganti jadi » atau "/" */
        position: absolute;
        right: 4px;
        color: var(--breadcrumb-separator);
    }

    /* Hover effect */
    .bread-crumb a:hover {
        text-decoration: underline;
        color: var(--breadcrumb-active);
    }

    /* Current page */
    .bread-crumb .current {
        font-weight: 600;
        color: var(--breadcrumb-active);
    }
</style>

<!-- CSS Produk Terkait -->
<style>
    /* === Produk Terkait Responsive Modern === */
    .related-section {
        padding: 60px 0;
        transition: background 0.3s ease, color 0.3s ease;
    }

    .related-section h2 {
        font-size: 2rem;
        font-weight: 700;
        text-align: center;
        margin-bottom: 40px;
        letter-spacing: 1px;
        transition: color 0.3s ease;
    }

    /* Card wrapper animasi awal */
    .product-card-wrapper {
        opacity: 0;
        transform: translateY(20px);
        transition: all 0.5s ease-out;
    }

    /* Card style */
    .product-card {
        border: none;
        border-radius: 18px;
        overflow: hidden;
        background: var(--card-bg);
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.08);
        transition: transform 0.3s ease, box-shadow 0.3s ease, background 0.3s ease;
    }

    .product-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
    }

    /* Image wrapper */
    .img-wrapper {
        overflow: hidden;
    }

    .img-wrapper img {
        transition: transform 0.5s ease;
    }

    .product-card:hover .img-wrapper img {
        transform: scale(1.08);
    }

    /* Produk title */
    .product-card h5 {
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 8px;
        color: var(--text-color);
        transition: color 0.3s ease;
    }

    /* Price */
    .price {
        font-size: 1rem;
        font-weight: 600;
        color: var(--price-color);
        transition: color 0.3s ease;
    }

    /* Button modern */
    .btn-glass {
        padding: 10px 22px;
        border: none;
        border-radius: 12px;
        background: var(--btn-bg);
        color: var(--btn-text);
        font-weight: 600;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .btn-glass:hover {
        background: var(--btn-hover-bg);
        color: var(--btn-hover-text);
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0, 123, 255, 0.25);
    }

    /* === Light Mode (default) === */
    :root {
        --card-bg: #fff;
        --text-color: #222;
        --price-color: #007bff;
        --btn-bg: rgba(0, 123, 255, 0.15);
        --btn-text: #007bff;
        --btn-hover-bg: #007bff;
        --btn-hover-text: #fff;
        --section-bg: #f8f9fa;
    }

    /* === Dark Mode (auto detect) === */
    @media (prefers-color-scheme: dark) {
        :root {
            --card-bg: #1e1e2e;
            --text-color: #f1f1f1;
            --price-color: #4dabf7;
            --btn-bg: rgba(77, 171, 247, 0.15);
            --btn-text: #4dabf7;
            --btn-hover-bg: #4dabf7;
            --btn-hover-text: #fff;
            --section-bg: #121212;
        }
    }

    .related-section {
        background: var(--section-bg);
    }
</style>

<!-- Detail Produk -->
<section class="">
    <div class="container p-t-100 mt-5">
        <h3 class="mb-5">Detail Produk</h3>
        <div class="bread-crumb flex-w p-l-25 p-r-15 p-t-30 p-lr-0-lg align-items-center" style="display: flex;">
            <a href="Beranda.php" class="breadcrumb-link">Beranda</a>
            <a href="Semua-Produk.php" class="breadcrumb-link">Produk</a>
            <a href="#" class="breadcrumb-link"><?php echo htmlspecialchars(string: $produk['nama_kategori']); ?></a>
            <span class="breadcrumb-current"><?php echo htmlspecialchars($produk['nama_produk']); ?></span>
        </div>
    </div>

    <div class="container px-4 px-lg-5 my-5">
        <div class="row gx-4 gx-lg-5 align-items-center">
            <div class="col-md-6"><img class="card-img-top mb-5 mb-md-0" src="admin/content/uploads/Foto/<?= $rel['gambar']; ?>" alt="..." /></div>
            <div class="col-md-6">
                <div class="small mb-1">Kode Produk : <?= $rel['kode_produk']; ?></div>
                <h1 class="display-5 fw-bolder"><?= $rel['nama_produk']; ?></h1>
                <div class="fs-5">
                    <span class="text-decoration-line-through">Harga : <?= $rel['harga_jual']; ?></span>
                </div>
                <div class="fs-5 mb-4">
                    <span class="text-decoration-line-through">Status Barang : <?php $status = getOrderStatus($rel['stok']) ?> <?= $status ?></span>
                </div>
                <div class="small mb-1 note-box">
                    <?= $rel['deskripsi']; ?>
                </div>
                <!-- Tombol Pesan -->
                <button onclick="window.open('?page=order')" class="btn btn-success ms-3 mt-5 flex-shrink-0" type="button">
                    Pesan Sekarang
                </button>
                
                <script>
                    function increaseQty() {
                        let qty = document.getElementById("inputQuantity");
                        qty.value = parseInt(qty.value) + 1;
                    }

                    function decreaseQty() {
                        let qty = document.getElementById("inputQuantity");
                        if (parseInt(qty.value) > 1) {
                            qty.value = parseInt(qty.value) - 1;
                        }
                    }
                </script>

            </div>
        </div>
    </div>
</section>

<!-- Related items section-->
<section class="py-5 card-body">
    <div class="container px-4 px-lg-5 mt-5">
        <h2 class="card-header fw-bolder mb-4 text-center">Produk Terkait</h2>
				<span class="stext-107 cl6 p-lr-25 text-center">
					Kategori: <?php echo $produk['nama_kategori']; ?>
				</span>
        <section class="product-gallery">
            <div class="gallery-container">
                <?php while ($rel = mysqli_fetch_assoc($queryRelated)) : ?>
                    <div class="card"
                        data-kategori="<?= $rel['kategori_id']; ?>"
                        style="width: 18rem; float: left; margin: 40px;">
                        <img src="admin/content/uploads/Foto/<?= $rel['gambar']; ?>"
                            alt="<?= $rel['nama_produk']; ?>"
                            class="card-img-top">
                        <div class="card-body">
                            <h5 class="card-title"><?= $rel['nama_produk']; ?></h5>
                            <p class="card-text">Rp <?= number_format($rel['harga_jual'], 0, ',', '.'); ?>,-</p>
                            <button onclick="window.open('?page=detail&id=<?= $rel['id']; ?>')" class="btn btn-warning">Detail</button>
                            <a href="#" class="btn btn-danger">Beli</a>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </section>
    </div>
</section>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const cards = document.querySelectorAll(".product-card-wrapper");

        const observer = new IntersectionObserver(
            (entries) => {
                entries.forEach((entry, index) => {
                    if (entry.isIntersecting) {
                        setTimeout(() => {
                            entry.target.style.opacity = "1";
                            entry.target.style.transform = "translateY(0)";
                        }, index * 150); // delay biar muncul bergelombang
                        observer.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.1
            }
        );

        cards.forEach((card) => observer.observe(card));
    });
</script>