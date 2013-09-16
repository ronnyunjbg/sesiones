<?php

include 'helpers/aleatorio.php';
include 'helpers/sesion.php';

$ruta_base = $_SERVER['DOCUMENT_ROOT']."/mipag/";
$ip = Sesion::get_ip($_SERVER);
// Verifica que no se hay alcanzado el numero limite de sesiones

if (($id = Aleatorio::getAleatorio($ip)) != "numero_max_sesiones_alcanzado"){
	Sesion::crear_directorio_y_copiar_templates($ruta_base, $id);
	Sesion::modificar_archivos_copiados($id, $ruta_base);
	Sesion::redirigir_a_sesion($id);
} else {
	Sesion::redirigir_a_404();
}

?>