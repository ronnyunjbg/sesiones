
<?php
class Sesion{

	// Creamos el directorio donde se almacenaran los templates modificados
	public static function crear_directorio_y_copiar_templates($ruta_base, $id_session){
		$nuevo_directorio = $ruta_base.$id_session;
		mkdir($nuevo_directorio);
		// Abrimos la carpeta templates
	    $dir = opendir($ruta_base."templates/");
	    // Copio todos los ficheros de la carpeta templates al nuevo directorio
	    while ($template = readdir($dir)){
	        if( $template != "." && $template != ".."){
	            copy($ruta_base."templates/".$template, $nuevo_directorio."/".$template);
	        }
	    }
	    closedir($dir);
	}

	public static function modificar_archivos_copiados($id, $ruta_base){
	    // Abrimos una carpeta de sesion
	    $dir = opendir($ruta_base.$id);
	    // Leo todos los ficheros
	    while ($template = readdir($dir)){
	    // Reemplazamos el campo id en los templates
	        if( $template != "." && $template != ".."){
	        	$nuevas_lineas = self::reemplazar_lineas($ruta_base.$id."/".$template, $id);
	            self::reescribir_archivo($ruta_base.$id."/".$template, $nuevas_lineas);
	        }
	    }
	}

	private static function reemplazar_lineas($ruta_archivo, $id){
		$lineas = file($ruta_archivo); //un array con las lineas del archivo
		$lineas_reemplazadas = str_replace('%id%', $id, $lineas);
		return $lineas_reemplazadas;
	}

	private static function reescribir_archivo($ruta_archivo, $lineas){
		$nuevo_archivo = fopen($ruta_archivo,"w");
		foreach ($lineas as $linea){
			fwrite($nuevo_archivo, $linea);
		}
		fclose($nuevo_archivo);
	}


	public static function redirigir_a_sesion($id){
		header("Location: ".$id."/"."index.html");
	}

	public static function redirigir_a_404(){
		header("Location: 404.html");
	}


	public static function get_ip($server){
		if ( $server["HTTP_X_FORWARDED_FOR"] ) {
		    $realip = $server["HTTP_X_FORWARDED_FOR"];
		} elseif ( $server["HTTP_CLIENT_IP"] ) {
		    $realip = $server["HTTP_CLIENT_IP"];
		} else {
		    $realip = $server["REMOTE_ADDR"];
		}
		return $realip;
	}

}

 ?>
