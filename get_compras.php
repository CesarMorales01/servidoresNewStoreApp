<?php
include('remoteAccess.php');
header('Content-Type: application/json');
include('consultar_dataBase.php');

$modo=$_REQUEST['modo'];

if($modo=='ingresarCompra'){
   nuevaCompra();
}

function nuevaCompra(){
    $datos = json_decode(file_get_contents('php://input'));
    $result=ingresarCompra($datos);
    echo json_encode($result); 
}

if($modo=='getCompras'){
    getCompras();
 }
 
 function getCompras(){
     $cedula=$_REQUEST['cedula']; 
     $result=obtenerCompras($cedula);
     echo json_encode($result); 
 }
// Al consultar una referencia se debe guardar al mismo tiempo ya que si a  otro cliente 
//se le da la misma dará error en el pago...
 if($modo=='refWompi'){
    getRefWompi();
 }
 
 function getRefWompi(){
     $result=getIdWompi();
     saveRefWompi($result);
 }

 function saveRefWompi($result){
    $array=[];
    $array[]=$_REQUEST['cliente'];
    $array[]=$_REQUEST['totalVenta'];
    $array[]=$_REQUEST['fecha'];
    $array[]=$result[0]->id;
    $array[]=$_REQUEST['estado'];
    $resultado=guardarRefWompi($array);
    echo json_encode($resultado);
 }

 if($modo=='validarPago'){
    checkValidarPago();
 }

 function checkValidarPago(){
    $ref=$_REQUEST['ref'];
    $resultado=validarEstadoPago($ref);
    echo json_encode($resultado);
 }

if($modo=='getLista'){
   getLista();
}

function getLista(){
   $resultado=getListaCompras();
   echo json_encode($resultado);
}

if($modo=='getNCompra'){
   getListaProductosComprados();
}

function getListaProductosComprados(){
   $cedula=$_REQUEST['cedula'];
   $n=$_REQUEST['n_compra'];
   $resultado=obtenerProductosComprados($cedula, $n);
   echo json_encode($resultado);
}

if($modo=='cambioEstado'){
   cambioEstado();
}

function cambioEstado(){
   $resultado=cambioEstadoCompra($_REQUEST['id'], $_REQUEST['estado']);
   echo json_encode($resultado);
}

if($modo=='borrarCompra'){
   borrarCompra();
}

function borrarCompra(){
   $resultado=deleteCompra($_REQUEST['id'], $_REQUEST['compraN'], $_REQUEST['cliente']);
   echo json_encode($resultado);
}

if($modo=='ingresarCompraAdmin'){
   ingresarCompraAdmin();
}

function ingresarCompraAdmin(){
    $datos = json_decode(file_get_contents('php://input'));
    $result=registrarCompraAdmin($datos);
    echo json_encode($result); 
}
?>