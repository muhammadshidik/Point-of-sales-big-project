<?php if (isset($_GET['edit']) && $_GET['edit'] == 'success'): ?>
<div class="alert alert-success alert-dismissible" role="alert">
    Perubahan berhasil disimpan!
</div>
<?php elseif (isset($_GET['delete']) && $_GET['delete'] == 'success'): ?>
<div class="alert alert-success alert-dismissible" role="alert">
    Data Berhasil Dihapus !.
</div>
<?php elseif (isset($_GET['add']) && $_GET['add'] == 'success'): ?>
<div class="alert alert-success alert-dismissible" role="alert">
   Data berhasil disimpan.
</div>
<?php elseif (isset($_GET['pickup']) && $_GET['pickup'] == 'success'): ?>
<div class="alert alert-success alert-dismissible" role="alert">
    Pesanan Anda telah berhasil dijemput.
</div>
<?php endif ?>