<?php
class LineaDePedido {
    private $producto;
    private $cantidad;

    public function __construct($producto, $cantidad) {
        $this->producto = $producto;
        $this->cantidad = $cantidad;
    }

    public function calcularSubtotal() {
        return $this->producto->getPrecio() * $this->cantidad;
    }

    public function imprimir() {
        return $this->producto->imprimir() . " - Cantidad: {$this->cantidad} - Subtotal: $" . number_format($this->calcularSubtotal(), 2);
    }
}
?>

