<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once 'clases/db/conexion.php'; // -> $conn a db

// if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["eliminar"], $_POST["idproducto"])) {
//     $id = $_POST["idproducto"];
//     $sqlDelete = "DELETE FROM productos WHERE idproducto = $id";
//     if ($conn->query($sqlDelete) === TRUE) {
//         echo "<p style='color:green;'>Producto eliminado correctamente.</p>";
//     } else {
//         echo "<p style='color:red;'>Error al eliminar el producto: " . $conn->error . "</p>";
//     }
// }
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["eliminar"], $_POST["idproducto"])) {
    $id = $_POST["idproducto"];
    $sqlDelete = "DELETE FROM productos WHERE idproducto = $id";
    if ($conn->query($sqlDelete) === TRUE) {
        echo "<p style='color:green;'>Producto eliminado correctamente.</p>";

        // ← Aquí es donde colocás la verificación y reinicio de AUTO_INCREMENT
        $resultCheck = $conn->query("SELECT COUNT(*) AS total FROM productos");
        $rowCheck = $resultCheck->fetch_assoc();
        if ($rowCheck['total'] == 0) {
            $conn->query("ALTER TABLE productos AUTO_INCREMENT = 1");
        }

    } else {
        echo "<p style='color:red;'>Error al eliminar el producto: " . $conn->error . "</p>";
    }
}

// 2️⃣ Procesar inserción de producto
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["nombre"], $_POST["descripcion"], $_POST["precio"])) {
    $nombre      = $_POST["nombre"];
    $descripcion = $_POST["descripcion"];
    $precio      = $_POST["precio"];

    $sql = "INSERT INTO productos (nombre, descripcion, precio) 
            VALUES ('$nombre', '$descripcion', '$precio')";

    if ($conn->query($sql) === TRUE) {
        echo "<p style='color:green;'>Producto cargado correctamente.</p>";
    } else {
        echo "<p style='color:red;'>Error al cargar el producto: " . $conn->error . "</p>";
    }
}

// 3️⃣ Consultar todos los productos
$result = $conn->query("SELECT * FROM productos");

?>

<link rel="stylesheet" href="css/estilo.css">

<h2>Cargar Producto</h2>
<form method="post">
    <label>Nombre:</label><input name="nombre" required>
    <label>Descripción:</label><input name="descripcion" required>
    <label>Precio:</label><input name="precio" type="number" step="0.01" required>
    <button type="submit">Añadir producto</button>
</form>

<h2>Lista de Productos</h2>
<table border="1">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Precio</th>
            <th>Editar</th>
            <th>Eliminar</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if ($result && $result->num_rows > 0) {
            foreach ($result as $row) {
                echo "<tr>";
                echo "<td>" . $row['idproducto'] . "</td>";
                echo "<td>" . $row['nombre'] . "</td>";
                echo "<td>" . $row['descripcion'] . "</td>";
                echo "<td>" . $row['precio'] . "</td>";
               
                //boton editar
                echo "<td>
                    <form action='editarProducto.php' method='get' style='display:inline;'>
                        <input type='hidden' name='idproducto' value='" . $row['idproducto'] . "'>
                        <button type='submit' class='btn-editar'>
                            Editar
                        </button>
                    </form>
                </td>";
               
               
                echo "<td>
                        <form method='post' style='display:inline;'>
                            <input type='hidden' name='idproducto' value='" . $row['idproducto'] . "'>
                            <button type='submit' name='eliminar' class='btn-eliminar'  onclick='return confirm(\"¿Seguro que querés eliminar este producto?\");'>
                               Eliminar
                            </button>
                        </form>
                      </td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No hay productos</td></tr>";
        }
        ?>
    </tbody>
</table>

<button class="btn-volver">
<a href="index.php">Volver</a> </button>

<?php
$conn->close();
?>
