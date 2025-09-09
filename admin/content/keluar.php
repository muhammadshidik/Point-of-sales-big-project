<?php
session_start();        // mulai session
session_unset();        // hapus semua session
session_destroy();      // hancurkan session

// redirect ke halaman login
header("Location: Login.php");
exit();
?>
