<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once 'clases/db/conexion.php'; // Conexión a la base de datos

$idfactura = $_GET['idfactura'] ?? 0;

// ======== Obtener datos de la factura y del cliente ========
$resFactura = $conn->query("
    SELECT f.idfactura, f.fecha, c.nombre, c.apellido, c.cuil
    FROM facturas f
    JOIN clientes c ON f.cuil = c.cuil
    WHERE f.idfactura = $idfactura
");

if($resFactura->num_rows == 0){
    echo "Factura no encontrada.";
    exit;
}

$factura = $resFactura->fetch_assoc();

// ======== Obtener detalle de productos ========
$resDetalle = $conn->query("
    SELECT p.nombre as producto_nombre, d.cantidad, d.precio_unitario, d.total
    FROM detalle_facturas d
    JOIN productos p ON d.idproducto = p.idproducto
    WHERE d.idfactura = $idfactura
");

// ======== Mostrar factura ========
?>
<link rel="stylesheet" href="css/estilo.css">

<h2>Factura N° <?php echo $factura['idfactura']; ?></h2>

<p>
    <strong>Cliente:</strong> <?php echo $factura['apellido'] . ' ' . $factura['nombre']; ?><br>
    <br>
    <strong>CUIL:</strong> <?php echo $factura['cuil']; ?><br>
    <br>
    <strong>Fecha:</strong> <?php echo $factura['fecha']; ?>
    <br>
</p>


<table border="1">
    <thead>
        <tr>
            <th>Producto</th>
            <th>Cantidad</th>
            <th>Precio Unitario</th>
            <th>Subtotal</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        $totalFactura = 0;
        while($detalle = $resDetalle->fetch_assoc()):
            $totalFactura += $detalle['total'];
        ?>
        <tr>
            <td><?php echo $detalle['producto_nombre']; ?></td>
            <td><?php echo $detalle['cantidad']; ?></td>
            <td>$<?php echo number_format($detalle['precio_unitario'],2); ?></td>
            <td>$<?php echo number_format($detalle['total'],2); ?></td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<p><strong>Total Factura:</strong> $<?php echo number_format($totalFactura,2); ?></p>


<button class="btn-volver">
<a href="listarFacturas.php">Volver al listado</a> </button>

<?php $conn->close(); ?>

