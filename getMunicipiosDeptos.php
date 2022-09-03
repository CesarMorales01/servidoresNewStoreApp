<?php
include('remoteAccess.php');
header('Content-Type: application/json');

include('consultar_dataBase.php');
$modo=$_REQUEST['modo'];

if($modo=='municipios'){
    consultarMunicipios();
}

function consultarMunicipios(){
    $result=getCiudades();
    echo json_encode($result);
}

if($modo=='departamentos'){
    consultarDeptos();
}

function consultarDeptos(){
    $result=getDeptos();
    echo json_encode($result);
}


?>

