<?php
include('remoteAccess.php');
header('Content-Type: application/json');

include('consultar_dataBase.php');
$code=$_REQUEST['code'];

if($code=='getPromos'){
    getPromos();
}

function getPromos(){
    $arrayP= cargarPromos();
    echo json_encode($arrayP);
}

if($code=='ingresarPromo'){
    ingresarPromo();
}

function ingresarPromo(){
    $datos=new stdClass();
    $datos->nombre="'".$_REQUEST['nombre']."'";
    $datos->imagen="'".$_REQUEST['imagen']."'";
    $datos->codigo="'".$_REQUEST['codigo']."'";
    $respuesta= new stdClass();
    $respuesta->baseDatos=insertPromo($datos);
    $dir_subida = $_SERVER['DOCUMENT_ROOT']."/Imagenes_productos/".$_FILES['foto']['name'];
    $file_temp= $_FILES['foto']['tmp_name'];
    $upload= move_uploaded_file($file_temp, $dir_subida);
    if($upload){
        $respuesta->directorio='Imagen en directorio';
    }else{
        $respuesta->directorio='Problemas al subir la Imagen a directorio';
    }
    echo json_encode($respuesta);
}

if($code=='borrarPromo'){
    borrarPromo();
}

function borrarPromo(){
    $respuesta= new stdClass();
    $respuesta->baseDatos=deletePromo($_REQUEST['id']);
    $checkImg=checkImageName($_REQUEST['img']);
    if($checkImg!='Existe'){
        $respuesta->directorio=borrarImagenDirectorio($_REQUEST['img']);
    }
    echo json_encode($respuesta);
}

function borrarImagenDirectorio($name){
   $respuesta='';
   $dir_subida = $_SERVER['DOCUMENT_ROOT'].'/Imagenes_productos/'.$name;
   $borrarImg=unlink($dir_subida);
   if($borrarImg){
    $respuesta='Imagen eliminada de directorio';
   }else{
    $respuesta='Problemas al eliminar imagen de directorio';
   }
   return $respuesta; 
}

?>