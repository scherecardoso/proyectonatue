<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Lista de Usuarios</title>
<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial, sans-serif;
}

body{
    background:linear-gradient(to bottom,#f8f8f8,#ececec);
    padding:30px;
}

.contenedor{
    width:95%;
    max-width:1400px;
    margin:auto;
    background:white;
    padding:30px;
    border-radius:20px;
    box-shadow:0 5px 20px rgba(0,0,0,0.08);
}

h1{
    margin-bottom:25px;
    font-size:42px;
    color:#444;
    font-weight:700;
}

.volver{
    background:linear-gradient(135deg,#e6e6e6,#cfcfcf);
    color:#444;
    padding:12px 24px;
    border-radius:12px;
    text-decoration:none;
    display:inline-block;
    margin-bottom:25px;
    font-weight:bold;
    box-shadow:0 3px 8px rgba(0,0,0,0.12);
    transition:0.3s;
}

.volver:hover{
    background:linear-gradient(135deg,#d8d8d8,#bdbdbd);
    transform:translateY(-2px);
    box-shadow:0 5px 12px rgba(0,0,0,0.18);
}

table{
    width:100%;
    border-collapse:separate;
    border-spacing:0 15px;
}

th{
    background:#f7e8ee;
    color:#ff4f8b;
    padding:18px;
    font-size:17px;
    border:none;
}

th:first-child{
    border-radius:12px 0 0 12px;
}

th:last-child{
    border-radius:0 12px 12px 0;
}

td{
    background:white;
    padding:18px;
    font-size:16px;
    border-top:1px solid #e5e5e5;
    border-bottom:1px solid #e5e5e5;
    text-align:center;
    transition:0.3s;
}

tr td:first-child{
    border-left:1px solid #e5e5e5;
    border-radius:15px 0 0 15px;
}

tr td:last-child{
    border-right:1px solid #e5e5e5;
    border-radius:0 15px 15px 0;
}

tr:hover td{
    background:#fafafa;
}

.btn{
    padding:10px 18px;
    border-radius:12px;
    text-decoration:none;
    font-size:14px;
    margin:3px;
    display:inline-block;
    font-weight:bold;
    transition:0.3s;
}

.editar{
    background:#f8d8e5;
    color:#d63384;
}

.eliminar{
    background:#ffe1e1;
    color:#dc3545;
}

.btn:hover{
    transform:translateY(-2px);
    box-shadow:0 4px 10px rgba(0,0,0,0.12);
}

.sin-datos{
    text-align:center;
    margin-top:20px;
    color:#777;
    font-size:18px;
}
@media (max-width: 768px){

    body{
        padding:15px;
    }

    .contenedor{
        width:100%;
        padding:15px;
        overflow-x:auto;
    }

    h1{
        font-size:28px;
        text-align:center;
    }

    .volver{
        width:100%;
        text-align:center;
    }

    table{
        min-width:900px;
    }

    th,
    td{
        padding:10px;
        font-size:14px;
    }

    .btn{
        padding:8px 12px;
        font-size:13px;
    }
}

@media(max-width: 480px){

    body{
        padding:10px;
    }

    h1{
        font-size:24px;
    }

    th,
    td{
        padding:8px;
        font-size:12px;
    }

    .btn{
        display:block;
        margin:4px auto;
        width:90%;
    }
}

</style>
</head>

<body>

<?php include("../includes/header.php"); ?>

<div class="contenedor">

<h1>Lista de Usuarios</h1>

<a class="volver" href="../usuario/09.register.php">
    ← Volver 
</a>

<?php

$servidor = "localhost";
$usuario = "root";
$contra = "";
$baseDeDatos = "shena";

$conn = new mysqli($servidor, $usuario, $contra, $baseDeDatos);

if ($conn->connect_error) {
    die("Error de conexión");
}

$sql = "SELECT * FROM usuario";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {

    echo "<table>";

    echo "
    <tr>
        <th>CI</th>
        <th>Nombre</th>
        <th>Dirección</th>
        <th>Celular</th>
        <th>Rol</th>
        <th>Estado</th>
        <th>Acciones</th>
    </tr>
    ";

    while($fila = $result->fetch_assoc()) {

        $CI = $fila['CI'];

        echo "
        <tr>
            <td>{$fila['CI']}</td>
            <td>{$fila['nombre']}</td>
            <td>{$fila['direccion']}</td>
            <td>{$fila['celular']}</td>
            <td>{$fila['rol']}</td>
            <td>{$fila['estado']}</td>
            <td>
                <a class='btn editar' href='../usuario/13.formeditarusuario.php?CI=$CI'>
                    Editar
                </a>

                <a class='btn eliminar' href='../usuario/15.eliminarusuario.php?CI=$CI'
                    Eliminar
                </a>
            </td>
        </tr>";
    }

    echo "</table>";

} else {

    echo "<p class='sin-datos'>No hay usuarios registrados.</p>";

}

$conn->close();

?>

</div>

</body>
</html>