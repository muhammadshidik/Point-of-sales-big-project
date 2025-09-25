<?php
include 'admin/controller/koneksi.php';

// Ambil semua data produk
$queryProduk = mysqli_query($config, "SELECT * FROM produk");

// Ambil kategori
$queryKategori = "SELECT * FROM kategori ORDER BY id DESC";
$resultKategori = mysqli_query($config, $queryKategori);

// Ambil banner
$query = "SELECT * FROM banner ORDER BY id DESC";
$result = mysqli_query($config, $query);
?>

<!-- Header Carousel Modern -->
<header class="hero-carousel">
    <?php while ($rowBanner = mysqli_fetch_assoc($result)) : ?>
    <div class="carousel-slide active" style="background-image: url('admin/content/uploads/Foto/<?= $rowBanner['gambar'] ?: 'default-food.jpg'; ?>')">
    </div>
    <?php endwhile; ?>
    <!-- Dot indicators -->
    <div class="carousel-dots"></div>
</header>

<style>
  /* ======================
   HERO CAROUSEL
====================== */
.hero-carousel {
    position: relative;
    width: 100%;
    height: 60vh;
    max-height: 400px;
    overflow: hidden;
    border-radius: 12px;
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.25);
}

.carousel-slide {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-size: cover;
    background-position: center;
    opacity: 0;
    transition: opacity 1s ease-in-out;
    display: flex;
    align-items: center;
    justify-content: center;
}

.carousel-slide.active {
    opacity: 1;
}

.carousel-dots {
    position: absolute;
    bottom: 12px;
    left: 50%;
    transform: translateX(-50%);
    display: flex;
    gap: 8px;
}

.carousel-dots span {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.5);
    cursor: pointer;
    transition: all 0.3s ease;
}

.carousel-dots span.active {
    background: white;
    transform: scale(1.2);
}

/* ======================
   KATEGORI FILTER
====================== */
.category-list {
    text-align: center;
    margin: 30px 0;
}

/* Tombol Filter - Abu Super Kecil */
.btn-filter {
    background: #f5f5f5;
    border: 1px solid #ccc;
    padding: 4px 8px;   /* kecil banget */
    margin: 3px;
    cursor: pointer;
    border-radius: 3px; /* kotak dengan sudut tipis */
    font-weight: 500;
    font-size: 12px;    /* lebih kecil */
    color: #333;
    transition: all 0.3s ease;
}

.btn-filter:hover {
    background: #e0e0e0;
    border-color: #aaa;
    color: #000;
    transform: translateY(-1px);
}

.btn-filter.active {
    background: #444;
    border-color: #333;
    color: #fff;
    box-shadow: 0 1px 3px rgba(0,0,0,0.2);
}


/* ======================
   PRODUK GALLERY ANIMASI
====================== */
.product-gallery .card {
    opacity: 1;
    transform: scale(1);
    transition: all 0.4s ease;
}

.product-gallery .card.hide {
    opacity: 0;
    transform: scale(0.9);
    pointer-events: none;
}

.product-gallery .card.show-anim {
    animation: fadeZoomIn 0.5s ease forwards;
}

@keyframes fadeZoomIn {
    from {
        opacity: 0;
        transform: scale(0.8);
    }
    to {
        opacity: 1;
        transform: scale(1);
    }
}


</style>

<!-- List Kategori -->
<section class="category-list">
    <button class="btn-filter active" data-kategori="all">Semua</button>
    <?php while ($rowKategori = mysqli_fetch_assoc($resultKategori)) : ?>
        <button class="btn-filter" data-kategori="<?= $rowKategori['id']; ?>">
            <?= $rowKategori['nama_kategori']; ?>
        </button>
    <?php endwhile; ?>
</section>

<!-- Section Produk -->
<section class="product-gallery">
  <div class="gallery-container">
      <?php while ($rowProduk = mysqli_fetch_assoc($queryProduk)) : ?>
    <div class="card" 
         data-kategori="<?= $rowProduk['kategori_id']; ?>" 
         style="width: 18rem; float: left; margin: 40px;">
        <img src="admin/content/uploads/Foto/<?= $rowProduk['gambar']; ?>" 
             alt="<?= $rowProduk['nama_produk']; ?>" 
             class="card-img-top">
        <div class="card-body">
            <h5 class="card-title"><?= $rowProduk['nama_produk']; ?></h5>
            <p class="card-text">Rp <?= number_format($rowProduk['harga_jual'], 0, ',', '.'); ?>,-</p>
            <button onclick="window.open('?page=detail&id=<?= $rowProduk['id']; ?>')" class="btn btn-warning">Detail</button>
            <a href="#" class="btn btn-danger">Beli</a>
        </div>
    </div>
    <?php endwhile; ?>
  </div>
</section>

<!-- JS Carousel -->
<script>
    let slides = document.querySelectorAll(".carousel-slide");
    let dotsContainer = document.querySelector(".carousel-dots");
    let current = 0;

    // buat dot sesuai jumlah slide
    slides.forEach((_, i) => {
        let dot = document.createElement("span");
        dot.addEventListener("click", () => goToSlide(i));
        dotsContainer.appendChild(dot);
    });

    let dots = dotsContainer.querySelectorAll("span");

    function showSlide(index) {
        slides.forEach((s, i) => s.classList.toggle("active", i === index));
        dots.forEach((d, i) => d.classList.toggle("active", i === index));
    }

    function nextSlide() {
        current = (current + 1) % slides.length;
        showSlide(current);
    }

    function goToSlide(index) {
        current = index;
        showSlide(current);
    }

    // otomatis jalan tiap 4 detik
    setInterval(nextSlide, 4000);

    // tampilkan pertama kali
    showSlide(current);
</script>

<!-- JS Filter Produk -->
<script>
  const filterButtons = document.querySelectorAll(".btn-filter");
  const products = document.querySelectorAll(".product-gallery .card");

  filterButtons.forEach(btn => {
    btn.addEventListener("click", () => {
      // reset active button
      filterButtons.forEach(b => b.classList.remove("active"));
      btn.classList.add("active");

      const kategori = btn.getAttribute("data-kategori");

      products.forEach(prod => {
        if (kategori === "all" || prod.getAttribute("data-kategori") === kategori) {
          // Tampilkan dengan animasi fade+zoom
          prod.classList.remove("hide");
          prod.classList.add("show-anim");
          setTimeout(() => prod.classList.remove("show-anim"), 500);
        } else {
          // Sembunyikan dengan animasi
          prod.classList.add("hide");
        }
      });
    });
  });
</script>


