<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
include 'datos/datos.php';
include 'clases/Producto.php';
// include_once 'clases/db/conexion.php';

// $sql = "INSERT INTO producto (id, nombre, descripcion, precio) VALUES ('$id', '$nombre', '$descripcion', '$precio')"; 

// if ($conn->query($sql) === TRUE) {
//     echo "Producto cargado correctamente.";
// } else {
//     echo "Error al cargar el producto: " . $conn->error;
// }

// if ($_SERVER["REQUEST_METHOD"] == "POST") {
//     $producto = new Producto($_POST["id"], $_POST["nombre"], $_POST["descripcion"], $_POST["precio"]);
//     $_SESSION["productos"][] = $producto;
//     echo "<p>Producto agregado correctamente.</p>";
// }
?>

<link rel="stylesheet" href="css/estilo.css">
<h2>Cargar Producto</h2>
<form method="post">
    <label>ID:</label><input name="id" required>
    <label>Nombre:</label><input name="nombre" required>
    <label>Descripción:</label><input name="descripcion">
    <label>Precio:</label><input name="precio" type="number" step="0.01" required>
    <button type="submit">Añadir producto</button>
</form>
 <div id="listaProductos" class="hidden">
      <h2>Lista de Productos</h2>
      <table>
        <thead>
          <tr><th>Id producto</th><th>Nombre</th><th>Descripción</th><th>Precio</th></tr>
        </thead>
        <tbody id="tablaProductos"></tbody>
      </table>
    </div>
<a href="index.php">Volver</a>