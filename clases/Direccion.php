<?php
class Direccion {
    private string $calle;
    private string $numero;
    private string $piso;
    private string $depto;
    private string $localidad;
    private string $cp;
    private string $provincia;

    public function __construct(string $calle, string $numero, string $piso, string $depto, string $localidad, string $cp, string $provincia) {
        $this->calle = $calle;
        $this->numero = $numero;
        $this->piso = $piso;
        $this->depto = $depto;
        $this->localidad = $localidad;
        $this->cp = $cp;
        $this->provincia = $provincia;
    }

    public function getCalle() : string
    {
        return $this->calle;
    }
    
    public function setCalle(string $calle) : self
    {
        $this->calle = $calle;
        return $this;
    }

    public function getNumero() : string
    {
        return $this->numero;
    }

    public function setNumero(string $numero) 
    {
        $this->numero = $numero;
        return $this;
    }

    public function getPiso() : string
    {
        return $this->piso;
    }

    public function setPiso(string $piso) 
    {
        $this->piso = $piso;
        return $this;
    }

    public function getDepto() : string
    {
        return $this->depto;
    }
    public function setDepto(string $depto) 
    {
        $this->depto = $depto;
        return $this;
    }

    public function getLocalidad() : string
    {
        return $this->localidad;
    }

    public function setLocalidad(string $localidad) 
    {
        $this->localidad = $localidad;
        return $this;
    }

    public function getCp() : string
    {
        return $this->cp;
    }
    public function setCp(string $cp) 
    {
        $this->cp = $cp;
        return $this;
    }

    public function getProvincia() : string
    {
        return $this->provincia;
    }
    public function setProvincia(string $provincia) 
    {
        $this->provincia = $provincia;
        return $this;
    }

    public function imprimir() {
        return "{$this->calle} {$this->numero}, Piso {$this->piso} Dpto {$this->depto}, {$this->localidad}, CP {$this->cp}, {$this->provincia}";
    }
}
?>

