<?php
// Comprueba el estado de la cuenta guardado en la sesión del usuario.
// Se asume que la sesión ya fue iniciada antes de incluir este archivo.
if($_SESSION['estado'] == "bloqueado") {
        // Si la cuenta está bloqueada, redirige al usuario a la página
        // que explica el bloqueo. La ruta es relativa a la carpeta auth.
        header("Location: ../admin/verbloqueo.php");
        }

        ?>