<?php
class Factura {
    private $id;
    private $fecha;
    private $cliente;
    private $lineas = [];

    public function __construct($id, $fecha, $cliente) {
        $this->id = $id;
        $this->fecha = $fecha;
        $this->cliente = $cliente;
    }

    public function agregarLinea($linea) {
        $this->lineas[] = $linea;
    }

    public function calcularTotal() {
        $total = 0;
        foreach ($this->lineas as $l) {
            $total += $l->calcularSubtotal();
        }
        return $total;
    }

    public function getId() { return $this->id; }
    public function getFecha() { return $this->fecha; }
    public function getCliente() { return $this->cliente; }
    public function getLineas() { return $this->lineas; }
}
?>

