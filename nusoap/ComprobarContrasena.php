<?php
// creo un servicio web para comprobar contrasenas
// incluimos la clase nusoap.php
require_once('lib/nusoap.php');
require_once('lib/class.wsdlcache.php');

// creamos el objeto de tipo soap_server
$ns="https://szemzotomas.000webhostapp.com/?dir=lab5Servicios/nusoap/samples";
$server = new soap_server;
$server->configureWSDL('comprobar',$ns);
$server->wsdl->schemaTargetNamespace=$ns;

//registramos la función que vamos a implementar
$server->register('comprobar', array('password'=>'xsd:string','ticket'=>'xsd:int'),array('validez'=>'xsd:string'),$ns);

//implementamos la función
function comprobar ($password,$ticket){

    if($ticket != 1010){
        return 'SIN SERVICIO';
    }
	
	$archivo = file_get_contents("https://szemzotomas.000webhostapp.com/lab5Servicios/toppasswords.txt");
        $pos = strpos($archivo, $password);
        if ($pos === false) {
            return 'VALIDA';
        } else {
            return 'INVALIDA';
        }
        return 'VALIDA';
}
//llamamos al método service de la clase nusoap antes obtenemos los valores de los parámetros
if ( !isset( $HTTP_RAW_POST_DATA ) ) $HTTP_RAW_POST_DATA = file_get_contents( 'php://input' );
$server->service($HTTP_RAW_POST_DATA);
?>
