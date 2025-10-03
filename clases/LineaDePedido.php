<?php
class LineaDePedido {
    private Producto $producto;
    private int $cantidad;

    public function __construct(Producto $producto, int $cantidad) {
        $this->producto = $producto;
        $this->cantidad = $cantidad;
    }

    public function getProducto() : Producto {
        return $this->producto;
    }

    public function setProducto(Producto $producto) : self {
        $this->producto = $producto;
        return $this;
    }

    public function getCantidad() : int {
        return $this->cantidad;
    }

    public function setCantidad(int $cantidad) : self {
        $this->cantidad = $cantidad;
        return $this;
    }

    public function calcularSubtotal() {
        return $this->producto->getPrecio() * $this->cantidad;
    }

    public function imprimir() {
        return $this->producto->imprimir() . " - Cantidad: {$this->cantidad} - Subtotal: $" . number_format($this->calcularSubtotal(), 2);
    }
}   
?>

