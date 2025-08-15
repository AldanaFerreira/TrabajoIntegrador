<?php
include 'datos/datos.php';
include 'clases/Cliente.php';
include 'clases/Telefono.php';
include 'clases/Direccion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cliente = new Cliente($_POST["nombre"], $_POST["apellido"], $_POST["cuil"]);

    // Teléfonos
    for ($i = 0; $i < count($_POST["tel_tipo"]); $i++) {
        $tel = new Telefono($_POST["tel_tipo"][$i], $_POST["tel_codigo"][$i], $_POST["tel_numero"][$i]);
        $cliente->agregarTelefono($tel);
    }

    // Direcciones
    for ($i = 0; $i < count($_POST["dir_calle"]); $i++) {
        $dir = new Direccion(
            $_POST["dir_calle"][$i], $_POST["dir_numero"][$i], $_POST["dir_piso"][$i],
            $_POST["dir_depto"][$i], $_POST["dir_localidad"][$i],
            $_POST["dir_cp"][$i], $_POST["dir_provincia"][$i]
        );
        $cliente->agregarDireccion($dir);
    }

    $_SESSION["clientes"][] = $cliente;
    echo "<p>Cliente cargado correctamente.</p>";
}
?>

<link rel="stylesheet" href="css/estilo.css">
<h2>Cargar Cliente</h2>
<form method="post">
    <label>Nombre:</label><input name="nombre" required>
    <label>Apellido:</label><input name="apellido" required>
    <label>CUIL:</label><input name="cuil" required>

    <h3>Teléfonos</h3>
    <div>
        <label>Tipo:</label><input name="tel_tipo[]" required>
        <label>Código:</label><input name="tel_codigo[]" required>
        <label>Número:</label><input name="tel_numero[]" required>
    </div>

    <h3>Direcciones</h3>
    <div>
        <label>Calle:</label><input name="dir_calle[]" required>
        <label>Número:</label><input name="dir_numero[]" required>
        <label>Piso:</label><input name="dir_piso[]">
        <label>Depto:</label><input name="dir_depto[]">
        <label>Localidad:</label><input name="dir_localidad[]" required>
        <label>CP:</label><input name="dir_cp[]" required>
        <label>Provincia:</label><input name="dir_provincia[]" required>
    </div>

    <button type="submit">Guardar Cliente</button>
</form>
<a href="index.php">Volver</a>
