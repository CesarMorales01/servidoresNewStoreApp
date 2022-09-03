<?php
include('ConexionDB.php');

function datosPrincipales(){
    $Objtel = new pojoProducto(); 
    $arrayTelefonos=[];
    $arrayTelefonos[0]= "3116186785";
    $arrayTelefonos[1]= "31661824363";
    $arrayTelefonos[2]= "3163439744";
    $Objtel->setListaImagenes($arrayTelefonos);
    // nombre de la pagina
    $Objtel->setNombre("Tu casa bonita");
    $Objtel->setDescripcion("https://www.facebook.com/TucasabonitaBmanga");
    //direccion
    $Objtel->setCate('Estamos ubicados en la calle 56 #3w-22 Barrio Mutis.
    Bucaramanga Santander.');
    //correo
    $Objtel->setCodigo('cezar_mh86@hotmail.com');
    //valor envio nacional
    $Objtel->setPrecio('25000');
    // valor envio local menor de 100 mil
    $Objtel->setImagen('10000');
    // comision pasarela
    $Objtel->setCantidad('0.03');
    // costo pago contraentrega
    $Objtel->setRef('0.01');
    // version para forzar actualizacion de app
    $Objtel->setOtros('0.0.11');
    // url pagina web
    $Objtel->setOtros1('https://tucasabonita.site/');
    // url sistema interno
    $Objtel->setOtros2('https://gestion.tucasabonita.site/');
    return $Objtel;
}

function cargarCategorias(){
    $conn = conectar();
    $consulta='SELECT * from categorias';   
	$resultado=$conn->query($consulta);
    $arrayList=[];
	while($reg=$resultado->fetch_array()){
        $prod=new pojoProducto();
        $prod->setCodigo($reg['id']);  
        $prod->setNombre($reg['nombre']);
        $prod->setImagen($reg['imagen']);
        $arrayList[]=$prod;    
    }
    $conn -> close();
    return $arrayList;  
}

function cargarProductos(){
    $conn = conectar();
    $consulta='SELECT * from productos';   
	$resultado=$conn->query($consulta);
    $arrayList=[];
	while($reg=$resultado->fetch_array()){
        $prod=new pojoProducto();  
        $prod->setNombre($reg['nombre']);
        $prod->setCodigo($reg['id']);
        $prod->setRef($reg['referencia']);
        $prod->setCate($reg['categoria']);
        $prod->setDescripcion($reg['descripcion']);
        $prod->setPrecio($reg['valor']);
        $prod->setListaImagenes(obtenerImagenes($reg['id']));  
        $prod->setImagen($reg['imagen']);
        $arrayList[]=$prod;    
    }
    $conn -> close();
    return $arrayList;  
}

function cargarPromos(){
    $conn = conectar();
    $consulta='select * from promociones order by id desc';
    $resultado=$conn->query($consulta);
    $arrayList=[];
    while($reg=$resultado->fetch_array()){
        $prod=new pojoProducto(); 
        $prod->setCodigo($reg['id']);
        $prod->setNombre($reg['descripcion']);
        $prod->setRef($reg['ref_producto']);
        $prod->setImagen($reg['imagen']);
        $arrayList[]=$prod;
    }
    $conn -> close();
    return $arrayList;
}

function cargarUnProducto($id){
    $conn = conectar();
    $consulta='SELECT * from productos where id='.$id;
    $resultado=$conn->query($consulta);
    $arrayList=[];
	if($reg=$resultado->fetch_array()){
        $prod=new pojoProducto();  
        $prod->setNombre($reg['nombre']);
        $prod->setCodigo($reg['id']);
        $prod->setRef($reg['referencia']);
        $prod->setCate($reg['categoria']);
        $prod->setDescripcion($reg['descripcion']);
        $prod->setPrecio($reg['valor']);
        $prod->setListaImagenes(obtenerImagenes($reg['id']));    
        $prod->setImagen($reg['imagen']);
        $arrayList[]=$prod;    
    }
    $conn -> close();
    return $arrayList;	  
}

function obtenerImagenes($id){
    $conn = conectar();
    $consultarImagenes="SELECT * from Imagenes_productos where fk_producto=$id";   
            $set_consulta=$conn->query($consultarImagenes);
            $lista=[];
            while($get_i=$set_consulta->fetch_array()){
                $objeto=new pojoProducto(); 
                $objeto->setNombre($get_i['nombre_imagen']);
                $objeto->setCodigo($get_i['fk_producto']);
                $lista[]=$objeto;
            }
            $conn -> close();
    return $lista;        
}

function buscarProductoPalabra($pal){
    $conn = conectar();
    $consulta="SELECT * from productos where nombre like '%$pal%' or descripcion like '%$pal%' or categoria like '%$pal%'";
    $resultado=$conn->query($consulta);
    $arrayList=[];
	while($reg=$resultado->fetch_array()){
        $prod=new pojoProducto();  
        $prod->setNombre($reg['nombre']);
        $prod->setCodigo($reg['id']);
        $prod->setRef($reg['referencia']);
        $prod->setCate($reg['categoria']);
        $prod->setDescripcion($reg['descripcion']);
        $prod->setPrecio($reg['valor']);
        $prod->setListaImagenes(obtenerImagenes($reg['id']));    
        $prod->setImagen($reg['imagen']);
        $arrayList[]=$prod;   
    }
    $conn -> close();
    return $arrayList;	  
}

function buscarClienteLogueo($usu, $id){
    $conn = conectar();
    $id="'".$id."'";
    $usu="'".$usu."'";
    $consulta='SELECT * from crear_clave where clave='.$id.' and correo='.$usu.' or cedula='.$usu;
    $arrayList=[];
    $prod=new pojoCliente();
    $resultado=$conn->query($consulta);
	if($reg=$resultado->fetch_array()){ 
        $prod->setCedula($reg['cedula']);
        $prod->setUsuario($reg['usuario']);
        $prod->setCorreo($reg['correo']);
        $prod->setClave($reg['clave']);
        $prod->setFechaIngreso($reg['fecha_ingreso']);     
    }else{
        $prod->setNombre('No existe');  
    }
    $arrayList[]=$prod;
    $conn -> close();
    return $arrayList; 	  
}

function buscarClienteCorreo($correo){
    $conn = conectar();
    $email="'".$correo."'";
    $consulta='SELECT * from crear_clave where correo='.$email;
    $arrayList=[];
    $prod=new pojoCliente(); 
    $resultado=$conn->query($consulta);
	if($reg=$resultado->fetch_array()){
        $prod->setCorreo($reg['correo']);    
    }else{
        $prod->setCorreo('No existe');
    }
    $arrayList[]=$prod;
    $conn -> close();
    return $arrayList;  	  
}

function registrarClienteUsu($datos){
    $resp='';
    $conn = conectar();
    $usu="'".$datos->usuario."'";
    $email="'".$datos->email."'";
    $clave="'".$datos->clave."'";
    $fecha="'".$datos->fecha."'";
    $consulta="insert into crear_clave (usuario, clave, correo, fecha_ingreso) values ($usu, $clave, $email, $fecha)";
    $resultado=$conn->query($consulta);  
    if($resultado){
        $resp="Registro";
    }else{
        $resp="No registro";
    }
    $conn -> close();
   return $resp;
}

function registrarClienteUsuAdmin($datos){
    $resp='';
    $conn = conectar();
    $ced=$datos->cedula;
    $usu="'".$datos->usuario."'";
    $correo="'".$datos->correo."'";
    $clave="'".$datos->clave."'";
    $fecha="'".$datos->fecha."'";
    $consulta="insert into crear_clave (cedula, usuario, clave, correo, fecha_ingreso) values ($ced, $usu, $clave, $correo, $fecha)";
    $resultado=$conn->query($consulta);  
    if($resultado){
        $resp="Registro";
    }else{
        $resp="No registro";
    }
    $conn -> close();
   return $resp;
}

function registrarCliente($datos){
    $resp='';
    $conn = conectar();
    $nombre="'".$datos->nombre."'";
    $apellidos="'".$datos->apellidos."'";
    $direccion="'".$datos->direccion."'";
    $infoDireccion="'".$datos->info_direccion."'";
    $ciudad="'".$datos->ciudad."'";
    $departamento="'".$datos->departamento."'";
    $otros="'".$datos->otros."'";
    $cedula=$datos->cedula;
    $prod=new pojoProducto();
    $arrayList=[];
    $consulta="insert into clientes (nombre, apellidos, cedula, direccion, info_direccion, ciudad, departamento, otros) values ($nombre, $apellidos, $cedula, $direccion, $infoDireccion, $ciudad, $departamento, $otros)";
    $resultado=$conn->query($consulta);  
    if($resultado){
        $prod->setNombre('Registro');
        registrarTelefonos($datos);
    }else{
        $prod->setNombre('No registro');
    }
    $arrayList[]=$prod;
    $conn -> close();
   return $resp;
}

function validarRegistroAct($datos){
    $resp='';
    $conn = conectar();
    $correo="'".$datos->correo."'";
    $consulta="select cedula from crear_clave where correo=".$correo;
    $resultado=$conn->query($consulta);
    $validarCed='';
    $prod=new pojoProducto();
    $arrayList=[];
	if($reg=$resultado->fetch_array()){
        $validarCed=$reg['cedula'];
    }
    if($validarCed==''){
        $prod->setRef(registrarCliente($datos));
    }else{ 
        $prod->setNombre(actualizarDatosCliente($datos));  
    }
    $prod->setDescripcion(actualizarDatosUsu($datos));
    $prod->setCodigo(registrarTelefonos($datos));
    $arrayList[]=$prod;
    $conn -> close();
   return $resp;
}

function registrarTelefonos($datos){
    $conn = conectar();
    $usu=$datos->cedula;
    $tels=$datos->telefonos;
    $consulta="delete from telefonos_clientes where cedula=".$usu;
    $resp=0;
    $resultado=$conn->query($consulta);
    if($resultado){
        for($i=0;$i<count($tels); $i++){
            $comis="'".$tels[$i]."'";
            $stringConsulta="insert into telefonos_clientes (cedula, telefono) values($usu, $comis)";
            $result=$conn->query($stringConsulta);
            $resp=$resp+1;
        }
    }
    $conn -> close();
    return $resp;
}

function actualizarDatosUsu($datos){
    $usu="'".$datos->nuevoUsuario."'";
    $email="'".$datos->correo."'";
    $clave="'".$datos->clave."'";
    $cedula="'".$datos->cedula."'";
    $update="update crear_clave set cedula=$cedula, usuario=$usu, clave=$clave where correo=$email";
    $conn = conectar();
    $resultado=$conn->query($update);  
    $prod=new pojoProducto();
    $arrayList=[];
    if($resultado){
        $prod->setNombre('Registro');
    }else{
        $prod->setNombre('No registro');
    }
    
    $arrayList[]=$prod;
   return $arrayList; 
}

function actualizarDatosCliente($datos){
    $nombre="'".$datos->nombre."'";
    $apellidos="'".$datos->apellidos."'";
    $dir="'".$datos->direccion."'";
    $info_dir="'".$datos->info_direccion."'";
    $ciudad=$datos->ciudad;
    $departamento=$datos->departamento;
   // $otros="'".$datos->otros."'";
    $cedula=$datos->cedula;
    $update="update clientes set nombre=$nombre, apellidos=$apellidos, cedula=$cedula, direccion=$dir, info_direccion=$info_dir, ciudad=$ciudad, departamento=$departamento where cedula=$cedula";
    $conn = conectar();
    $resultado=$conn->query($update);  
    $prod=new pojoProducto();
    $arrayList=[];
    if($resultado){
        $prod->setNombre('Registro');
    }else{
        $prod->setNombre('No registro');
    }
    $arrayList[]=$prod;
    $conn -> close();
   return $arrayList; 
}

function getDatosCliente($usu, $clave){
    $conn = conectar();
    $usu="'".$usu."'";
    $clave="'".$clave."'";
    $consulta="SELECT * from crear_clave where correo=$usu or cedula=$usu and clave=$clave";
    $arrayList=[];
    $prod=new pojoCliente();
    $resultado=$conn->query($consulta);
	if($reg=$resultado->fetch_array()){ 
        $prod->setCedula($reg['cedula']);
        $prod->setUsuario($reg['usuario']);
        $prod->setCorreo($reg['correo']);
        $prod->setClave($reg['clave']);
        $prod->setFechaIngreso($reg['fecha_ingreso']); 
        if($reg['cedula']!=''){
            $datosCliente=getClienteByCedula($reg['cedula']);
            $prod->setCedula($reg['cedula']);
            $prod->setNombre($datosCliente->nombre);
            $prod->setApellidos($datosCliente->apellidos);
            $prod->setDireccion($datosCliente->direccion);
            $prod->setInfoDir($datosCliente->info_direccion);
            $prod->setOtros($datosCliente->otros);
                if($datosCliente->ciudad!=null){
                    $ciudad=getCiudad($datosCliente->ciudad);
                    $prod->setCiudad($ciudad[0]->nombre);
                    $prod->setDepartamento($ciudad[0]->descripcion);
                }
            $prod->setTelefonos(getTelefonos($prod->cedula));   
        }   
    }else{
        $prod->setNombre('');  
    }
    $arrayList[]=$prod;
    $conn -> close();
    return $arrayList;    	  
}

function getTelefonos($ced){
    $conn = conectar();
    $consultarTelefonos="SELECT * from telefonos_clientes where cedula=$ced";   
    $set_consulta=$conn->query($consultarTelefonos);
    $lista=[];
    while($get_i=$set_consulta->fetch_array()){
        $lista[]=$get_i['telefono'];
    }
    $conn -> close();
    return $lista;
}

function getClienteByCedula($ced){
    $conn = conectar();
    $prod=new pojoCliente();
    $consulta1="SELECT * from clientes where cedula=$ced";  
    $resultado1=$conn->query($consulta1);
    if($reg1=$resultado1->fetch_array()){ 
        $prod->setCedula($reg1['cedula']);
        $prod->setNombre($reg1['nombre']);
        $prod->setApellidos($reg1['apellidos']);
        $prod->setDireccion($reg1['direccion']);
        $prod->setInfoDir($reg1['info_direccion']);
        $prod->setOtros($reg1['otros']);
        $prod->setCiudad($reg1['ciudad']);
    }
    $conn -> close();
    return $prod;
}

function getCiudad($id){
    $conn = conectar();
    $id="'".$id."'";
    $consulta='SELECT * from municipios where id='.$id;
    $resultado=$conn->query($consulta);
    $arrayList=[];
    if($reg=$resultado->fetch_array()){ 
        $prod=new pojoProducto();
        $prod->setCodigo($reg['id']);
        $prod->setNombre($reg['nombre']);
        $dep=getDepartamento($reg['departamento_id']);
        $prod->setDescripcion($dep[0]->nombre);
        
        $arrayList[]=$prod;
    }
    $conn -> close();
    return $arrayList;
}

function getDepartamento($id){
    $conn = conectar();
    $consulta='SELECT * from departamentos where id='.$id;
    $resultado=$conn->query($consulta);
    $arrayList=[];
    if($reg=$resultado->fetch_array()){ 
        $prod=new pojoProducto();
        $prod->setCodigo($reg['codigo']);
        $prod->setNombre($reg['nombre']);   
        $arrayList[]=$prod;
    }
    $conn -> close();
    return $arrayList;
}

function ingresarCarrito($datos){
    $conn = conectar();
    $cliente="'".$datos->cliente."'";
    $cod=$datos->cod;
    $producto="'".$datos->producto."'";
    $imagen="'".$datos->imagen."'";
    $valor=$datos->valor;
    $cantidad=$datos->cantidad;
    $fecha="'".$datos->fecha."'";
    $consulta="insert into carrito_compras (cod, producto, imagen, valor, cantidad, cliente, fecha) values ($cod, $producto, $imagen, $valor, $cantidad, $cliente, $fecha)";
    $resultado=$conn->query($consulta);  
    $prod=new pojoProducto();
    $arrayList=[];
    if($resultado){
        $prod->setNombre('Registro');
    }else{
        $prod->setNombre('No registro');
    }
    $arrayList[]=$prod;
    $conn -> close();
   return $arrayList;
}

function obtenerCarrito($id){
    $conn = conectar();
    $id="'".$id."'";
    $consulta='SELECT * from carrito_compras where cliente='.$id;
    $resultado=$conn->query($consulta);
    $arrayList=[];
    while($reg=$resultado->fetch_array()){ 
        $prod=new pojoProducto();
        $prod->setCodigo($reg['cod']);
        $prod->setNombre($reg['producto']);
        $prod->setDescripcion($reg['descripcion']);
        $prod->setImagen($reg['imagen']);
        $prod->setPrecio($reg['valor']);
        $prod->setCantidad($reg['cantidad']);
        $prod->setCate($reg['cliente']);
        $prod->setRef($reg['fecha']);
        $arrayList[]=$prod;
    }
    $num= strlen($prod->nombre);
      if($num==0){
            $prod=new pojoProducto();
            $prod->setNombre('0'); 
            $arrayList[]=$prod;
      }
    $conn -> close();
    return $arrayList;
}

function actualizarCarrito($datos){
    $conn = conectar();
    $cliente="'".$datos->cliente."'";
    $cantidad=$datos->cantidad;
    $cod=$datos->cod;
    $consulta="update carrito_compras set cantidad=".$cantidad." where cliente=".$cliente." and cod=".$cod;
    $resultado=$conn->query($consulta);  
    $prod=new pojoProducto();
    $arrayList=[];
    if($resultado){
        $prod->setNombre('Registro');
    }else{
        $prod->setNombre('No registro');
    }
    $arrayList[]=$prod;
    $conn -> close();
   return $arrayList;
}

function borrarCarrito($id, $cliente){
    $conn = conectar();
    $cliente="'".$cliente."'";
    $consulta="delete from carrito_compras where cod=".$id." and cliente=".$cliente;
    $resultado=$conn->query($consulta);  
    $prod=new pojoProducto();
    $arrayList=[];
    if($resultado){
        $prod->setNombre('Eliminado');
    }else{
        $prod->setNombre('No eliminado');
    }
    $conn -> close();
   return $arrayList;
}

function getCiudades(){
    $conn = conectar();
    $consulta="select * from municipios";
    $resultado=$conn->query($consulta);  
    $arrayList=[];
    while($reg=$resultado->fetch_array()){ 
        $prod=new pojoProducto();
        $prod->setCodigo($reg['id']);
        $prod->setNombre($reg['nombre']);
        $prod->setRef($reg['departamento_id']);
        $arrayList[]=$prod;
    }
    $conn -> close();
    return $arrayList;
}

function getDeptos(){
    $conn = conectar();
    $consulta="select * from departamentos";
    $resultado=$conn->query($consulta);  
    $arrayList=[];
    while($reg=$resultado->fetch_array()){ 
        $prod=new pojoProducto();
        $prod->setCodigo($reg['id']);
        $prod->setNombre($reg['nombre']);
        $arrayList[]=$prod;
    }
    $conn -> close();
    return $arrayList;
}

function ingresarCompra($datos){
    $conn = conectar();
    $cliente=$datos[0]->cedula;
    $nCompra=getNCompra($cliente);
    $fecha="'".$datos[0]->fecha."'";
    $totalCompra=$datos[0]->totales->subtotal;
    $domicilio=$datos[0]->totales->envio;
    $comentario="'".$datos[0]->comentario."'";
    $estado="'".$datos[0]->estado."'";
    $vendedor="'".$datos[0]->vendedor."'";
    // ingreso la ref wompi para su posterior actualizacion luego que se haya hecho el pago
    $cambio="'".$datos[0]->referenciaWompi."'";
    $medioPago="'".$datos[0]->medioPago.": Pago iniciado, ".$datos[0]->referenciaWompi."'";
    $consulta="insert into lista_compras (cliente, compra_n, fecha, total_compra, domicilio, medio_de_pago, comentarios, cambio, estado, vendedor) values ($cliente, $nCompra, $fecha, $totalCompra, $domicilio, $medioPago, $comentario, $cambio, $estado, $vendedor)";
    $resultado=$conn->query($consulta);  
    $prod=new pojoProducto();
    $arrayList=[];
    if($resultado){
        $prod->setNombre('Registro en lista compras');
        $prod->setListaImagenes(ingresarListaProductosComprados($datos, $nCompra));
        // solo borrar carrito cuando es contraentrega...
        if($datos[0]->medioPago=='contraentrega'){
            $prod->setRef(borrarCarritoxCompra($datos[0]->correo));
        }
        // enviar correo cuando haya compra 
        $datos=datosPrincipales();
        notificar('Nueva Compra', '');
    }else{
        $prod->setNombre('No registro en lista compras');
    }
    $arrayList[]=$prod;
    $conn -> close();
   return $arrayList;
}

function notificar($titulo, $message){
    $datos=datosPrincipales();
    $urlPagina=$datos->otros2;
	$subject=utf8_decode($titulo);
    $msj="Visita ".$urlPagina.$message;
    $mensaje=utf8_decode($msj); 
    $correo=$datos->codigo;
    $from=$datos->nombre;
    mail($correo, $subject, $mensaje, $from);
}

function borrarCarritoxCompra($correo){
    $conn = conectar();
    $cliente="'".$correo."'";
    $consulta="delete from carrito_compras where cliente=$cliente";
    $resultado=$conn->query($consulta);  
    $resp='';
    if($resultado){
        $resp="Carrito eliminado";
    }else{
        $resp="Carrito no eliminado";
    }
    $conn -> close();
    return $resp;
}

function ingresarListaProductosComprados($datos, $nCompra){
    $conn = conectar();
    $cliente=$datos[0]->cedula;
    $nums= count($datos[0]->productos);
    $arrayList=[];
    for($i=0;$i<$nums; $i++){
        $cod=$datos[0]->productos[$i]->codigo;
        $prod="'".$datos[0]->productos[$i]->nombre."'";
        $cant=$datos[0]->productos[$i]->cantidad;
        $precio=$datos[0]->productos[$i]->precio;
        $consulta="insert into lista_productos_comprados (cliente, compra_n, codigo, producto, cantidad, precio) values ($cliente, $nCompra, $cod, $prod, $cant, $precio)";
        $resultado=$conn->query($consulta);  
        if($resultado){
           $arrayList[]="Reg: cod: ".$cod;   
        }
    }
    $conn -> close();
    return $arrayList;   
}

function getNCompra($cliente){
    $conn = conectar();
    $consulta="select * from lista_compras where cliente=$cliente order by fecha desc";
    $resultado=$conn->query($consulta);  
	if($reg=$resultado->fetch_array()){ 
		$compra_n= $reg['compra_n'];	
	}else{
        $compra_n="0";
    }
    $conn -> close();
    return intval($compra_n+1);
}

function obtenerCompras($cliente){
    $conn = conectar();
    $consulta="select * from lista_compras where cliente=$cliente order by fecha desc";
    $resultado=$conn->query($consulta); 
    $arrayList=[]; 
	while($reg=$resultado->fetch_array()){ 
        $compra=new pojoCompras();
		$compra->setId($reg['id']);
        $compra->setCliente($reg['cliente']);
        $compra->setCompraN($reg['compra_n']);
        $compra->setFecha($reg['fecha']);
        $compra->setTotalCompra($reg['total_compra']);
        $compra->setDescripcionCredito($reg['descripcion_credito']);
        $compra->setNCuotas($reg['n_cuotas']);
        $compra->setPeriodicidad($reg['periodicidad']);
        $compra->setDomicilio($reg['domicilio']);
        $compra->setMedioPago($reg['medio_de_pago']);
        $compra->setComentarios($reg['comentarios']);
        $compra->setCambio($reg['cambio']);
        $compra->setEstado($reg['estado']);
        $compra->setVendedor($reg['vendedor']);
        $compra->setListaProductos(obtenerProductosComprados($compra->cliente, $compra->compra_n));	
        $arrayList[]=$compra;
	}
    if(count($arrayList)==0){
        $compra=new pojoCompras();
		$compra->setId('No hay registros');
        $arrayList[]=$compra;
    }
    $conn -> close();
    return $arrayList;
}

function obtenerProductosComprados($ced, $n){
    $conn = conectar();
    $consulta="select * from lista_productos_comprados where cliente=$ced and compra_n=$n";
    $resultado=$conn->query($consulta); 
    $arrayList=[]; 
	while($reg=$resultado->fetch_array()){
        $compra=new pojoCompras();
		$compra->setId($reg['id']);
        $compra->setCliente($reg['cliente']);
        $compra->setCompraN($reg['compra_n']);
        $compra->setFecha($reg['codigo']);
        $compra->setNCuotas($reg['producto']);
        $compra->setDescripcionCredito($reg['descripcion']);
        $compra->setDomicilio($reg['cantidad']);
        $compra->setCambio($reg['precio']);
        $compra->SetlistaProductos(cargarUnProducto($compra->fecha));
        $arrayList[]=$compra;
    }
    $conn -> close();
    return $arrayList;
}

function getIdWompi(){
    $conn = conectar();
    $consulta="select max(id) from pagos_wompi";
    $resultado=$conn->query($consulta); 
    $arrayList=[]; 	
    $compra=new pojoCompras();  
   
    if($get=$resultado->fetch_array()){
        $compra->setId($get['max(id)']+1);
    }else{
        $compra->setId(0);
    }
    $arrayList[]=$compra;
    $conn -> close();
    return $arrayList;
}

function guardarRefWompi($datos){
    $cliente=$datos[0];
    $venta=$datos[1];
    $fecha="'".$datos[2]."'";
    $ref=$datos[3];
    $estado="'".$datos[4]."'";
    $conn = conectar();
    $consulta="insert into pagos_wompi (ref_wompi, cliente, valor_compra, fecha, estado) values($ref, $cliente, $venta, $fecha, $estado)";
    $resultado=$conn->query($consulta); 
    $arrayList=[]; 
	if($resultado){
        $compra=new pojoCompras(); 
        $compra->setId($ref);
    }
    $arrayList[]=$compra;
    $conn -> close();
    return $arrayList;
}

function updateEventoWompi($datos){
    $conn = conectar();
    $arrayList=[];
    $id="'".$datos->data->transaction->id."'";
    $valor="'".$datos->data->transaction->amount_in_cents."'";
    $myRef="'".$datos->data->transaction->reference."'";
    $estado="'".$datos->data->transaction->status."'";
    $cliente="'".$datos->data->transaction->shipping_address->phone_number."'";
    $fecha="'".$datos->sent_at."'";
    $updateString="update pagos_wompi set ref_wompi=$id, cliente=$cliente, valor_compra=$valor, fecha=$fecha, estado=$estado where id=$myRef";
    $resultado=$conn->query($updateString);  
    if($resultado){
        $arrayList[]='ok';  
    }
    $conn -> close();
    return $arrayList;   
}

function updatePagoWompiListaCompras($myRef, $id, $cliente, $estado){
    $conn = conectar();
    $medioPago="Electronico: ".$id;
    $medioPago="'".$medioPago."'";
    $estado="Transaccion: ".$estado;
    $estado="'".$estado."'";
    $updateString="update lista_compras set medio_de_pago=$medioPago, cambio=$estado where cliente=$cliente and cambio=$myRef";
    $conn->query($updateString);
    $conn -> close();
}

function validarEstadoPago($ref){
    $conn = conectar();
    $ref="'".$ref."'";
    $string="select estado from pagos_wompi where id=$ref";
    $estado='';
    $resultado=$conn->query($string); 
	if($reg=$resultado->fetch_array()){
        $estado=$reg['estado'];
    }
    $conn -> close();
    return $estado;
}

function registrarPregunta($datos){
    $fecha="'".$datos->fecha."'";
    $cliente="'".$datos->cliente."'";
    $producto=$datos->producto;
    $pregunta="'".$datos->pregunta."'";
    $conn = conectar();
    $consulta="insert into preguntas_sobre_productos (fecha, cliente, producto, pregunta) values($fecha, $cliente, $producto, $pregunta)";
    $resultado=$conn->query($consulta); 
    $insertado='';
	if($resultado){
        notificar('Nueva pregunta!', '');
       $insertado='ok'; 
    }
    $conn -> close();
    return $insertado;
} 

function getQuestions($prod){
    $conn = conectar();
    $string="select * from preguntas_sobre_productos where producto=$prod";
    $arrayList=[]; 
    $resultado=$conn->query($string); 
	while($get=$resultado->fetch_array()){
        $compra=new pojoCompras();
        $compra->setId($get['id']);
        $compra->setFecha($get['fecha']);
        $compra->setCliente($get['cliente']);
        $compra->setDescripcionCredito($get['pregunta']);
        $compra->setComentarios($get['respuesta']);
        $arrayList[]=$compra;
    }
    $conn -> close();
    return $arrayList;
}

function loginAsesor($datos){
    $nombre="'".$datos->nombre."'";
    $clave="'".$datos->clave."'";
    $conn = conectar();
    $string="select * from asesores where nombre=$nombre and imei=$clave";
    $arrayList=[]; 
    $prod=new pojoCliente();
    $resultado=$conn->query($string);
	if($reg=$resultado->fetch_array()){ 
        $prod->setCedula($reg['imei']);
        $prod->setUsuario($reg['nombre']);
    }else{
        $prod->setUsuario('No existe');
    }
    $arrayList[]=$prod;
    $conn -> close();
    return $arrayList;
}

function editProduct($datos){
    $id=$datos->id;
    $ref="'".$datos->referencia."'";
    $cate="'".$datos->categoria."'";
    $nombre="'".$datos->nombre."'";
    $descripcion="'".$datos->descripcion."'";
    $valor="'".$datos->valor."'";
    $string="update productos set referencia=$ref, categoria=$cate, nombre=$nombre, descripcion=$descripcion, valor=$valor where id=$id";
    $conn = conectar();
    $resultado=$conn->query($string);
    $resp='';
	if($resultado){ 
        $resp="Editado";
    }else{
        $resp="No editado";
    }
    $conn -> close();
    return $resp;
}

function insertarProducto($datos){
    $ref="'".$datos->referencia."'";
    $cate="'".$datos->categoria."'";
    $nombre="'".$datos->nombre."'";
    $descripcion="'".$datos->descripcion."'";
    $valor="'".$datos->valor."'";
    $string="insert into productos (referencia, categoria, nombre, descripcion, valor) values ($ref, $cate, $nombre, $descripcion, $valor)";
    $conn = conectar();
    $resultado=$conn->query($string);
    $resp='';
	if($resultado){ 
        $string1="select id from productos where categoria=$cate and nombre=$nombre and descripcion=$descripcion and valor=$valor";
        $result=$conn->query($string1);
        if($reg=$result->fetch_array()){  
            $resp=$reg['id'];
        }else{
            $resp="no se encontro el producto";
        }   
    }else{
        $resp="Problemas al insertar producto";
    }
    $conn -> close();
    return $resp;
}

function insertImage($datos){
    $producto=$datos->nombre;
    $imagen="'".$datos->imagen."'";
    $conn = conectar();
    $string="insert into Imagenes_productos (nombre_imagen, fk_producto) values ($imagen, $producto)";
    $resultado=$conn->query($string);
	if($resultado){ 
        $resp='Imagen insertada en base de datos';
    }else{
        $resp='Problemas al insertar imagen en base de datos';
    }
    $conn -> close();
    return $resp;
}

function checkImageName($name){
    $name="'".$name."'";
    $string="select nombre_imagen from Imagenes_productos where nombre_imagen=$name";
    $conn = conectar();
    $resultado=$conn->query($string);
	if($reg=$resultado->fetch_array()){
        $imagen=$reg['nombre_imagen'];
    }
    if($imagen==''){
       $resp="No existe";
    } else{
       $resp="Existe";
    }
    $conn -> close();
    return $resp;
}

function deleteProduct($id){
    $string="delete from productos where id=$id";
    $conn = conectar();
    $resultado=$conn->query($string);
    $prod=new pojoProducto();
	if($resultado){
        $prod->setNombre('Producto borrado de base de datos');
        $prod->setRef(borrarImagen($id));
    }else{
        $prod->setNombre('Problemas al borrar producto de base de datos');
    }
    $conn -> close();
    return $prod;
}

function borrarImagen($id){
    $conn = conectar();
    $resp='';
    $string1="delete from Imagenes_productos where fk_producto=$id";
        $resultado1=$conn->query($string1);
        if($resultado1){
            $resp='Imagenes borradas de base de datos';
        }else{
            $resp='Problemas al borrar imagenes de base de datos';
        }
        $conn -> close();
    return $resp;    
}

function borrarImagenByNombre($name){
    $conn = conectar();
    $resp='';
    $nombre="'".$name."'";
    $string1="delete from Imagenes_productos where nombre_imagen=$nombre";
        $resultado1=$conn->query($string1);
        if($resultado1){
            $resp='Imagen borrada de base de datos';
        }else{
            $resp='Problemas al borrar la imagen de la base de datos';
        }
        $conn -> close();
    return $resp;    
} 

function deleteCate($id){
    $conn = conectar();
    $consulta="delete from categorias where id=$id";   
	$resultado=$conn->query($consulta);
    $resp='';
	if($resultado){
       $resp='Categoria borrada';        
    }else{
        $resp='Error al borrar categoria';
    }
    $conn -> close();
    return $resp;  
}

function ingresarCategoria($nombre, $imagen){
    $conn = conectar();
    $nombre="'".$nombre."'";
    $imagen="'ImagenesCategorias/".$imagen."'";
    $consulta="insert into categorias (nombre, imagen) values ($nombre, $imagen)";   
	$resultado=$conn->query($consulta);
    $resp='';
	if($resultado){
       $resp='Categoria creada';        
    }else{
        $resp='Error al crear categoria';
    }
    $conn -> close();
    return $resp;  
}

function insertPromo($datos){
    $conn = conectar();
    $consulta="insert into promociones (descripcion, imagen, ref_producto) values ($datos->nombre, $datos->imagen, $datos->codigo)";   
	$resultado=$conn->query($consulta);
    $resp='';
	if($resultado){
       $resp='Promo creada';        
    }else{
        $resp='Error al crear promo';
    }
    $conn -> close();
    return $resp;  
}

function deletePromo($id){
    $conn = conectar();
    $consulta="delete from promociones where id=$id";   
	$resultado=$conn->query($consulta);
    $resp='';
	if($resultado){
       $resp='Promo eliminada';        
    }else{
        $resp='Error al eliminar promo';
    }
    $conn -> close();
    return $resp;  
}

function getListaCompras(){
    $string="select * from lista_compras order by id desc";
    $conn = conectar();
    $arrayList=[];
    $resultado=$conn->query($string);
	while($reg=$resultado->fetch_array()){
       $compra=new pojoCompras();
       $compra->setId($reg['id']);
       $compra->setFecha($reg['fecha']);
       $compra->setCliente($reg['cliente']);
       $cliente=getClienteByCedula($reg['cliente']);
       $compra->setPeriodicidad($cliente->nombre);
       $compra->setCompraN($reg['compra_n']);
       $compra->setTotalCompra($reg['total_compra']);
       $compra->setDomicilio($reg['domicilio']);
       $compra->setMedioPago($reg['medio_de_pago']);
       $compra->setComentarios($reg['comentarios']);
       $compra->setEstado($reg['estado']);
       $compra->setVendedor($reg['vendedor']);
       $arrayList[]=$compra;
    }
    $conn -> close();
    return $arrayList;
}

function cambioEstadoCompra($id, $estado){
    $estado="'".$estado."'";
    $string="update lista_compras set estado=$estado where id=$id";
    $conn = conectar();
    $resultado=$conn->query($string);
    $resp=[];
	if($resultado){
      $resp=getListaCompras();
    }
    $conn -> close();
    return $resp;
}

function deleteCompra($id, $compra_n, $cliente){
    $string="delete from lista_compras where id=$id";
    $conn = conectar();
    $resultado=$conn->query($string);
    $resp=[];
	if($resultado){
        $string1="delete from lista_productos_comprados where cliente=$cliente and compra_n=$compra_n";
        $resultado1=$conn->query($string1);
        if($resultado1){
            $resp=getListaCompras();
        }  
    }
    $conn -> close();
   return $resp;
}

function obtenerTodasLasPreguntas(){
    $conn = conectar();
    $string="select * from preguntas_sobre_productos order by id desc";
    $arrayList=[]; 
    $resultado=$conn->query($string); 
	while($get=$resultado->fetch_array()){
        $compra=new pojoCompras();
        $compra->setId($get['id']);
        $compra->setFecha($get['fecha']);
            // para consultar cedula en crear clave
            $clienteComi="'".$get['cliente']."'";
            $string1="select cedula from crear_clave where correo=$clienteComi";
            $compra->setVendedor($get['cliente']);
            $resultado1=$conn->query($string1); 
            if($get1=$resultado1->fetch_array()){
                $ced=$get1['cedula'];
                if($ced!=''){
                    $compra->setCliente($get1['cedula']);
                    $string2="select nombre from clientes where cedula=$ced";
                    $resultado2=$conn->query($string2); 
                    if($get2=$resultado2->fetch_array()){
                        $compra->setEstado($get2['nombre']);
                    }
                } 
            }
        $compra->setCompraN($get['producto']);
        $compra->setTotalCompra( cargarUnProducto($get['producto']));    
        $compra->setDescripcionCredito($get['pregunta']);
        $compra->setComentarios($get['respuesta']);
        $arrayList[]=$compra;
    }
    $conn -> close();
    return $arrayList;
}

function answerQuestion($id, $resp){
    $resp="'".$resp."'";
    $string="update preguntas_sobre_productos set respuesta=$resp where id=$id";
    $conn = conectar();
    $resultado=$conn->query($string);
    $preguntas=[];
	if($resultado){
        $preguntas=obtenerTodasLasPreguntas();
    }
    $conn -> close();
   return $preguntas;
}

function deleteQuestion($id){
    $string="delete from preguntas_sobre_productos where id=$id";
    $conn = conectar();
    $resultado=$conn->query($string);
    $preguntas=[];
	if($resultado){
        $preguntas=obtenerTodasLasPreguntas();
    }
    $conn -> close();
   return $preguntas;
}

function obtenerTodosClientes(){
    $conn = conectar();
    $arrayList=[];
    $consulta1="SELECT * from clientes";  
    $resultado1=$conn->query($consulta1);
    while($reg1=$resultado1->fetch_array()){ 
        $prod=new pojoCliente();
        $prod->setCedula($reg1['cedula']);
        $prod->setNombre($reg1['nombre']);
        $prod->setApellidos($reg1['apellidos']);
        $prod->setDireccion($reg1['direccion']);
        $prod->setInfoDir($reg1['info_direccion']);
        $prod->setOtros($reg1['otros']);
        $prod->setCiudad($reg1['ciudad']);
        $prod->setDepartamento($reg1['departamento']);
        $prod->setTelefonos(getTelefonos(($reg1['cedula'])));
        $nuevoCliente=getDatosUsuByCedula($reg1['cedula']);
        $prod->setUsuario($nuevoCliente->usuario);
        $prod->setCorreo($nuevoCliente->correo);
        $prod->setClave($nuevoCliente->clave);
        $prod->setFechaIngreso($nuevoCliente->fecha_ingreso);
        $arrayList[]=$prod;
    }
    $conn -> close();
    return $arrayList;
}

function getDatosUsuByCedula($ced){
    $conn = conectar();
    $consulta="SELECT * from crear_clave where cedula=$ced";
    $prod=new pojoCliente();
    $resultado=$conn->query($consulta);
	if($reg=$resultado->fetch_array()){ 
        $prod->setCedula($reg['cedula']);
        $prod->setUsuario($reg['usuario']);
        $prod->setCorreo($reg['correo']);
        $prod->setClave($reg['clave']);
        $prod->setFechaIngreso($reg['fecha_ingreso']);     
    }else{
        $prod->setNombre('No existe');  
    }
    $conn -> close();
    return $prod;
}

function obtenerTodosCrearClave(){
    $conn = conectar();
    $consulta="SELECT * from crear_clave";
    $resultado=$conn->query($consulta);
    $arrayList=[];
	while($reg=$resultado->fetch_array()){ 
        if($reg['cedula']==''){
            $prod=new pojoCliente();
            $prod->setUsuario($reg['usuario']);
            $prod->setCorreo($reg['correo']);
            $prod->setClave($reg['clave']);
            $prod->setFechaIngreso($reg['fecha_ingreso']); 
            $arrayList[]=$prod;
        } 
    }
    $conn -> close();
    return $arrayList;
}

function deleteCliente($id){
    $conn = conectar();
    $consulta="delete from clientes where cedula=$id";
    $resultado=$conn->query($consulta); 
    $consulta1="delete from telefonos_clientes where cedula=$id";
    $resultado1=$conn->query($consulta1);  
    if($resultado){
        $resp='Eliminado';
    }else{
        $resp='No eliminado';
    }
    $conn -> close();
   return $resp;
}

function deleteUsuario($id, $correo){
    $conn = conectar();
    $correo="'".$correo."'";
    $consulta="delete from crear_clave where cedula=$id or correo=$correo";
    $resultado=$conn->query($consulta);  
    if($resultado){
        $resp='Eliminado';
    }else{
        $resp='No eliminado';
    }
    $conn -> close();
   return $resp;
}

function registrarCompraAdmin($datos){
    // diferente por tener que ingresar datos a pasarela de pagos....
    $conn = conectar();
    $cliente=$datos->cliente;
    $nCompra=getNCompra($cliente);
    $fecha="'".$datos->fecha."'";
    $totalCompra=$datos->total_compra;
    $domicilio=$datos->domicilio;
    $comentarios="'".$datos->comentarios."'";
    $estado="'".$datos->estado."'";
   // $vendedor="'".$datos[0]->vendedor."'";
    
    $medioPago="'".$datos->medio_de_pago.": ".$datos->costo_medio_pago."'";
    $consulta="insert into lista_compras (cliente, compra_n, fecha, total_compra, domicilio, medio_de_pago, comentarios, estado) values ($cliente, $nCompra, $fecha, $totalCompra, $domicilio, $medioPago, $comentarios, $estado)";
    $resultado=$conn->query($consulta);  
    $resp=new stdClass();
    if($resultado){
        $resp->listaCompras='Registro en lista compras';
        $array=[];
        $objeto=new stdClass();
        $objeto->cedula=$cliente;
        $objeto->productos=$datos->listaProductos;
        $array[]=$objeto;
        // si registro en lisata compras pero no en lista productos ocmprados
        $resp->listaProductos=ingresarListaProductosComprados($array, $nCompra);
    }else{
        $resp->listaCompras='No registro en lista compras';
    }
    $conn -> close();
   return $resp;
}


?>