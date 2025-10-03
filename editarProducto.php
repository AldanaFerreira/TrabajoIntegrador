<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once 'clases/db/conexion.php';

$mensaje = "";

// Validar ID
if (!isset($_GET['idproducto'])) {
    die("ID de producto no especificado.");
}

$id = $_GET['idproducto'];

// Guardar cambios si enviaron el form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre      = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio      = $_POST['precio'];

    $sqlUpdate = "UPDATE productos SET nombre = ?, descripcion = ?, precio = ? WHERE idproducto = ?";
    $stmt = $conn->prepare($sqlUpdate);
    $stmt->bind_param("ssdi", $nombre, $descripcion, $precio, $id);

    if ($stmt->execute()) {
        $mensaje = "<p style='color:green;'>Producto actualizado correctamente.</p>";
    } else {
        $mensaje = "<p style='color:red;'>Error al actualizar el producto: " . $conn->error . "</p>";
    }
}

// Traer producto actual
$sql = "SELECT * FROM productos WHERE idproducto = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$producto = $stmt->get_result()->fetch_assoc();

if (!$producto) {
    die("Producto no encontrado.");
}
?>

<link rel="stylesheet" href="css/estilo.css">

<h2>Editar Producto</h2>
<?= $mensaje ?>

<form method="post">
    <!-- <label>ID:</label>
    <input type="text" value="<?= $producto['idproducto'] ?>" disabled><br> -->

    <label>Nombre:</label>
    <input type="text" name="nombre" value="<?= $producto['nombre'] ?>" required><br>

    <label>Descripción:</label>
    <input type="text" name="descripcion" value="<?= $producto['descripcion'] ?>" required><br>

    <label>Precio:</label>
    <input type="number" step="0.01" name="precio" value="<?= $producto['precio'] ?>" required><br>

    <button type="submit">Guardar cambios</button>
</form>

<a href="cargarProducto.php">Volver</a>
