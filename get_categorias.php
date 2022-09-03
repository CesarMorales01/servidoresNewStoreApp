<?php
include('remoteAccess.php');
header('Content-Type: application/json');

include('consultar_dataBase.php');
$code=$_REQUEST['code'];

if($code=='cate'){
    getCategorias();
}

function getCategorias(){
    $arrayC=cargarCategorias();
    echo json_encode($arrayC);
}

if($code=='promo'){
    getPromos();
}

function getPromos(){
    $arrayC=cargarPromos();
    echo json_encode($arrayC);
}

if($code=='borrarCate'){
    borrarCate();
}

function borrarCate(){
   $respuesta=new stdClass(); 
   $dir_subida = $_SERVER['DOCUMENT_ROOT'].'/'.$_REQUEST['imagen'];
   $borrarImg=unlink($dir_subida);
   if($borrarImg){
    $respuesta->directorio='Imagen eliminada';
   }else{
    $respuesta->directorio='Problemas al eliminar imagen';
   } 
   $respuesta->baseDatos=deleteCate($_REQUEST['id']);
   echo json_encode($respuesta);
}

if($code=='ingresarCategoria'){
    ingresarCate();
}

function ingresarCate(){
    $dir_subida = $_SERVER['DOCUMENT_ROOT']."/ImagenesCategorias/".$_FILES['foto']['name'];
    $file_temp= $_FILES['foto']['tmp_name'];
    $respuesta=new stdClass();
    $upload= move_uploaded_file($file_temp, $dir_subida);
    if($upload){
        $respuesta->directorio='Imagen en directorio';
    }else{
        $respuesta->directorio='Problemas al subir la Imagen a directorio';
    }
    $respuesta->baseDatos=ingresarCategoria($_REQUEST['nombre'], $_REQUEST['imagen']);
    echo json_encode($respuesta);
}
?>