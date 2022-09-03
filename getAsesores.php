<?php
include('remoteAccess.php');
header('Content-Type: application/json');

include('consultar_dataBase.php');
$modo=$_REQUEST['modo'];

if($modo=='loginAsesor'){
    getLogin();
}

function getLogin(){
    $datos = json_decode(file_get_contents('php://input'));
    $result=loginAsesor($datos);
    echo json_encode($result); 
}


?>