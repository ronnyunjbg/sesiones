<?php
class Aleatorio{

	public static $num_max_sesiones = 4;
	public static $file_log = "c:/xampp/htdocs/mipag/log.txt";

	public static function getAleatorio($ip){
		$hash = self::get_hash();
		if ($id = self::genera_aleatorio($hash)){
			self::set_id_session_to_log($id, $ip);
			print_r($hash);
			return "_".$id;
		}else{
			return "numero_max_sesiones_alcanzado"; // Numero máximo de sesiones alcanzado
		}

	}

	private static function genera_aleatorio($hash){
		if (count($hash)<self::$num_max_sesiones){
			do{
				$id = rand(1,self::$num_max_sesiones);
			}while(($hash != null) && array_key_exists($id, $hash));

			return $id;
		} else {
			return null;
		}
	}

	private static function set_id_session_to_log($id, $ip){
		$archivo = fopen( self::$file_log, "a+");
		$linea = $id."\t=> ".(new DateTime())->format('Y-m-d H:i:s')."\t=>\tip:\t".$ip.PHP_EOL;
		fwrite( $archivo, $linea );
		fclose( $archivo );
	}

	private static function get_hash(){
		if ((file_exists(self::$file_log))!= null){
			$lineas = file(self::$file_log);
			foreach($lineas as $linea){
				$array = explode("=>", $linea);
				$id    = trim($array[0]);
				$fecha = trim($array[1]);
				$hash[$id] = $fecha;
			}
			return $hash;
		} else {
			return null;
		}
	}


	// Esta funcion es unicamente para debuguear
	// Asi que puede eliminarse sin afectar el funcionamiento
	// normal del programa
	private static function log($message){
		echo $message."</br>";
	}

	public static function ver_ids(){
		$lineas = file(self::$file_log);
		self::log("Numero de lineas: ".count($lineas));
		// echo "Numero de lineas: ".count($lineas)."</br>";
		foreach($lineas as $linea){
			// echo "-".$linea."</br>";
			// self::log("*".$linea);
			$array_lineas[] = $linea;
		}
		print_r($array_lineas);
	}

}

?>