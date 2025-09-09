<?php

if (isset($_GET['idPesan'])) {
    $getid = $_GET['idPesan'];
    $selectPesan = mysqli_query($config, "SELECT * FROM contacts WHERE id = $getid");
    $rowPesan = mysqli_fetch_assoc($selectPesan);
}

if (isset($_POST['kirim_pesan'])) {
    $subject = $_POST['subject'];
    $message = $_POST['message'];
    $email =  $_POST['email'];

 $headers =
    "From: sidiksadar11@gmail.com\r\n" .
    "Reply-To: sidiksadar11@gmail.com\r\n" .
    "Content-Type: text/plain; charset=UTF-8\r\n" .
    "MIME-Version: 1.0\r\n";


    if (mail($email, $subject, $message, $headers)) {
        header("location:page=balas-pesan");
        exit();
    }
}
?>
<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header">
            <h3><?= isset($_GET['edit']) ? 'Edit' : 'Add' ?> Produk</h3>
        </div>
        <div class="card-body">
            <form action="" method="post" enctype="multipart/form-data">
                <div class="mb-3 row">
                    <div class="col-sm-2">
                        <label for="" class="form-label">Nama * </label>
                    </div>
                    <div class="col-sm-10">
                        <input required name="name" type="text"
                            class="form-control"
                            placeholder="Masukkan nama anda"
                            value="<?php echo isset($_GET['edit']) ? $rowPesan['name'] : '' ?>">
                    </div>
                </div>
                <div class="mb-3 row">
                    <div class="col-sm-2">
                        <label class="form-label" for="">email * </label>
                    </div>
                    <div class="col-sm-10">
                        <input required name="email" type="text"
                            class="form-control"
                            placeholder="exmple:joko@gmail.com"
                            value="<?php echo isset($_GET['edit']) ? $rowPesan['email'] : '' ?>">
                    </div>
                </div>
                <div class="mb-3 row">
                    <div class="col-sm-2">
                        <label class="form-label" for="">Subject * </label>
                    </div>
                    <div class="col-sm-10">
                        <input required name="subject" type="text"
                            class="form-control"
                            placeholder=""
                            value="<?php echo isset($_GET['edit']) ?  $rowPesan['name'] : '' ?>">
                    </div>
                </div>

                <div class="mb-3 row">
                    <div class="col-sm-2">
                        <label class="form-label" for="">Message * </label>
                    </div>
                    <div class="col-sm-10">
                        <textarea id="summernote" class="form-control" name="message" cols="30" rows="5" style="height:500px"><?php echo isset($_GET['edit']) ?  $rowPesan['message'] : '' ?></textarea>
                    </div>
                </div>

        </div>
        <div class="mb-3 row">
            <div class="col-sm-2" align="right">
                <button name="kirim_pesan" type="submit"
                    class="btn btn-primary">Kirim Pesan</button>
            </div>
        </div>
        </form>
    </div>
</div>
</div>