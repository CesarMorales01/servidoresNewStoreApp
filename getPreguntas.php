<?php
include('remoteAccess.php');
header('Content-Type: application/json');

include('consultar_dataBase.php');
$modo=$_REQUEST['modo'];

if($modo=='makeQuestion'){
    registrarQuestion();
}

function registrarQuestion(){
  $datos = json_decode(file_get_contents('php://input'));
  $result=registrarPregunta($datos);
  echo json_encode($result); 
}

if($modo=='cargarPreguntas'){
  cargarPreguntas();
}

function cargarPreguntas(){
  $prod=$_REQUEST['producto'];
  $result=getQuestions($prod);
  echo json_encode($result); 
}

if($modo=='getAll'){
  getAllQuestions();
}

function getAllQuestions(){
  $result=obtenerTodasLasPreguntas();
  echo json_encode($result); 
}

if($modo=='responderPregunta'){
  responderPregunta();
}

function responderPregunta(){
  $result=answerQuestion($_REQUEST['id'], $_REQUEST['respuesta']);
  echo json_encode($result); 
}

if($modo=='borrarPregunta'){
  borrarPregunta();
}

function borrarPregunta(){
  $result=deleteQuestion($_REQUEST['id']);
  echo json_encode($result); 
}

?>