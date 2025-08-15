<?php

$host = "localhost";
$usuario = "root";
$contraseña = "aldu123";
$basedatos = "tpintegrador";

$conn = new mysqli($host, $usuario, $contraseña, $basedatos);///conn ess para hacer consultas

if($conn->connect_error) {
    die("Error de coneión: " .
    $conn->connect_error);
}



?>