<?php
include('remoteAccess.php');
header('Content-Type: application/json');

include('consultar_dataBase.php');
$modo=$_REQUEST['modo'];

if($modo=='logueo'){
    buscarClienteLogin();
}

function buscarClienteLogin(){
    $getUsu=$_REQUEST['usu'];
    $getCode=$_REQUEST['code'];
    $result=buscarClienteLogueo($getUsu, $getCode);
   echo json_encode($result);
}

if($modo=='correo'){
    buscarClienteByEmail();
}

function buscarClienteByEmail(){
    $email=$_REQUEST['email'];
    $result=buscarClienteCorreo($email);
    echo json_encode($result);  
}

if($modo=='datosCliente'){
    buscarDatosCliente();
}

function buscarDatosCliente(){
    $usuario=$_REQUEST['usuario'];
    $clave=$_REQUEST['clave'];
    $result=getDatosCliente($usuario, $clave);
    echo json_encode($result);  
}

if($modo=='actualizarCliente'){
    actualizarDatosPersonales();
}

function actualizarDatosPersonales(){
    $datos = json_decode(file_get_contents('php://input'));
    $result=validarRegistroAct($datos);
    echo json_encode($result);  
}

if($modo=='registrarCliente'){
    registroCliente();
}

function registroCliente(){
    $datos = json_decode(file_get_contents('php://input'));
    $resp =registrarClienteUsu($datos);
    echo json_encode($resp);  
}

if($modo=='registrarClienteAdmin'){
    registrarClienteAdmin();
}

function registrarClienteAdmin(){
    $datos = json_decode(file_get_contents('php://input'));
    $resp=new stdClass();
    $resp->usuario=registrarClienteUsuAdmin($datos);
    registrarCliente($datos);
    echo json_encode($resp);  
}


if($modo=='getAll'){
    getAll();
}

function getAll(){
    $resp=obtenerTodosClientes();
    echo json_encode($resp);  
}

if($modo=='getAllRegistroIncompleto'){
    getAllRegistroIncompleto();
}

function getAllRegistroIncompleto(){
    $resp=obtenerTodosCrearClave();
    echo json_encode($resp);  
}

if($modo=='borrarCliente'){
    borrarCliente();
}

function borrarCliente(){
    $resp=new stdClass();
    $resp->cliente=deleteCliente($_REQUEST['cedula']);
    $resp->usuario=deleteUsuario($_REQUEST['cedula'], $_REQUEST['correo']);
    echo json_encode($resp);  
}

?>