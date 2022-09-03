<?php
include('remoteAccess.php');
header('Content-Type: application/json');

include('consultar_dataBase.php');
$getRequest=$_REQUEST['code'];
if($getRequest=='all'){
    getProductos();
}else{  
   if(is_numeric($getRequest)) {
        getOneProduct($getRequest);
    }else{
        getProductByWord($getRequest);
    }
}

function getProductos(){
    $arrayP= cargarProductos();
    echo json_encode($arrayP);
}

function getOneProduct($id){
   $oneP= cargarUnProducto($id);
   echo json_encode($oneP);
}

function getProductByWord($word){
    $oneP= buscarProductoPalabra($word);
    echo json_encode($oneP);
 }

?>