<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once 'clases/db/conexion.php'; // -> $conn a db
require_once 'clases/Producto.php';
require_once 'clases/LineaDePedido.php';
require_once 'clases/Factura.php';
require_once 'clases/Cliente.php';

// Obtener filtros de fechas
$fecha_desde = isset($_GET['fecha_desde']) ? $_GET['fecha_desde'] : '';
$fecha_hasta = isset($_GET['fecha_hasta']) ? $_GET['fecha_hasta'] : '';

// Detectar si se presionó el botón "Limpiar"
if (isset($_GET['limpiar'])) {
    $fecha_desde = '';
    $fecha_hasta = '';
}

// Construir la consulta
$sql = "
    SELECT f.idfactura, f.cuil, f.fecha, f.total_item, c.nombre AS cliente
    FROM facturas f
    JOIN clientes c ON f.cuil = c.cuil
";

// Agregar condiciones si hay fechas
$condiciones = [];
if ($fecha_desde) {
    $condiciones[] = "f.fecha >= '$fecha_desde'";
}
if ($fecha_hasta) {
    $condiciones[] = "f.fecha <= '$fecha_hasta'";
}
if (count($condiciones) > 0) {
    $sql .= " WHERE " . implode(" AND ", $condiciones);
}

$sql .= " ORDER BY f.fecha DESC";

$result = $conn->query($sql);
?>

<link rel="stylesheet" href="css/estilo.css">

<h2>Listado de Facturas</h2>

<!-- Formulario de filtro -->
<form method="get" action="listarFacturas.php" style="margin-bottom:20px;">
    <label>Desde: <input type="date" name="fecha_desde" value="<?php echo $fecha_desde; ?>"></label>
    <label>Hasta: <input type="date" name="fecha_hasta" value="<?php echo $fecha_hasta; ?>"></label>
    <button type="submit" class="btn-filtrar">Filtrar</button>
    <button type="submit" name="limpiar" value="1" class="btn-limpiar">Limpiar</button>
</form>

<table border="1">
    <thead>
        <tr>
            <th>ID</th>
            <th>Cliente</th>
            <th>CUIL</th>
            <th>Fecha</th>
            <th>Total</th>
            <th>Ver</th>
            <th>Eliminar</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>{$row['idfactura']}</td>";
                echo "<td>{$row['cliente']}</td>";
                echo "<td>{$row['cuil']}</td>";
                echo "<td>{$row['fecha']}</td>";
                echo "<td>$" . number_format($row['total_item'], 2) . "</td>";
                
                // Botón ver factura con clase btn-ver
                echo "<td>
                        <form method='get' action='verFactura.php' style='display:inline;'>
                            <input type='hidden' name='idfactura' value='{$row['idfactura']}'>
                            <button type='submit' class='btn-ver'>Ver</button>
                        </form>
                      </td>";

                // Botón eliminar
                echo "<td>
                        <form method='post' action='cargarFactura.php' style='display:inline;'>
                            <input type='hidden' name='eliminar' value='{$row['idfactura']}'>
                            <button type='submit' class='btn-eliminar' onclick='return confirm(\"¿Seguro que deseas eliminar esta factura?\");'>
                                Eliminar
                            </button>
                        </form>
                      </td>";

                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='7'>No hay facturas cargadas.</td></tr>";
        }
        ?>
    </tbody>
</table>

<button class="btn-volver">
    <a href="index.php">Volver al inicio</a>
</button>

<?php $conn->close(); ?>
