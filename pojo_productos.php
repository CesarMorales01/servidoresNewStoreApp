<?php
class pojoProducto{
    public $nombre, $codigo, $referencia, $descripcion, $precio, $categoria, $imagen, $cantidad, $otros, $otros1, $otros2;
    public $listaImagenes=[];
    
    public function setOtros($i){
        $this->otros=$i;
    }

    public function setOtros1($i){
        $this->otros1=$i;
    }

    public function setOtros2($i){
        $this->otros2=$i;
    }

    public function setListaImagenes($lista){
        $this->listaImagenes=$lista;
    }

    public function setNombre($name){
        $this->nombre=$name;
    }

    public function setCodigo($cod){
        $this->codigo=$cod;
    }


    public function setRef($ref){
        $this->referencia=$ref;
    }


    public function setDescripcion($desc){
        $this->descripcion=$desc;
    }

    public function setPrecio($precio){
        $this->precio=$precio;
    }

    public function setCate($cat){
        $this->categoria=$cat;
    }


    public function setImagen($img){
        $this->imagen=$img;
    }

    public function setCantidad($i){
        $this->cantidad=$i;
    }

}

?>