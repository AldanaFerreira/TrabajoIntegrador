<?php
class Telefono {
    private string  $tipo;
    private string $codigo;
    private string $numero;

    public function __construct(string $tipo, string $codigo, string $numero) {
        $this->tipo = $tipo;
        $this->codigo = $codigo;
        $this->numero = $numero;
    }

    public function getTipo() : string
    {
        return $this->tipo;
    }

    public function setTipo(string $tipo) : self
    {
        $this->tipo = $tipo;
        return $this;
    }
    public function getCodigo() : string
    {
        return $this->codigo;
    }       
    
    public function setCodigo(string $codigo) : self
    {
        $this->codigo = $codigo;
        return $this;
    }

    public function getNumero() : string
    {
        return $this->numero;
    }

    public function setNumero(string $numero) : self
    {
        $this->numero = $numero;
        return $this;
    }

    public function imprimir() {
        return "{$this->tipo}: ({$this->codigo}) {$this->numero}";
    }
}
?>
