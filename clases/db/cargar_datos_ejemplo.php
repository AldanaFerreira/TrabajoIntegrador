<?php
// Incluir conexión
include 'conexion.php';

echo "<h2>Insertando datos en MySQL</h2>";
echo "<p>Verificando conexión...</p>";

// Verificar conexión
if ($conn->connect_error) {
    die("❌ Error de conexión: " . $conn->connect_error);
}
echo "✅ Conexión exitosa<br><br>";

// 1. INSERTAR UN PRODUCTO SIMPLE
echo "<h3>1. Insertando producto...</h3>";
$sql = "INSERT INTO producto (nombre, descripcion, precio, stock) VALUES ('Notebook Test', 'Producto de prueba', 10000.00, 5)";

if ($conn->query($sql) === TRUE) {
    echo "✅ Producto insertado correctamente<br>";
} else {
    echo "❌ Error insertando producto: " . $conn->error . "<br>";
}

// 2. INSERTAR UN CLIENTE SIMPLE
echo "<h3>2. Insertando cliente...</h3>";
$sql2 = "INSERT INTO cliente (nombre, apellido, cuil) VALUES ('Juan', 'Perez', '20123456789')";

if ($conn->query($sql2) === TRUE) {
    echo "✅ Cliente insertado correctamente<br>";
    $id_cliente = $conn->insert_id; // Obtener el ID del cliente insertado
    echo "ID del cliente: " . $id_cliente . "<br>";
    
    // 3. INSERTAR TELÉFONO PARA ESTE CLIENTE
    echo "<h3>3. Insertando teléfono...</h3>";
    $sql3 = "INSERT INTO telefono (id_cliente, tipo, codigo_area, numero) VALUES ($id_cliente, 'movil', '011', '12345678')";
    
    if ($conn->query($sql3) === TRUE) {
        echo "✅ Teléfono insertado correctamente<br>";
    } else {
        echo "❌ Error insertando teléfono: " . $conn->error . "<br>";
    }
    
    // 4. INSERTAR DIRECCIÓN PARA ESTE CLIENTE
    echo "<h3>4. Insertando dirección...</h3>";
    $sql4 = "INSERT INTO direccion (id_cliente, calle, numero, localidad, codigo_postal, provincia) VALUES ($id_cliente, 'Av. Test', '123', 'José C. Paz', '1665', 'Buenos Aires')";
    
    if ($conn->query($sql4) === TRUE) {
        echo "✅ Dirección insertada correctamente<br>";
    } else {
        echo "❌ Error insertando dirección: " . $conn->error . "<br>";
    }
    
} else {
    echo "❌ Error insertando cliente: " . $conn->error . "<br>";
}

// 5. VERIFICAR QUE SE INSERTARON LOS DATOS
echo "<h3>5. Verificando datos insertados...</h3>";

$tablas = ['producto', 'cliente', 'telefono', 'direccion'];

foreach($tablas as $tabla) {
    $sql_count = "SELECT COUNT(*) as total FROM $tabla";
    $resultado = $conn->query($sql_count);
    
    if ($resultado) {
        $fila = $resultado->fetch_assoc();
        echo "📊 Tabla '$tabla': " . $fila['total'] . " registros<br>";
    } else {
        echo "❌ Error consultando tabla $tabla: " . $conn->error . "<br>";
    }
}

echo "<br><h3>🎉 Proceso completado!</h3>";
echo "<p>Si ves mensajes ✅ arriba, los datos se insertaron correctamente.</p>";
echo "<p>Ahora puedes ir a phpMyAdmin y verificar las tablas.</p>";

$conn->close();
?>