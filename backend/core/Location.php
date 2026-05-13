<?php 
	//Clase que nos permite redigir a una url con un mensaje
	class Location {
		//Permite dirigir a una url especificada
		public function to($url = null){
			self::redirect($url);
			return $this;
		}

		//Permite asignar uno o varios mensajes especificando los valores.
		public function withMessage($var, $value = null){
			if (is_null($value)) {
				foreach ($var as $clave => $valor) {
					$_SESSION[$clave] = $valor;
				}
			} else {
				$_SESSION[$var] = $value;
			}
			return $this;
		}

		//Permite dirigir a una url epsecificada
		private function redirect($ruta){
			header('location:'. base_url() . trim($ruta, '/'));
		}
	}

 ?>