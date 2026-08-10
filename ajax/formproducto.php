<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="registroProducto.php" method="POST">

    Código:
    <input type="number" name="codigo"><br>

    Nombre:
    <input type="text" name="nombre"><br>

    Descripción:
    <input type="text" name="descripcion"><br>

    Precio:
    <input type="number" step="0.01" name="precio"><br>
    Stock:
    <input type="number" step="0.01" name="stock"><br>
 <label>Imagen</label>
    <input type="file" name="imagen" accept="image/*">

    <br><br>

    <label>Estado</label>
    <select name="estado">
        <option value="Activo">Activo</option>
        <option value="Desactivo">Desactivo</option>
    </select>

    <br><br>
    <input type="submit" value="Registrar">

</form>
</body>
</html>