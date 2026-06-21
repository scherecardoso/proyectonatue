<?php
session_start();
session_destroy();
header("Location: ../usuario/09.register.php");
exit();
?>