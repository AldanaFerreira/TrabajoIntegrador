<?php
include 'datos/datos.php';
?>

<link rel="stylesheet" href="css/estilo.css">
<h2>Facturas Registradas</h2>

<table border="1" cellpadding="8" cellspacing="0">
    <tr>
        <th>ID</th>
        <th>Cliente</th>
        <th>Fecha</th>
        <th>Detalle</th>
    </tr>
    <?php foreach ($_SESSION["facturas"] as $i => $fact) { ?>
    <tr>
        <td><?= $fact->getId() ?></td>
        <td><?= $fact->getCliente()->getNombreCompleto() ?></td>
        <td><?= $fact->getFecha() ?></td>
        <td><a href="verFactura.php?id=<?= $i ?>">Ver</a></td>
    </tr>
    <?php } ?>
</table>
<a href="index.php">Volver</a>
