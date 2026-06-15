<?php
session_start();
session_destroy();
header("Location: 09.register.php");
exit();
?>