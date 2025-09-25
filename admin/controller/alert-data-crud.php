<?php if (isset($_GET['edit']) && $_GET['edit'] == 'success'): ?>
    <div class="alert alert-success alert-dismissible fade show shadow-sm d-flex align-items-center" role="alert">
        <i class="fe fe-check-circle fe-16 mr-2"></i>
        <span>Perubahan berhasil disimpan!</span>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php elseif (isset($_GET['delete']) && $_GET['delete'] == 'success'): ?>
    <div class="alert alert-success alert-dismissible fade show shadow-sm d-flex align-items-center" role="alert">
        <i class="fe fe-check-circle fe-16 mr-2"></i>
        <span>Data berhasil dihapus!</span>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php elseif (isset($_GET['add']) && $_GET['add'] == 'success'): ?>
    <div class="alert alert-success alert-dismissible fade show shadow-sm d-flex align-items-center" role="alert">
        <i class="fe fe-check-circle fe-16 mr-2"></i>
        <span>Data berhasil disimpan.</span>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php elseif (isset($_GET['pickup']) && $_GET['pickup'] == 'success'): ?>
    <div class="alert alert-success alert-dismissible fade show shadow-sm d-flex align-items-center" role="alert">
        <i class="fe fe-check-circle fe-16 mr-2"></i>
        <span>Pesanan Anda telah berhasil dijemput.</span>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif; ?>

<!-- Tambahin script untuk auto close -->
<script>
    // Semua alert akan hilang setelah 4 detik (4000 ms)
    setTimeout(function() {
        let alertNode = document.querySelector('.alert');
        if (alertNode) {
            let alert = new bootstrap.Alert(alertNode);
            alert.close();
        }
    }, 3000);
</script>
