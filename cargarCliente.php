<?php
// require_once 'datos/datos.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'clases/Cliente.php'; 
require_once 'clases/Telefono.php';
require_once 'clases/Direccion.php';
require_once 'clases/db/conexion.php';


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["eliminar"], $_POST["cuil"])) {
    $id = $_POST["cuil"];

    // Primero borramos hijos
    $conn->query("DELETE FROM telefonos WHERE cuil = '$id'");
    $conn->query("DELETE FROM direcciones WHERE cuil = '$id'");

    // Luego cliente
    $sqlDelete = "DELETE FROM clientes WHERE cuil = '$id'";
    if ($conn->query($sqlDelete) === TRUE) {
        echo "<p style='color:green;'>Cliente eliminado correctamente.</p>";
    } else {
        echo "<p style='color:red;'>Error al eliminar el cliente: " . $conn->error . "</p>";
    }
}


// 2️⃣ Insertar nuevo cliente
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["nombre"], $_POST["apellido"], $_POST["cuil"]) && !isset($_POST["eliminar"])) {
    $nombre   = $_POST["nombre"];
    $apellido = $_POST["apellido"];
    $cuil     = $_POST["cuil"];

    $cliente = new Cliente($nombre, $apellido, $cuil);

        // 👉 Validar si ya existe el cliente
    $check = $conn->query("SELECT * FROM clientes WHERE cuil='$cuil'");
    if ($check && $check->num_rows > 0) {
        echo "<p style='color:red;'>Error: Ya existe un cliente con ese CUIL.</p>";
    } else {
        // Insertar cliente
        $sql = "INSERT INTO clientes (cuil, nombre, apellido) 
                VALUES ('$cuil', '$nombre', '$apellido')";
        if ($conn->query($sql) === TRUE) {
            echo "<p style='color:green;'>Cliente cargado correctamente.</p>";

        // 👉 Insertar teléfonos
        if (!empty($_POST["tel_tipo"])) {
            for ($i = 0; $i < count($_POST["tel_tipo"]); $i++) {
                if (!empty($_POST["tel_tipo"][ $i ]) && !empty($_POST["tel_numero"][ $i ])) {
                    $tipo   = $_POST["tel_tipo"][ $i ];
                    $codigo = $_POST["tel_codigo"][ $i ];
                    $numero = $_POST["tel_numero"][ $i ];

                    $sqlTel = "INSERT INTO telefonos (cuil, tipo, codigo_area, numero) 
                               VALUES ('$cuil','$tipo','$codigo','$numero')";
                    $conn->query($sqlTel);
                }
            }
        }

        // 👉 Insertar direcciones
        if (!empty($_POST["dir_calle"])) {
            for ($i = 0; $i < count($_POST["dir_calle"]); $i++) {
                if (!empty($_POST["dir_calle"][ $i ]) && !empty($_POST["dir_numero"][ $i ])) {
                    $calle     = $_POST["dir_calle"][ $i ];
                    $numero    = $_POST["dir_numero"][ $i ];
                    $piso      = $_POST["dir_piso"][ $i ];
                    $depto     = $_POST["dir_depto"][ $i ];
                    $localidad = $_POST["dir_localidad"][ $i ];
                    $cp        = $_POST["dir_cp"][ $i ];
                    $provincia = $_POST["dir_provincia"][ $i ];

                    $sqlDir = "INSERT INTO direcciones (cuil, calle, numero, piso, depto, localidad, cp, provincia) 
                            VALUES ('$cuil','$calle','$numero','$piso','$depto','$localidad','$cp','$provincia')";
                    $conn->query($sqlDir);
                }
            }
        }
    } else {
        echo "<p style='color:red;'>Error al cargar el cliente: " . $conn->error . "</p>";
    } 
  }
}

// 3️⃣ Consultar clientes
// $result = $conn->query("SELECT * FROM clientes");
//usando el join para atraer los datos de las tablas relacionadas


// 3️⃣ Consultar clientes con JOIN + GROUP_CONCAT
        // $sql = "SELECT c.cuil, c.nombre, c.apellido,
        //             GROUP_CONCAT(CONCAT(t.tipo, ' (', t.codigo_area, ') ', t.numero) SEPARATOR '<br>') AS telefonos,
        //             GROUP_CONCAT(CONCAT(d.calle, ' ', d.numero, 
        //                                 IF(d.piso IS NOT NULL AND d.piso!='', CONCAT(', Piso ', d.piso), ''),
        //                                 IF(d.depto IS NOT NULL AND d.depto!='', CONCAT(' Dpto ', d.depto), ''),
        //                                 ', ', d.localidad, ' (', d.provincia, ') CP: ', d.cp) SEPARATOR '<br>') AS direcciones
        //         FROM clientes c
        //         LEFT JOIN telefonos t ON c.cuil = t.cuil
        //         LEFT JOIN direcciones d ON c.cuil = d.cuil
        //         GROUP BY c.cuil, c.nombre, c.apellido
        //         ORDER BY c.apellido, c.nombre";

        // $result = $conn->query($sql);
        $sql = "SELECT c.cuil, c.nombre, c.apellido,
           (SELECT GROUP_CONCAT(CONCAT(t.tipo, ' (', t.codigo_area, ') ', t.numero) SEPARATOR '<br>')
            FROM telefonos t
            WHERE t.cuil = c.cuil) AS telefonos,
           (SELECT GROUP_CONCAT(CONCAT(d.calle, ' ', d.numero,
                                       IF(d.piso IS NOT NULL AND d.piso!='', CONCAT(', Piso ', d.piso), ''),
                                       IF(d.depto IS NOT NULL AND d.depto!='', CONCAT(' Dpto ', d.depto), ''),
                                       ', ', d.localidad, ' (', d.provincia, ') CP: ', d.cp) SEPARATOR '<br>')
            FROM direcciones d
            WHERE d.cuil = c.cuil) AS direcciones
        FROM clientes c
        ORDER BY c.apellido, c.nombre";

        $result = $conn->query($sql);
        

?>

<link rel="stylesheet" href="css/estilo.css">
<h2>Cargar Cliente</h2>
<form method="post">
    <label>Nombre:</label><input name="nombre" required>
    <label>Apellido:</label><input name="apellido" required>
    <label>CUIL:</label><input name="cuil" required>

    <h3>Teléfono</h3>
    <div>
        <label>Tipo:</label><input name="tel_tipo[]" required>
        <label>Código:</label><input name="tel_codigo[]" required>
        <label>Número:</label><input name="tel_numero[]" required>
    </div>

    <h3>Teléfono 2 (Opcional)</h3>
    <div>
        <label>Tipo:</label><input name="tel_tipo[]">
        <label>Código:</label><input name="tel_codigo[]">
        <label>Número:</label><input name="tel_numero[]">
    </div>
    
    <h3>Dirección</h3>
    <div>
        <label>Calle:</label><input name="dir_calle[]" required>
        <label>Número:</label><input name="dir_numero[]" required>
        <label>Piso:</label><input name="dir_piso[]">
        <label>Depto:</label><input name="dir_depto[]">
        <label>Localidad:</label><input name="dir_localidad[]" required>
        <label>CP:</label><input name="dir_cp[]" required>
        <label>Provincia:</label><input name="dir_provincia[]" required>
    </div>

    <h3>Dirección 2 (Opcional)</h3>
    <div>
        <label>Calle:</label><input name="dir_calle[]">
        <label>Número:</label><input name="dir_numero[]">
        <label>Piso:</label><input name="dir_piso[]">
        <label>Depto:</label><input name="dir_depto[]">
        <label>Localidad:</label><input name="dir_localidad[]">
        <label>CP:</label><input name="dir_cp[]">
        <label>Provincia:</label><input name="dir_provincia[]">
    </div>

    <button type="submit">Guardar Cliente</button>
</form>

<h2>Lista de Clientes</h2>
<table border="1">
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>CUIL</th>
            <th>Teléfono</th>
            <th>Dirección</th>
            <th>Editar</th>
            <th>Eliminar</th>
        </tr>
    </thead>
    <tbody>
<?php
if ($result && $result->num_rows > 0) {
    foreach ($result as $row) {
        echo "<tr>";
        echo "<td>" . $row['nombre'] . "</td>";
        echo "<td>" . $row['apellido'] . "</td>";
        echo "<td>" . $row['cuil'] . "</td>";
        echo "<td>" . ($row['telefonos'] ?: '-') . "</td>";
        echo "<td>" . ($row['direcciones'] ?: '-') . "</td>";

        //boton editar
        echo "<td>
            <form action='editarCliente.php' method='get' style='display:inline;'>
                <input type='hidden' name='cuil' value='" . $row['cuil'] . "'>
                <button type='submit' class='btn-editar'>
                    Editar
                </button>
            </form>
        </td>";

        // btn eliminar
        echo "<td>
                <form method='post' style='display:inline;'>
                    <input type='hidden' name='cuil' value='" . $row['cuil'] . "'>
                    <button type='submit' name='eliminar' class='btn-eliminar' 
                            onclick='return confirm(\"¿Seguro que querés eliminar este cliente?\");'>
                       Eliminar
                    </button>
                </form>
              </td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='6'>No hay clientes</td></tr>";
}
?>
</tbody>
</table>

<button class="btn-volver">
    <a href="index.php">Volver</a>
</button>

<?php
$conn->close();
?>