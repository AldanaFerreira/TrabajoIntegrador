<?php
class Producto {
    private int $identificador;
    private string $nombre;
    private string $descripcion;
    private float $precio;

    public function __construct(int $id, string $nombre, string $descripcion, float $precio) {
        $this->identificador = $id;
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
        $this->precio = $precio;
    }

    public function getId() : int 
    {
        return $this->identificador;
    }

    public function setId(int $id) : self
    {
        $this->identificador = $id;
        return $this;
    }

    public function getNombre() : string 
    {
        return $this->nombre; 
    }
    public function setNombre(string $nombre) : self
    {
        $this->nombre = $nombre;
        return $this;
    }

    public function getDescripcion() : string 
    {
        return $this->descripcion;
    }
    
    public function setDescripcion(string $descripcion) : self
    {
        $this->descripcion = $descripcion;
        return $this;
    }

    public function getPrecio() : float 
     { return $this->precio; }

    public function imprimir() {
        return "{$this->nombre} - {$this->descripcion} - \$" . number_format($this->precio, 2);
    }
}
?>
