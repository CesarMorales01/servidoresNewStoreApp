<?php
include('remoteAccess.php');
header('Content-Type: application/json');

include('consultar_dataBase.php');

$modo=$_REQUEST['modo'];

if($modo=='editarProducto'){
    editarProducto();
}

function editarProducto(){
    $datos = json_decode(file_get_contents('php://input'));
    $resp= editProduct($datos);
    echo json_encode($resp); 
}

if($modo=='ingresarProducto'){
    ingresarProducto();
}
// Primero se ingresa el producto y se responde con el id para poder ingresar la imagen
function ingresarProducto(){
    $datos = json_decode(file_get_contents('php://input'));
    $resp= insertarProducto($datos);
    echo json_encode($resp); 
}

if($modo=='ingresarImagen'){
    ingresarImagen();
}
// Desde el front se envian los datos para ingresar la imagen (Incluyendo el fk_producto)
function ingresarImagen(){
    $dir_subida = $_SERVER['DOCUMENT_ROOT']."/Imagenes_productos/".$_FILES['foto']['name'];
    $file_temp= $_FILES['foto']['tmp_name'];
    $upload= move_uploaded_file($file_temp, $dir_subida);
    // pojo producto para dar respuesta
    $prod=new pojoProducto();
    if($upload){
        $prod->setNombre("Foto en directorio");
    }else{
        $prod->setNombre("Error al subir al directorio");
    }
    //pojo producto para enviar datos a consulta_dataBase
    $img=new pojoProducto();
    $img->setNombre($_REQUEST['producto']);
    $img->setImagen($_FILES['foto']['name']);
    $respuesta=insertImage($img);
    $prod->setRef($respuesta);
    echo json_encode($prod); 
}

if($modo=='validarNombreImagen'){
    validarNombreImagen();
}

function validarNombreImagen(){
    $nombre=$_REQUEST['nombreImagen'];
    $respuesta=checkImageName($nombre);
    echo json_encode($respuesta); 
}

if($modo=='borrarProducto'){
    borrarProducto();
}

function borrarProducto(){
    $id=$_REQUEST['id'];
    $datos = json_decode(file_get_contents('php://input'));
    $objeto = new stdClass();
    $objeto->imagenes=deleteImages($datos);
    $objeto->baseDatos=deleteProduct($id);
    echo json_encode($objeto); 
}

function deleteImages($datos){
    $array=[];
    $nums=count($datos);
    for($i=0; $i<$nums;$i++){
        $directorio=$_SERVER['DOCUMENT_ROOT']."/Imagenes_productos/".$datos[$i]->nombre;
        $borrarImg=unlink($directorio);
        if($borrarImg){
          $array[]=$datos[$i]->nombre." borrada";
        }
    }
    return $array;
}

if($modo=='getImagenes'){
    getImagenes();
}

function getImagenes(){
    $result=obtenerImagenes($_REQUEST['id']);
    echo json_encode($result); 
}

if($modo=='borrarImagen'){
    borrarUnaImagen();
}

function borrarUnaImagen(){
    $datos = json_decode(file_get_contents('php://input'));
    $objeto = new stdClass();
    $objeto->imagenes=deleteImages($datos);
    $objeto->baseDatos=borrarImagenByNombre($datos[0]->nombre);
    echo json_encode($objeto);  
}


?>