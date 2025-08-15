<?php
include 'datos/datos.php';

$id = $_GET["id"];
$fact = $_SESSION["facturas"][$id];
?>

<link rel="stylesheet" href="css/estilo.css">
<h2>Detalle de Factura <?= $fact->getId() ?></h2>
<p><strong>Fecha:</strong> <?= $fact->getFecha() ?></p>
<p><strong>Cliente:</strong> <?= $fact->getCliente()->getNombreCompleto() ?></p>
<p><strong>CUIL:</strong> <?= $fact->getCliente()->getCuil() ?></p>

<h3>Teléfonos</h3>
<ul>
<?php foreach ($fact->getCliente()->getTelefonos() as $tel) {
    echo "<li>{$tel->imprimir()}</li>";
} ?>
</ul>

<h3>Direcciones</h3>
<ul>
<?php foreach ($fact->getCliente()->getDirecciones() as $dir) {
    echo "<li>{$dir->imprimir()}</li>";
} ?>
</ul>

<h3>Productos</h3>
<ul>
<?php foreach ($fact->getLineas() as $linea) {
    echo "<li>{$linea->imprimir()}</li>";
} ?>
</ul>

<p><strong>Total:</strong> $<?= number_format($fact->calcularTotal(), 2) ?></p>
<a href="listarFacturas.php">Volver</a>
