<?php 
	// Clase que nos permite manipular las sesión
	class Session {
		//Permite iniciar la sesión
		public static function init(){
			if (session_status() == PHP_SESSION_NONE) {
				session_start();
			}
		}

		//Permite verificar la existencia de una variable de sesión
		public static function has($var_session){
			if (isset($_SESSION[$var_session])) {
				return true;
			} else {
				return false;
			}
		}
		
		//Permite obtener la variable de sesión especficada.
		public static function get($var_session){
			try {
				$mensaje = $_SESSION[$var_session];
				unset($_SESSION[$var_session]);
				return $mensaje;
			} catch (Exception $e) {}
		}

		//Permite cerrar la sesión
		public static function logout(){
			$_SESSION = array();
			session_destroy();
		}
	}

?>