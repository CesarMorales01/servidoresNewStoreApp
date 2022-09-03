<?php
include('remoteAccess.php');
header('Content-Type: application/json');
include('consultar_dataBase.php');
// url para redireccionar despues de pago wompi
$url="https://tucasabonita.site/";

$array[]=datosPrincipales();
echo json_encode($array);
?>