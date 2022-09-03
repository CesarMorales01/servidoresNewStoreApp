<?php
include('pojo_productos.php');
include('pojo_clientes.php');
include('pojo_compras.php');

function conectar(){
    $hostname_localhost ="localhost";
    $database_localhost ="u629086351_mirey";
    $username_localhost ="u629086351_cesar";
    $password_localhost ="Pokemongo2019";
    $mysql=new mysqli($hostname_localhost,$username_localhost,$password_localhost,$database_localhost);
    if($mysql->connect_error)die('Problemas con la conexión...');
    return $mysql;
}


function getDatosCliente($usu, $clave){
    $conn = conectar();
    $usu="'".$usu."'";
    $clave="'".$clave."'";
    $consulta="SELECT * from crear_clave where correo=$usu or cedula=$usu and clave=$clave";
    $arrayList=[];
    $prod=new pojoCliente();
    $resultado=$conn->query($consulta);
	if($reg=$resultado->fetch_array()){ 
        $prod->setCedula($reg['cedula']);
        $prod->setUsuario($reg['usuario']);
        $prod->setCorreo($reg['correo']);
        $prod->setClave($reg['clave']);
        $prod->setFechaIngreso($reg['fecha_ingreso']); 
        if($reg['cedula']!=''){
            $datosCliente=getClienteByCedula($reg['cedula']);
            $prod->setCedula($reg['cedula']);
            $prod->setNombre($datosCliente->nombre);
            $prod->setApellidos($datosCliente->apellidos);
            $prod->setDireccion($datosCliente->direccion);
            $prod->setInfoDir($datosCliente->info_direccion);
            $prod->setOtros($datosCliente->otros);

                /*
                if($reg1['ciudad']!=null){
                    $ciudad=getCiudad($reg1['ciudad']);
                    $prod->setCiudad($ciudad[0]->nombre);
                    $prod->setDepartamento($ciudad[0]->descripcion);
                }
                    $consultarTelefonos="SELECT * from telefonos_clientes where cedula=$prod->cedula";   
                    $set_consulta=$conn->query($consultarTelefonos);
                    $lista=[];
                    while($get_i=$set_consulta->fetch_array()){
                        $lista[]=$get_i['telefono'];
                    }
                $prod->setTelefonos($lista);  
                */
              
        }   
    }else{
        $prod->setNombre('');  
    }
    $arrayList[]=$prod;
    $conn -> close();
    return $arrayList;    	  
}

function getClienteByCedula($ced){
    $conn = conectar();
    $prod=new pojoCliente();
    $consulta1="SELECT * from clientes where cedula=$ced";  
            $resultado1=$conn->query($consulta1);
            if($reg1=$resultado1->fetch_array()){ 
                $prod->setCedula($reg1['cedula']);
                $prod->setNombre($reg1['nombre']);
                $prod->setApellidos($reg1['apellidos']);
                $prod->setDireccion($reg1['direccion']);
                $prod->setInfoDir($reg1['info_direccion']);
                $prod->setOtros($reg1['otros']);

            }
    return $prod;        
}

$result=getDatosCliente('1098776185', '4321');
echo json_encode($result);
?>