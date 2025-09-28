<?php
// Logic PHP
include 'admin/controller/koneksi.php';

// Ambil semua data produk
$queryProduk = mysqli_query($config, "SELECT * FROM produk");

// Ambil kategori
$queryKategori = "SELECT * FROM kategori ORDER BY id DESC";
$resultKategori = mysqli_query($config, $queryKategori);

// Mendapatkan total produk per kategori untuk ditampilkan di tombol filter
$productCount = [];
$countQuery = mysqli_query($config, "SELECT kategori_id, COUNT(id) as count FROM produk GROUP BY kategori_id");
while ($row = mysqli_fetch_assoc($countQuery)) {
    $productCount[$row['kategori_id']] = $row['count'];

}

$querypelanggan = mysqli_query($config, "SELECT * FROM customer ORDER BY id DESC");

// Menghitung total semua produk untuk tombol "Semua"
$totalAllProducts = array_sum($productCount);

/*
|--------------------------------------------------------------------------
| LOGIC DYNAMIC TAX/SERVICE FEE (PHP)
|--------------------------------------------------------------------------
| Tempat untuk mendefinisikan variabel global PHP jika diperlukan.
*/

// Anda bisa menambahkan logika pengambilan setting di sini jika ada:
/*
$querySetting = mysqli_query($config, "SELECT nilai_pajak, nilai_service FROM pengaturan LIMIT 1");
$setting = mysqli_fetch_assoc($querySetting);
$SERVICE_FEE_RATE = $setting['nilai_service'] ?? 0; // Dalam bentuk desimal, misal 0.10
$TAX_RATE = $setting['nilai_pajak'] ?? 0; // Dalam bentuk desimal
*/

// HANYA UNTUK DEMO: Logika PHP yang akan dijalankan di 'proses_penjualan.php'
// Jika file ini diakses langsung (bukan hasil include), maka logic ini akan dieksekusi saat form disubmit.
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['proses_order'])) {
    // Data Utama Penjualan
    $total_pembayaran = $_POST['total_pembayaran'] ?? 0;
    $metode_pembayaran = $_POST['metode_pembayaran'] ?? 'card';
    $jumlah_bayar = str_replace(['.', ','], '', $_POST['jumlah_bayar']) ?? 0; // Bersihkan format Rupiah dari JS
    $kembalian = $_POST['kembalian'] ?? 0;
    $sub_total = $_POST['sub_total'] ?? 0;

    // Data Detail Produk Pesanan (JSON String)
    $order_items_json = $_POST['order_items_json'] ?? '[]';

    // Konversi JSON menjadi array PHP
    $order_items = json_decode($order_items_json, true);

    // Asumsi: $config adalah koneksi database
    /*
    if ($config) {
        // 1. Simpan Data Penjualan (Header)
        $stmt = mysqli_prepare($config, "INSERT INTO penjualan (total, metode, bayar, kembalian) VALUES (?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, 'isii', $total_pembayaran, $metode_pembayaran, $jumlah_bayar, $kembalian);
        mysqli_stmt_execute($stmt);
        $penjualan_id = mysqli_insert_id($config);

        // 2. Simpan Data Detail Penjualan (Detail Item)
        if ($penjualan_id && !empty($order_items)) {
            $stmt_detail = mysqli_prepare($config, "INSERT INTO detail_penjualan (penjualan_id, produk_id, qty, harga_satuan) VALUES (?, ?, ?, ?)");
            foreach ($order_items as $item) {
                $produk_id = $item['id'];
                $kuantitas = $item['qty'];
                $harga_jual = $item['harga'];
                mysqli_stmt_bind_param($stmt_detail, 'iiid', $penjualan_id, $produk_id, $kuantitas, $harga_jual);
                mysqli_stmt_execute($stmt_detail);
            }
        }
        
        // Berikan respon atau redirect
        // header('Location: /success_page.php?id=' . $penjualan_id);
        // exit;

        // Untuk tujuan demonstrasi:
        echo "<script>alert('Penjualan ID: $penjualan_id berhasil diproses! Total: $total_pembayaran');</script>";
    } else {
         echo "<script>alert('ERROR: Database connection failed.');</script>";
    }
    */
}

?>
<style>
    /* === LAYOUT WRAPPER === */
.pos-wrapper {
  display: flex;
  justify-content: center;
  padding: 20px;
  background: #f8f9fb;
  min-height: 100vh;
  font-family: 'Segoe UI', sans-serif;
}

.menu-order-container {
  display: grid;
  grid-template-columns: 2fr 1fr; /* kiri menu, kanan invoice */
  gap: 20px;
  width: 100%;
  max-width: 1300px;
}

/* === CATEGORY FILTER === */
.category-filter-container {
  background: #fff;
  padding: 15px;
  border-radius: 12px;
  margin-bottom: 20px;
  box-shadow: 0 2px 5px rgba(0,0,0,0.05);
}

.category-list {
  display: flex;
  flex-wrap: wrap;
  gap: 10px;
}

.category-item {
  background: #f1f3f7;
  border: none;
  border-radius: 10px;
  padding: 10px 14px;
  cursor: pointer;
  font-size: 14px;
  transition: all 0.2s;
}

.category-item.active,
.category-item:hover {
  background: #2d7ff9;
  color: #fff;
}

/* === PRODUCT GALLERY === */
.product-gallery {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
  gap: 18px;
}

.product-card {
  background: #fff;
  border-radius: 14px;
  box-shadow: 0 2px 6px rgba(0,0,0,0.08);
  display: flex;
  flex-direction: column;
  overflow: hidden;
  transition: transform 0.2s;
}

.product-card:hover {
  transform: translateY(-4px);
}

.product-img-container {
  height: 150px;
  overflow: hidden;
  display: flex;
  justify-content: center;
  align-items: center;
}

.product-img {
  max-width: 100%;
  max-height: 100%;
  object-fit: cover;
}

.product-details {
  padding: 12px 14px;
}

.product-name {
  font-size: 16px;
  font-weight: 600;
  margin-bottom: 5px;
}

.product-description {
  font-size: 13px;
  color: #666;
  margin-bottom: 10px;
}

.product-price {
  font-weight: 700;
  color: #2d7ff9;
  font-size: 15px;
}

.qty-control-wrapper {
  display: flex;
  justify-content: flex-end;
  padding: 10px 14px;
}

.btn-add-to-cart {
  background: #2d7ff9;
  color: #fff;
  border: none;
  border-radius: 10px;
  padding: 6px 12px;
  font-size: 18px;
  cursor: pointer;
  transition: 0.2s;
}

.btn-add-to-cart:hover {
  background: #145dd8;
}

/* === INVOICE PANEL === */
.invoice-panel {
  background: #fff;
  border-radius: 14px;
  padding: 20px;
  box-shadow: 0 2px 6px rgba(0,0,0,0.1);
  display: flex;
  flex-direction: column;
}

.order-list {
  margin: 15px 0;
  max-height: 300px;
  overflow-y: auto;
  border-bottom: 1px solid #eee;
  padding-bottom: 10px;
}

.order-item {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 12px;
}

.item-details {
  display: flex;
  flex-direction: column;
  font-size: 14px;
}

.item-name {
  font-weight: 600;
}

.item-qty-info {
  font-size: 12px;
  color: #777;
}

.item-price-and-control {
  display: flex;
  align-items: center;
  gap: 8px;
}

.item-subtotal {
  font-weight: 600;
  color: #2d7ff9;
}

.invoice-qty-control {
  display: flex;
  align-items: center;
  gap: 5px;
}

.btn-qty-control {
  background: #f1f3f7;
  border: none;
  border-radius: 8px;
  width: 28px;
  height: 28px;
  font-weight: bold;
  cursor: pointer;
}

.btn-qty-control:hover {
  background: #2d7ff9;
  color: #fff;
}

/* === SUMMARY === */
.payment-summary {
  margin-top: auto;
}

.summary-line {
  display: flex;
  justify-content: space-between;
  margin: 8px 0;
  font-size: 14px;
}

.summary-line.total-payment {
  font-size: 16px;
  font-weight: 700;
}

.payment-options {
  display: flex;
  gap: 8px;
  margin: 12px 0;
}

.payment-btn {
  flex: 1;
  background: #f1f3f7;
  border: none;
  border-radius: 10px;
  padding: 10px;
  cursor: pointer;
}

.payment-btn.active {
  background: #2d7ff9;
  color: #fff;
}

.btn-place-order {
  width: 100%;
  background: #2d7ff9;
  color: #fff;
  border: none;
  border-radius: 12px;
  padding: 12px;
  font-size: 16px;
  font-weight: 600;
  cursor: pointer;
  margin-top: 15px;
}

.btn-place-order:hover {
  background: #145dd8;
}

.btn-clear-order {
  width: 100%;
  background: #eee;
  border: none;
  border-radius: 12px;
  padding: 10px;
  font-size: 14px;
  margin-top: 8px;
  cursor: pointer;
}

</style>

<div class="pos-wrapper">
    <main class="menu-order-container">
        <section class="menu-section">
            <div class="category-filter-container">
                <h3 class="section-title">Kategori Menu</h3>
                <div class="category-list">
                    <button class="category-item btn-filter active" data-kategori="all">
                        <span class="category-name">Semua</span>
                        <span class="stock-info">
                            <?= $totalAllProducts; ?> Menu in Stock
                        </span>
                    </button>
                    <?php while ($rowKategori = mysqli_fetch_assoc($resultKategori)) : ?>
                        <?php $count = $productCount[$rowKategori['id']] ?? 0; ?>
                        <button class="category-item btn-filter" data-kategori="<?= $rowKategori['id']; ?>">
                            <span class="category-name"><?= $rowKategori['nama_kategori']; ?></span>
                            <span class="stock-info">
                                <?= $count; ?> Menu in Stock
                            </span>
                        </button>
                    <?php endwhile; ?>
                </div>
            </div>

            <h3 class="section-title">Daftar Menu</h3>

            <div class="product-gallery" id="productGallery">
                <?php while ($rowProduk = mysqli_fetch_assoc($queryProduk)) : ?>
                    <div class="product-card" data-kategori="<?= $rowProduk['kategori_id']; ?>" data-id="<?= $rowProduk['id']; ?>">
                        <div class="product-img-container">
                            <img src="admin/content/uploads/Foto/<?= $rowProduk['gambar']; ?>"
                                alt="<?= $rowProduk['nama_produk']; ?>"
                                class="product-img">
                        </div>

                        <div class="product-details">
                            <h4 class="product-name"><?= $rowProduk['nama_produk']; ?></h4>
                            <p class="product-description">
                                Deskripsi singkat produk.
                            </p>
                            <p class="product-price">
                                Rp <?= number_format($rowProduk['harga_jual'], 0, ',', '.'); ?>,-
                            </p>
                        </div>

                        <div class="qty-control-wrapper">
                            <button class="btn-add-to-cart"
                                data-id="<?= $rowProduk['id']; ?>"
                                data-nama="<?= $rowProduk['nama_produk']; ?>"
                                data-harga="<?= $rowProduk['harga_jual']; ?>">
                                +
                            </button>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </section>

        <aside class="invoice-panel">
            <h3 class="section-title">Invoice</h3>

            <form action="proses_penjualan.php" method="POST" id="checkoutForm">
                         <div class="mb-3">
                            <label class="form-label">Nama Pelanggan</label>
                            <select name="customer_name" class="form-control select2" id="simple-select2" required>
                                <optgroup label="Pilih Kategori">
                                    <?php while ($kategori = mysqli_fetch_assoc($querypelanggan)) : ?>
                                        <option value="<?= $kategori['id'] ?>" <?= (isset($rowEdit['customer_name']) && $rowEdit['customer_name'] == $kategori['id']) ? ' selected' : '' ?>>
                                            <?= $kategori['customer_name'] ?>
                                        </option>
                                    <?php endwhile; ?>
                                </optgroup>
                            </select>
                        </div>
                <div class="order-list" id="orderList">
                    <p class="placeholder-text">Belum ada item dipesan.</p>
                </div>

                <div class="payment-summary">
                    <h3 class="section-title">Ringkasan Pembayaran</h3>

                    <div class="summary-line">
                        <span>Sub Total</span>
                        <span id="subTotalPrice">Rp 0,-</span>
                        <input type="hidden" name="sub_total" id="inputSubTotal" value="0">
                    </div>

                    <hr>

                    <div class="summary-line total-payment">
                        <span>Total Payment</span>
                        <span id="totalPayment">Rp 0,-</span>
                        <input type="hidden" name="total_pembayaran" id="inputTotalPayment" value="0">
                    </div>

                    <hr>

                    <div class="payment-options">
                        <button class="payment-btn active" data-method="card" type="button">Card</button>
                        <button class="payment-btn" data-method="paylater" type="button">Paylater</button>
                        <button class="payment-btn" data-method="cash" type="button">Cash</button>
                        <input type="hidden" name="metode_pembayaran" id="inputPaymentMethod" value="card">
                    </div>

                    <div style="margin-bottom: 15px;">
                        <label for="inputBayar" style="font-size: 0.9em; display: block; margin-bottom: 5px; font-weight: 600;">Jumlah Bayar (Hanya untuk Cash):</label>
                        <input type="text" id="inputBayar" name="jumlah_bayar" placeholder="Masukkan jumlah uang"
                            style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 8px; box-sizing: border-box; font-size: 1em;">
                    </div>
                    <div class="summary-line">
                        <span style="font-weight: 600;">Kembalian</span>
                        <span id="kembalian" style="font-weight: 700;">Rp 0,-</span>
                        <input type="hidden" name="kembalian" id="inputChangeAmount" value="0">
                    </div>
                    <hr>

                    <button class="btn-place-order" id="btnPlaceOrder" type="submit" name="proses_order">
                        Proses Pembayaran
                    </button>

                    <button class="btn-clear-order" id="btnClearOrder" type="button">
                        Batal Pesanan
                    </button>
                </div>
                <input type="hidden" name="order_items_json" id="inputOrderItemsJson" value="">
            </form>
        </aside>
    </main>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const productGallery = document.getElementById('productGallery');
        const orderList = document.getElementById('orderList');
        const btnFilters = document.querySelectorAll('.btn-filter');
        const btnClearOrder = document.getElementById('btnClearOrder');
        const btnPlaceOrder = document.getElementById('btnPlaceOrder');
        const inputBayar = document.getElementById('inputBayar');

        // Elemen Ringkasan Pembayaran
        const subTotalPriceSpan = document.getElementById('subTotalPrice');
        const totalPaymentSpan = document.getElementById('totalPayment');
        const kembalianSpan = document.getElementById('kembalian');

        // Hidden Inputs untuk Form Submission
        const inputSubTotal = document.getElementById('inputSubTotal');
        const inputTotalPayment = document.getElementById('inputTotalPayment');
        const inputPaymentMethod = document.getElementById('inputPaymentMethod');
        const inputChangeAmount = document.getElementById('inputChangeAmount');
        const inputOrderItemsJson = document.getElementById('inputOrderItemsJson');

        let order = {};
        let paymentMethod = 'card'; // Default payment method

        /** Mengkonversi angka ke format Rupiah */
        function formatRupiah(number) {
            return 'Rp ' + new Intl.NumberFormat('id-ID').format(Math.max(0, number));
        }

        /** Menghitung ulang total pesanan dan memperbarui UI & Hidden Inputs */
        function updateOrderSummary() {
            let subTotal = 0;
            for (const id in order) {
                subTotal += order[id].qty * order[id].harga;
            }

            const totalPayment = subTotal;

            // Update UI
            subTotalPriceSpan.textContent = formatRupiah(subTotal);
            totalPaymentSpan.textContent = formatRupiah(totalPayment);

            // Update Hidden Inputs (Data untuk PHP)
            inputSubTotal.value = subTotal;
            inputTotalPayment.value = totalPayment;
            inputOrderItemsJson.value = JSON.stringify(order);

            updateChange(totalPayment);

            if (subTotal === 0) {
                orderList.innerHTML = '<p class="placeholder-text">Belum ada item dipesan.</p>';
            } else if (orderList.querySelector('.placeholder-text')) {
                orderList.querySelector('.placeholder-text').remove();
            }
        }

        /** Menghitung dan menampilkan kembalian */
        function updateChange(totalPrice) {
            // Membersihkan input agar hanya angka yang tersisa
            const cleanedInput = inputBayar.value.replace(/\D/g, '');
            const bayar = parseInt(cleanedInput) || 0;
            const kembalian = bayar - totalPrice;

            kembalianSpan.textContent = formatRupiah(kembalian);
            kembalianSpan.style.color = kembalian < 0 ? '#e74c3c' : '#333';

            // Mengatur format Rupiah di inputBayar
            const formattedBayar = new Intl.NumberFormat('id-ID').format(bayar);
            if (inputBayar.value !== formattedBayar) {
                inputBayar.value = formattedBayar;
            }

            // Update Hidden Input Kembalian
            inputChangeAmount.value = kembalian;
        }

        /** Membuat elemen HTML untuk item pesanan */
        function createOrderItemElement(item) {
            const itemDiv = document.createElement('div');
            itemDiv.classList.add('order-item');
            itemDiv.dataset.id = item.id;

            itemDiv.innerHTML = `
            <div class="item-details">
                <span class="item-name">${item.nama}</span>
                <span class="item-qty-info">@ ${formatRupiah(item.harga)}</span>
            </div>
            <div class="item-price-and-control">
                <span class="item-subtotal">${formatRupiah(item.qty * item.harga)}</span>
                <div class="invoice-qty-control">
                    <button class="btn-qty-control btn-minus" type="button" data-action="minus" data-id="${item.id}">-</button>
                    <span class="item-qty">${item.qty}</span>
                    <button class="btn-qty-control btn-plus" type="button" data-action="plus" data-id="${item.id}">+</button>
                </div>
            </div>
        `;

            itemDiv.querySelectorAll('.btn-qty-control').forEach(btn => {
                btn.addEventListener('click', handleQtyChange);
            });

            return itemDiv;
        }

        /** Menambahkan produk baru ke pesanan */
        function addItemToOrder(id, nama, harga) {
            const itemDiv = orderList.querySelector(`.order-item[data-id="${id}"]`);

            if (order[id]) {
                order[id].qty += 1;
            } else {
                order[id] = {
                    id: id,
                    nama: nama,
                    harga: harga,
                    qty: 1
                };
                const newItemElement = createOrderItemElement(order[id]);
                orderList.appendChild(newItemElement);
            }

            updateOrderListUI(id, itemDiv);
        }

        /** Mengubah kuantitas item */
        function handleQtyChange(event) {
            const button = event.currentTarget;
            const action = button.dataset.action;
            const id = button.dataset.id;
            const itemDiv = button.closest('.order-item');

            if (!order[id]) return;

            if (action === 'plus') {
                order[id].qty += 1;
            } else if (action === 'minus') {
                order[id].qty -= 1;
            }

            if (order[id].qty <= 0) {
                delete order[id];
                itemDiv.remove();
            } else {
                updateOrderListUI(id, itemDiv);
            }

            updateOrderSummary();
        }

        /** Memperbarui tampilan UI item pesanan (kuantitas & subtotal) */
        function updateOrderListUI(id, itemDiv) {
            const item = order[id];
            if (!item) return;

            if (!itemDiv) {
                itemDiv = orderList.querySelector(`.order-item[data-id="${id}"]`);
                if (!itemDiv) return;
            }

            const qtySpan = itemDiv.querySelector('.invoice-qty-control .item-qty');
            const subtotalSpan = itemDiv.querySelector('.item-subtotal');

            qtySpan.textContent = item.qty;
            subtotalSpan.textContent = formatRupiah(item.qty * item.harga);
        }


        // --- Event Listeners ---

        // 1. Filter Kategori
        btnFilters.forEach(button => {
            button.addEventListener('click', function() {
                btnFilters.forEach(btn => btn.classList.remove('active'));
                this.classList.add('active');
                const selectedKategori = this.dataset.kategori;
                const productCards = productGallery.querySelectorAll('.product-card');

                productCards.forEach(card => {
                    const cardKategori = card.dataset.kategori;
                    card.style.display = (selectedKategori === 'all' || cardKategori === selectedKategori) ? 'flex' : 'none';
                });
            });
        });

        // 2. Tambah Item ke Pesanan
        productGallery.addEventListener('click', function(event) {
            const target = event.target.closest('.btn-add-to-cart');
            if (target) {
                const id = target.dataset.id;
                const nama = target.dataset.nama;
                const harga = parseFloat(target.dataset.harga);
                addItemToOrder(id, nama, harga);
                updateOrderSummary();
            }
        });

        // 3. Batalkan Pesanan
        btnClearOrder.addEventListener('click', function() {
            if (confirm("Apakah Anda yakin ingin membatalkan semua pesanan?")) {
                order = {};
                orderList.innerHTML = '';
                inputBayar.value = '';
                updateOrderSummary();
            }
        });

        // 4. Input Pembayaran
        inputBayar.addEventListener('input', function() {
            const currentTotal = parseFloat(inputTotalPayment.value) || 0;
            updateChange(currentTotal);
        });

        // 5. Pilih Metode Pembayaran
        document.querySelectorAll('.payment-btn').forEach(button => {
            button.addEventListener('click', function() {
                document.querySelectorAll('.payment-btn').forEach(btn => btn.classList.remove('active'));
                this.classList.add('active');
                paymentMethod = this.dataset.method;
                inputPaymentMethod.value = paymentMethod; // Update hidden input
            });
        });

        // 6. Proses Pesanan (Validasi sebelum submit form)
        document.getElementById('checkoutForm').addEventListener('submit', function(event) {
            const totalAmount = parseFloat(inputTotalPayment.value) || 0;
            // Ambil nilai yang sudah diformat kembali ke integer/float untuk validasi
            const paidAmount = parseFloat(inputBayar.value.replace(/\./g, '').replace(',', '.')) || 0;

            if (Object.keys(order).length === 0) {
                alert("Tidak ada item dalam pesanan.");
                event.preventDefault();
                return;
            }

            if (paymentMethod === 'cash' && paidAmount < totalAmount) {
                alert(`Pembayaran kurang. Dibutuhkan: ${formatRupiah(totalAmount)}.`);
                event.preventDefault();
                return;
            }

            // Jika validasi sukses, form akan disubmit ke action="proses_penjualan.php"
            // Data yang dikirim: sub_total, total_pembayaran, metode_pembayaran, jumlah_bayar, kembalian, order_items_json
        });

        // Inisialisasi ringkasan pesanan
        updateOrderSummary();
    });
</script>