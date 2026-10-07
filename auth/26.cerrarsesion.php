<?php
// Inicia o recupera la sesión activa para poder cerrarla.
session_start();

// Elimina los datos asociados a la sesión actual del usuario.
session_destroy();

// Redirige al usuario al formulario de registro después de cerrar sesión.
header("Location: ../usuario/09.register.php");

// Detiene el script para evitar que se ejecute cualquier código posterior.
exit();
?>