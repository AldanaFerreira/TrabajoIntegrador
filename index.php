<?php

?>


<link rel="stylesheet" href="css/estilo.css">
<h1>Aplicación Web de Facturación</h1>
<ul>
    <li><a href="cargarProducto.php">Cargar Producto</a></li>
    <li><a href="cargarCliente.php">Cargar Cliente</a></li>
    <li><a href="cargarFactura.php">Cargar Factura</a></li>
    <li><a href="listarFacturas.php">Listar Facturas</a></li>
    <li><a href="editarCliente.php?cuil=<?= $cliente['cuil'] ?>">Editar</a></li> 
    <li><a href="editarProducto.php?id=<?= $producto['idproducto'] ?>">Editar</a></li>

</ul>
