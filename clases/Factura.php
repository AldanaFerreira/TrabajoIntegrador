<?php
class Factura {
    private Int $id;
    private DateTime $fecha;
    private Cliente $cliente;
    private Array $lineas = [];

    public function __construct(int $id, DateTime $fecha, Cliente $cliente) {
        $this->id = $id;
        $this->fecha = $fecha;
        $this->cliente = $cliente;
    }

    public function agregarLinea($linea)
    {
        $this->lineas[] = $linea;
    }

    public function getId() : int
    {
        return $this->id; 
    }

    public function setId(int $id) : self
    {
        $this->id = $id;
        return $this;
    }

    public function getFecha() : DateTime
    { 
        return $this->fecha; 
    }

    public function setFecha(DateTime $fecha) : self
    {
        $this->fecha = $fecha;
        return $this;
    }

    public function getCliente() : Cliente
    {
        return $this->cliente; 
    }
    public function setCliente(Cliente $cliente) : self
    {
        $this->cliente = $cliente;
        return $this;
    }

    public function getLineas() : array 
    { 
        return $this->lineas;
    }

    public function setLineas(array $lineas) : self
    {
        $this->lineas = $lineas;
        return $this;
    }

    public function calcularTotal() {
        $total = 0;
        foreach ($this->lineas as $l) {
            $total += $l->calcularSubtotal();
        }
        return $total;
    }


}
?>

