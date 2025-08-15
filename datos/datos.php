<?php
session_start();

if (!isset($_SESSION["productos"])) $_SESSION["productos"] = [];
if (!isset($_SESSION["clientes"])) $_SESSION["clientes"] = [];
if (!isset($_SESSION["facturas"])) $_SESSION["facturas"] = [];
?>
