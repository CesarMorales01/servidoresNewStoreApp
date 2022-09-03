<?php
class pojoCompras{
    public $id, $cliente, $compra_n, $fecha, $total_compra, $descripcion_credito,
    $n_cuotas, $periodicidad, $domicilio, $medio_de_pago, $comentarios, $cambio,
    $estado, $vendedor;
    public $listaProductos=[];

    public function setListaProductos($val){
        $this->listaProductos=$val;
    }

    public function setVendedor($val){
        $this->vendedor=$val;
    }

    public function setEstado($val){
        $this->estado=$val;
    }

    public function setCambio($val){
        $this->cambio=$val;
    }

    public function setComentarios($val){
        $this->comentarios=$val;
    }

    public function setMedioPago($val){
        $this->medio_de_pago=$val;
    }

    public function setDomicilio($val){
        $this->domicilio=$val;
    }

    public function setPeriodicidad($val){
        $this->periodicidad=$val;
    }

    public function setNcuotas($val){
        $this->n_cuotas=$val;
    }

    public function setDescripcionCredito($val){
        $this->descripcion_credito=$val;
    }

    public function setTotalCompra($val){
        $this->total_compra=$val;
    }

    public function setFecha($val){
        $this->fecha=$val;
    }

    public function setCompraN($val){
        $this->compra_n=$val;
    }

    public function setId($val){
        $this->id=$val;
    }

    public function setCliente($val){
        $this->cliente=$val;
    }

    
}
?>