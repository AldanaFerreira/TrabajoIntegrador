<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once 'clases/db/conexion.php'; // -> $conn a db
require_once 'clases/Producto.php';
require_once 'clases/LineaDePedido.php';
require_once 'clases/Factura.php';
require_once 'clases/Cliente.php';

$mensaje = "";

// =========================
// ELIMINAR FACTURA
// =========================
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["eliminar"])) {
    $idEliminar = intval($_POST["eliminar"]);

    // Primero eliminar detalles
    $conn->query("DELETE FROM detalle_facturas WHERE idfactura = $idEliminar");

    // Luego la factura
    if ($conn->query("DELETE FROM facturas WHERE idfactura = $idEliminar") === TRUE) {
        $mensaje = "<p style='color:green;'>Factura eliminada correctamente.</p>";
    } else {
        $mensaje = "<p style='color:red;'>Error al eliminar: " . $conn->error . "</p>";
    }

    // Resetear autoincrement si ya no hay facturas
    $resCheck = $conn->query("SELECT COUNT(*) AS cant FROM facturas");
    $row = $resCheck->fetch_assoc();
    if ($row['cant'] == 0) {
        $conn->query("ALTER TABLE facturas AUTO_INCREMENT = 1");
    }
}

// =========================
// INSERTAR FACTURA
// =========================
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["cuil"], $_POST["fecha"], $_POST["producto"]) && !isset($_POST["eliminar"])) {
    $cuil  = $_POST["cuil"];
    $fecha = $_POST["fecha"];
    $total = 0;

    // Calcular total
    foreach ($_POST["producto"] as $i => $idproducto) {
        $cantidad = $_POST["cantidad"][$i];
        $resProd = $conn->query("SELECT precio FROM productos WHERE idproducto = $idproducto");
        if ($resProd && $row = $resProd->fetch_assoc()) {
            $precio = $row["precio"];
            $total += $precio * $cantidad;
        }
    }

    // Insertar cabecera factura (idfactura autoincremental)
    $sqlFactura = "INSERT INTO facturas (cuil, fecha, total_item) 
                   VALUES ('$cuil', '$fecha', '$total')";
    if ($conn->query($sqlFactura) === TRUE) {
        $idfactura = $conn->insert_id;

        // Insertar detalle
        foreach ($_POST["producto"] as $i => $idproducto) {
            $cantidad = $_POST["cantidad"][$i];
            $resProd = $conn->query("SELECT precio FROM productos WHERE idproducto = $idproducto");
            $row = $resProd->fetch_assoc();
            $precio = $row["precio"];
            $subtotal = $precio * $cantidad;

            $sqlDet = "INSERT INTO detalle_facturas (idfactura, idproducto, cantidad, total) 
                       VALUES ('$idfactura', '$idproducto', '$cantidad', '$subtotal')";
            $conn->query($sqlDet);
        }


        $mensaje = "<p style='color:green;'>Factura cargada correctamente.</p>";
    } else {
        $mensaje = "<p style='color:red;'>Error al cargar factura: " . $conn->error . "</p>";
    }
}

// =========================
// LISTAR FACTURAS
// =========================
$result = $conn->query("
    SELECT f.idfactura, c.nombre, c.apellido, c.cuil, f.fecha, f.total_item
    FROM facturas f
    JOIN clientes c ON f.cuil = c.cuil
    ORDER BY f.idfactura DESC
");


// Traer productos para el formulario
$resProdForm = $conn->query("SELECT idproducto, nombre FROM productos");
?>

<link rel="stylesheet" href="css/estilo.css">

<h2>Cargar Factura</h2>
<!-- esta linea es para probar el git
<?= $mensaje ?> -->

<form method="post">
    <label>Fecha:</label>
    <input type="date" name="fecha" required value="<?= date('Y-m-d') ?>">

    <label>Cliente (CUIL):</label>
    <select name="cuil" required>
        <?php
        $resCli = $conn->query("SELECT cuil, nombre FROM clientes");
        while ($row = $resCli->fetch_assoc()) {
            echo "<option value='{$row['cuil']}'>{$row['nombre']} ({$row['cuil']})</option>";
        }
        ?>
    </select>



  <h3>Productos</h3>
    <div id="productos-container">
        <div class="producto-row">
            <select name="producto[]" required>
                <?php
                $resProdForm = $conn->query("SELECT idproducto, nombre FROM productos");
                if ($resProdForm && $resProdForm->num_rows > 0) {
                    while ($row = $resProdForm->fetch_assoc()) {
                        echo "<option value='{$row['idproducto']}'>{$row['nombre']}</option>";
                    }
                } else {
                    echo "<option disabled>No hay productos cargados</option>";
                }
                ?>
            </select>
            <input type="number" name="cantidad[]" min="1" required placeholder="Cantidad">
            <button type="button" onclick="eliminarFila(this)">X</button>
        </div>
    </div>

        <button type="button" onclick="agregarProducto()"> +Agregar Producto</button>
    <br><br>
    <button type="submit">Guardar Factura</button>
</form>

<h2>Listado de Facturas</h2>
<table border="1">
<thead>
    <tr>
        <th>ID Factura</th>
        <th>Cliente</th>
        <th>CUIL</th>
        <th>Fecha</th>
        <th>Total</th>
        <th>Eliminar</th>
    </tr>
</thead>
<tbody>
    <?php
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>{$row['idfactura']}</td>";
            echo "<td>{$row['nombre']} {$row['apellido']}</td>";
            echo "<td>{$row['cuil']}</td>";
            echo "<td>" . date("Y-m-d", strtotime($row['fecha'])) . "</td>";
            echo "<td>$" . number_format($row['total_item'], 2) . "</td>";
            echo "<td>
                <form method='post' style='display:inline;'>
                    <input type='hidden' name='eliminar' value='{$row['idfactura']}'>
                    <button type='submit' class='btn-eliminar' onclick='return confirm(\"¿Seguro que deseas eliminar esta factura?\");'>
                        Eliminar
                    </button>
                </form>
            </td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='6'>No hay facturas</td></tr>";
    }
    ?>
</tbody>
</table>


<button class="btn-volver">
<a href="listarFacturas.php">Ver facturas</a> </button>



<button class="btn-volver">
<a href="index.php">Volver al inicio</a> </button>

<script>
function agregarProducto() {
    const container = document.getElementById("productos-container");
    const nuevaFila = container.querySelector(".producto-row").cloneNode(true);
    nuevaFila.querySelector("input").value = ""; // limpiar cantidad
    container.appendChild(nuevaFila);
}

function eliminarFila(btn) {
    const container = document.getElementById("productos-container");
    if (container.querySelectorAll(".producto-row").length > 1) {
        btn.parentElement.remove();
    } else {
        alert("Debe haber al menos un producto en la factura");
    }
}
</script>

<?php $conn->close(); ?>