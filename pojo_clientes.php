<?php
class pojoCliente{
    public $cedula, $fecha_ingreso, $nombre, $apellidos, $direccion, $info_direccion,
    $ciudad, $departamento, $usuario, $correo, $clave, $otros;
    public $telefonos=[];

    public function setTelefonos($tels){
        $this->telefonos=$tels;
    }

    public function setCedula($ced){
        $this->cedula=$ced;
    }

    public function setFechaIngreso($fecha){
        $this->fecha_ingreso=$fecha;
    }


    public function setNombre($n){
        $this->nombre=$n;
    }


    public function setApellidos($a){
        $this->apellidos=$a;
    }

    public function setDireccion($d){
        $this->direccion=$d;
    }

    public function setInfoDir($i){
        $this->info_direccion=$i;
    }


    public function setCiudad($c){
        $this->ciudad=$c;
    }
    public function setDepartamento($d){
        $this->departamento=$d;
    }

    public function setUsuario($d){
        $this->usuario=$d;
    }

    public function setCorreo($t){
        $this->correo=$t;
    }

    public function setClave($d){
        $this->clave=$d;
    }

    public function setOtros($o){
        $this->otros=$o;
    }
}
?>