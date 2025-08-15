<?php
class Telefono {
    private $tipo;
    private $codigo;
    private $numero;

    public function __construct($tipo, $codigo, $numero) {
        $this->tipo = $tipo;
        $this->codigo = $codigo;
        $this->numero = $numero;
    }

    public function imprimir() {
        return "{$this->tipo}: ({$this->codigo}) {$this->numero}";
    }
}
?>

