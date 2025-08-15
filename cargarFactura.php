<?php
include 'datos/datos.php';
include 'clases/Factura.php';
include 'clases/LineaDePedido.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cliente = $_SESSION["clientes"][$_POST["cliente"]];
    $factura = new Factura($_POST["id"], $_POST["fecha"], $cliente);

    foreach ($_POST["producto"] as $i => $prodIndex) {
        $prod = $_SESSION["productos"][$prodIndex];
        $cant = $_POST["cantidad"][$i];
        $linea = new LineaDePedido($prod, $cant);
        $factura->agregarLinea($linea);
    }

    $_SESSION["facturas"][] = $factura;
    echo "<p>Factura cargada correctamente.</p>";
}
?>

<link rel="stylesheet" href="css/estilo.css">
<h2>Cargar Factura</h2>
<form method="post">
    <label>ID Factura:</label><input name="id" required>
    <label>Fecha:</label><input type="date" name="fecha" required>

    <label>Cliente:</label>
    <select name="cliente" required>
        <?php foreach ($_SESSION["clientes"] as $i => $cli) {
            echo "<option value='$i'>{$cli->getNombreCompleto()}</option>";
        } ?>
    </select>

    <h3>Productos</h3>
    <div>
        <label>Producto:</label>
        <select name="producto[]">
            <?php foreach ($_SESSION["productos"] as $i => $p) {
                echo "<option value='$i'>{$p->imprimir()}</option>";
            } ?>
        </select>
        <label>Cantidad:</label><input type="number" name="cantidad[]" required>
    </div>

    <button type="submit">Guardar Factura</button>
</form>
<a href="index.php">Volver</a>
