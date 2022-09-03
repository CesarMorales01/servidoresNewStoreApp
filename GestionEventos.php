<?php
http_response_code(200);
include('consultar_dataBase.php');
$datos = json_decode(file_get_contents('php://input'));

$result=updateEventoWompi($datos);
// si wompi aproved, modificar lista compras
$estado=$datos->data->transaction->status;
updatePagoWompiListaCompras($datos->data->transaction->reference, $datos->data->transaction->id, $datos->data->transaction->shipping_address->phone_number, $datos->data->transaction->status);
if($estado=='APPROVED'){
    borrarCarritoxCompra($datos->data->transaction->shipping_address->city);
}

?>