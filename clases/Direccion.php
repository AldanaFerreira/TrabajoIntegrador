<?php
class Direccion {
    private $calle
    private $numero
    private $piso, 
    private $depto,
    private $localidad, 
    private $cp, 
    private $provincia;

    public function __construct($calle, $numero, $piso, $depto, $localidad, $cp, $provincia) {
        $this->calle = $calle;
        $this->numero = $numero;
        $this->piso = $piso;
        $this->depto = $depto;
        $this->localidad = $localidad;
        $this->cp = $cp;
        $this->provincia = $provincia;
    }

    public function imprimir() {
        return "{$this->calle} {$this->numero}, Piso {$this->piso} Dpto {$this->depto}, {$this->localidad}, CP {$this->cp}, {$this->provincia}";
    }
}
?>

