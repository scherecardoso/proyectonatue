<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Nuevo Pedido</title>
<style>
body{
    font-family: 'Segoe UI', Arial, sans-serif;
    margin: 0;
    min-height: 100vh;
}

.formulario-pedido{
    max-width: 450px;
    margin: 50px auto;
    padding: 35px;
    background: #fff;
    border-radius: 18px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.08);
}

.formulario-pedido h2{
    text-align: center;
    color: #d88aa7;
    margin-bottom: 25px;
    font-size: 28px;
}

.formulario-pedido label{
    display: block;
    margin-bottom: 8px;
    color: #555;
    font-weight: 600;
}

.formulario-pedido input{
    width: 100%;
    padding: 12px 14px;
    margin-bottom: 18px;
    border: 1px solid #ddd;
    border-radius: 10px;
    box-sizing: border-box;
    font-size: 15px;
    transition: all .3s ease;
}

.formulario-pedido input:focus{
    outline: none;
    border-color: #d88aa7;
    box-shadow: 0 0 8px rgba(216,138,167,.25);
}

.formulario-pedido input[readonly]{
    background: #f8f8f8;
    color: #777;
}

.formulario-pedido button{
    width: 100%;
    padding: 14px;
    border: none;
    border-radius: 10px;
    background: #d88aa7;
    color: white;
    font-size: 16px;
    font-weight: bold;
    cursor: pointer;
    transition: .3s;
}

.formulario-pedido button:hover{
    background: #c06d8c;
    transform: translateY(-2px);
}

.formulario-pedido button:active{
    transform: translateY(0);
}

@media(max-width: 600px){

    .formulario-pedido{
        margin: 20px;
        padding: 25px;
    }

    .formulario-pedido h2{
        font-size: 24px;
    }
}
</style>

</head>
<body>
<?php include("../includes/header.php"); ?>
<form action="3.guardarpedido.php" method="POST">

<div class="formulario-pedido">
    <h2>Nuevo Pedido</h2>
    <label for="nombre">Nombre</label>
    <input type="text"id="nombre"name="nombre"required>
    <input type="date"name="fecha"value="<?php echo date('Y-m-d'); ?>">
    <input type="hidden"name="estado"value="En Proceso">
    <input type="text"name="nombrevendedor"value="<?php echo $_SESSION['nombre']; ?>"readonly>
    <button type="submit">Crear Pedido</button>
</div>

</form>
</body>
</html>