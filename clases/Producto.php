<?php
class Producto {
    private $identificador;
    private $nombre;
    private $descripcion;
    private $precio;

    public function __construct($id, $nombre, $descripcion, $precio) {
        $this->identificador = $id;
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
        $this->precio = $precio;
    }

    public function getId() { return $this->identificador; }
    public function getNombre() { return $this->nombre; }
    public function getDescripcion() { return $this->descripcion; }
    public function getPrecio() { return $this->precio; }

    public function imprimir() {
        return "{$this->nombre} - {$this->descripcion} - \$" . number_format($this->precio, 2);
    }
}
?>
