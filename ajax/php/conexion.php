<?php
// Este archivo se encarga de crear la conexión con la base de datos del proyecto.
// Se usa en otras páginas PHP para reutilizar la misma configuración y evitar repetir datos de acceso.
// En XAMPP, normalmente el servidor local es "localhost", el usuario es "root" y la contraseña queda vacía.

// Nombre del servidor donde está corriendo MySQL.
$servidor ="localhost";

// Nombre del usuario que tiene acceso a la base de datos.
$usuario ="root";

// Contraseña del usuario de la base de datos.
// En este entorno local suele estar vacía, pero en producción debe guardarse de forma segura.
$contra ="";

// Nombre de la base de datos del proyecto.
$baseDeDatos ="shena";

// Se crea la conexión usando la extensión mysqli.
// mysqli permite conectar con MySQL y ejecutar consultas SQL.
$conn = new mysqli($servidor, $usuario, $contra, $baseDeDatos);

// Si la conexión falla, se termina la ejecución del script y se muestra el motivo del error.
// Esto ayuda a detectar problemas con el servidor, usuario, contraseña o nombre de la base de datos.
if ($conn->connect_error) {
    die("Conexion fallida: " . $conn->connect_error);
}

// Se establece la codificación UTF-8 para que los textos con tildes, ñ y otros caracteres especiales
// se muestren correctamente en la página y en la base de datos.
$conn->set_charset("utf8");