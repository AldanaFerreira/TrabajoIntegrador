<?php
class Cliente {
    private string $cuil;
    private String $nombre;
    private String $apellido;
    private array $telefonos = [];
    private array $direcciones = [];

    public function __construct(string $nombre, string $apellido, string $cuil) {
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->cuil = $cuil;
    }

    public function agregarTelefono(Telefono $telefono) :  void
    {
        $this->telefonos[] = $telefono;
    }

    public function agregarDireccion(Direccion $direccion) : void
    {
        $this->direcciones[] = $direccion;
    }

    //getters

    public function getNombreCompleto() : string 
    {
        return "{$this->nombre} {$this->apellido}";
    }

    public function getCuil() : string
    {
        return $this->cuil; 
    }

    public function getTelefonos() : array
    {
        return $this->telefonos; 
    }

    public function getDirecciones() : array
    { 
        return $this->direcciones;
    }

    public function getNombre() : string
    {
        return $this->nombre; 
    }

    public function getApellido() : string
    {
        return $this->apellido; 
    }

    //setters
    public function setNombre(String $nombre) : self
    {
        $this->nombre = $nombre; 
        return $this;
    }

    public function setApellido($apellido) : self
    {
        $this->apellido = $apellido;
        return $this;
    }

    public function setCuil($cuil) : self
    {
        $this->cuil = $cuil; 
        return $this;
    }

}
?>

