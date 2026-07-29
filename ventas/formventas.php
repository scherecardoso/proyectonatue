<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="../ventas/createventas.php" method="post" id="valiventas">
        <input type="number" name="costo" placeholder="Costo" required>
        <input type="text" name="metodo" placeholder="Metodo" required>
        <input type="text" name="estado" placeholder="Estado" required>

        <button type="submit">Crear Venta</button>
    </form>
</body>
</html>