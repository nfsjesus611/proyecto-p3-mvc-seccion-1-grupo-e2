<?php

	require_once __DIR__ . '/../core/Database.php';

	class Usuario {
		private $pdo;

	    public function __construct() {
	    	$this->pdo = Database::getInstance()->getConnection();
	    }

	    public function validarCorreo($correo){
	    	return filter_var($correo, FILTER_VALIDATE_EMAIL);
	    }

	    public function validarUnicidad($correo){
	    	return empty($this->obtenerPorCorreo($correo));
	    }

	    public function validarCredenciales($correo, $clave) {
			$user = $this->obtenerPorCorreo($correo);

			if (!empty($user) && password_verify($clave, $user["clave"])) {
				return true;
			}
			
			return false;
	    }

	    public function obtenerTodos() {
	        $stmt = $this->pdo->query("SELECT * FROM usuario");
	        return $stmt->fetchAll(PDO::FETCH_ASSOC);
	    }


	    public function obtenerPorCorreo($correo){
	    	$stmt = $this->pdo->prepare("SELECT * FROM usuario WHERE correo = ? LIMIT 1");
	        $stmt->execute([$correo]);
	        return $stmt->fetch(PDO::FETCH_ASSOC);
	    }

	    // public function registrar($datos) {
	    //     if (!$this->validarCorreo($datos['correo'])) {
	    //         throw new Exception("Correo inválido");
	    //     }
	    //     if (!$this->validarUnicidad($datos['correo'])) {
	    //     	throw new Exception("Usuario registrado");
	    //     }

	    //     $sql = "INSERT INTO usuario (correo, password) VALUES (?, ?)";
	    //     $stmt = $this->pdo->prepare($sql);
	    //     return $stmt->execute([$data['correo'], $data['password']]);
	    // }

	    public function registrar($datos) {
	        $sql = "INSERT INTO usuario (correo, clave) VALUES (?, ?)";
	        $stmt = $this->pdo->prepare($sql);
	        return $stmt->execute([$datos['email'], password_hash($datos['password'], PASSWORD_DEFAULT)]);
	    }

	    public function actualizar($id, $datos) {
	        // return $this->repository->update($id, $datos);
	    }

	    public function eliminar($id) {
	        // return $this->repository->delete($id);
	    }
	}

 ?>
