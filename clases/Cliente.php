<?php
class Cliente {
    private String $cuil;
    private String $nombre;
    private String $apellido;
    private Telefono $telefonos = [];
    private Direccion $direcciones = [];

    public function __construct(string $nombre, string $apellido, string $cuil) {
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->cuil = $cuil;
    }

    public function agregarTelefono($telefono) 
    {
        $this->telefonos[] = $telefono;
    }

    public function agregarDireccion($direccion)
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

    public function getTelefonos() : Telefono
    {
        return $this->telefonos; 
    }

    public function getDirecciones() : Direccion
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
    }

    public function setApellido($apellido) : self
    {
        $this->apellido = $apellido;
    }

    public function setCuil($cuil) : self
    {
        $this->cuil = $cuil; 
    }

}
?>

