<?php
require_once 'clases/db/conexion.php';

$mensaje = "";

// if (!isset($_GET['cuil'])) {
//     die("CUIL no especificado.");
// }

$cuil = $_GET['cuil'];


// Si se enviaron cambios
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre   = $_POST['nombre'];
    $apellido = $_POST['apellido'];

    // Actualizar cliente
    $sqlUpdate = "UPDATE clientes SET nombre = ?, apellido = ? WHERE cuil = ?";
    $stmt = $conn->prepare($sqlUpdate);
    $stmt->bind_param("sss", $nombre, $apellido, $cuil);
    $stmt->execute();

    // Borrar teléfonos/direcciones viejos
    $conn->query("DELETE FROM telefonos WHERE cuil = '$cuil'");
    $conn->query("DELETE FROM direcciones WHERE cuil = '$cuil'");

    // Insertar teléfonos nuevos
    if (!empty($_POST['tel_tipo'])) {
        for ($i = 0; $i < count($_POST['tel_tipo']); $i++) {
            if (!empty($_POST['tel_tipo'][$i]) && !empty($_POST['tel_numero'][$i])) {
                $tipo   = $_POST['tel_tipo'][$i];
                $codigo = $_POST['tel_codigo'][$i];
                $numero = $_POST['tel_numero'][$i];

                $sqlTel = "INSERT INTO telefonos (cuil, tipo, codigo_area, numero) 
                           VALUES ('$cuil','$tipo','$codigo','$numero')";
                $conn->query($sqlTel);
            }
        }
    }

    // Insertar direcciones nuevas
    if (!empty($_POST['dir_calle'])) {
        for ($i = 0; $i < count($_POST['dir_calle']); $i++) {
            if (!empty($_POST['dir_calle'][$i]) && !empty($_POST['dir_numero'][$i])) {
                $calle     = $_POST['dir_calle'][$i];
                $numero    = $_POST['dir_numero'][$i];
                $piso      = $_POST['dir_piso'][$i];
                $depto     = $_POST['dir_depto'][$i];
                $localidad = $_POST['dir_localidad'][$i];
                $cp        = $_POST['dir_cp'][$i];
                $provincia = $_POST['dir_provincia'][$i];

                $sqlDir = "INSERT INTO direcciones (cuil, calle, numero, piso, depto, localidad, cp, provincia) 
                           VALUES ('$cuil','$calle','$numero','$piso','$depto','$localidad','$cp','$provincia')";
                $conn->query($sqlDir);
            }
        }
    }

    $mensaje = "<p style='color:green;'>Cliente actualizado correctamente.</p>";
}

// Traer cliente
$sql = "SELECT * FROM clientes WHERE cuil = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $cuil);
$stmt->execute();
$cliente = $stmt->get_result()->fetch_assoc();

// Traer teléfonos
$telefonos = [];
$resTel = $conn->query("SELECT * FROM telefonos WHERE cuil='$cuil'");
if ($resTel) $telefonos = $resTel->fetch_all(MYSQLI_ASSOC);

// Traer direcciones
$direcciones = [];
$resDir = $conn->query("SELECT * FROM direcciones WHERE cuil='$cuil'");
if ($resDir) $direcciones = $resDir->fetch_all(MYSQLI_ASSOC);

?>

<link rel="stylesheet" href="css/estilo.css">

<h2>Editar Cliente</h2>
<?= $mensaje ?>

<form method="post">
    <label>CUIL:</label>
    <input type="text" value="<?= $cliente['cuil'] ?>" ><br>
    <label>Nombre:</label>
    <input type="text" name="nombre" value="<?= $cliente['nombre'] ?>" required><br>
    <label>Apellido:</label>
    <input type="text" name="apellido" value="<?= $cliente['apellido'] ?>" required><br>

    <h3>Teléfono 1</h3>
    <?php foreach ($telefonos as $t): ?>
        <div>
            <label>Tipo:</label><input name="tel_tipo[]" value="<?= $t['tipo'] ?>">
            <label>Código:</label><input name="tel_codigo[]" value="<?= $t['codigo_area'] ?>">
            <label>Número:</label><input name="tel_numero[]" value="<?= $t['numero'] ?>">
        </div>
    <?php endforeach; ?>

    <h3>Teléfono 2</h3>
    <div>
        <label>Tipo:</label><input name="tel_tipo[]">
        <label>Código:</label><input name="tel_codigo[]">
        <label>Número:</label><input name="tel_numero[]">
    </div>

    <h3>Dirección 1</h3>
    <?php foreach ($direcciones as $d): ?>
        <div>
            <label>Calle:</label><input name="dir_calle[]" value="<?= $d['calle'] ?>">
            <label>Número:</label><input name="dir_numero[]" value="<?= $d['numero'] ?>">
            <label>Piso:</label><input name="dir_piso[]" value="<?= $d['piso'] ?>">
            <label>Depto:</label><input name="dir_depto[]" value="<?= $d['depto'] ?>">
            <label>Localidad:</label><input name="dir_localidad[]" value="<?= $d['localidad'] ?>">
            <label>CP:</label><input name="dir_cp[]" value="<?= $d['cp'] ?>">
            <label>Provincia:</label><input name="dir_provincia[]" value="<?= $d['provincia'] ?>">
        </div>
    <?php endforeach; ?>

    <h3>Dirección 2</h3>
    <div>
        <label>Calle:</label><input name="dir_calle[]">
        <label>Número:</label><input name="dir_numero[]">
        <label>Piso:</label><input name="dir_piso[]">
        <label>Depto:</label><input name="dir_depto[]">
        <label>Localidad:</label><input name="dir_localidad[]">
        <label>CP:</label><input name="dir_cp[]">
        <label>Provincia:</label><input name="dir_provincia[]">
    </div>

    <button type="submit">Guardar cambios</button>
</form>


<button class="btn-volver">
<a href="cargarCliente.php">Volver</a>
    </button>