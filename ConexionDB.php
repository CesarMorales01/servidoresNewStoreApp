<?php
include('pojo_productos.php');
include('pojo_clientes.php');
include('pojo_compras.php');

function conectar(){
    $hostname_localhost ="localhost";
    $database_localhost ="u629086351_mirey";
    $username_localhost ="u629086351_cesar";
    $password_localhost ="Pokemongo2019";
    $mysql=new mysqli($hostname_localhost,$username_localhost,$password_localhost,$database_localhost);
    if($mysql->connect_error)die('Problemas con la conexión...');
    return $mysql;
}


?>