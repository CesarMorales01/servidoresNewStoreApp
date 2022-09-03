<?php
include('remoteAccess.php');
header('Content-Type: application/json');

include('consultar_dataBase.php');

$modo=$_REQUEST['modo'];

if($modo=='insert'){
    insertCarrito();
}

function insertCarrito(){
    $datos = json_decode(file_get_contents('php://input'));
    $result=IngresarCarrito($datos);
    echo json_encode($result); 
}

if($modo=='getCarrito'){
    getCarrito();
}

function getCarrito(){
    $id=$_REQUEST['id'];
    $result=obtenerCarrito($id);
    echo json_encode($result); 
}

if($modo=='actualizarCantidad'){
    updateCarrito();
}

function updateCarrito(){
    $datos = json_decode(file_get_contents('php://input'));
    $result=actualizarCarrito($datos);
    echo json_encode($result); 
}

if($modo=='borrarCarrito'){
    deleteCarrito();
}

function deleteCarrito(){
    $id=$_REQUEST['id'];
    $cli=$_REQUEST['cliente'];
    $result=borrarCarrito($id, $cli);
    echo json_encode($result); 
}

?>