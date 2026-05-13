<?php 
	//Clase que nos permite realizar la validaciones.
	class Validation {
		private $_errors = []; // Listado de errores.

		//Permite realizar las validaciones, especificando los datos y las reglas que se desee validar.
		public function validate($data, $rules = []){
			if (!is_array($data)) {
				throw new Exception('El primer argumento debe ser un arreglo', 1);
				exit(1);
			}
			$this->sanitaize($data);
			foreach ($data as $item => $item_value) {
				if (array_key_exists($item, $rules)) {
					foreach ($rules[$item] as $rule => $rule_value) {
						if(is_int($rule))
							$rule = $rule_value;
						switch ($rule) {
							case 'required':
								if (empty($item_value) && $rule_value) {
									$this->addError($item, 'El campo es obligatorio');
								}
								break;
							case 'minLen':
								if (strlen($item_value) < $rule_value) {
									$this->addError($item, 'El campo debe contener al menos ' . $rule_value . ' caracteres..');
								}
								break;
							case 'maxLen':
								if (strlen($item_value) > $rule_value) {
									$this->addError($item, 'El campo no debe contener más de ' . $rule_value . ' caracteres..');
								}
								break;
							case 'numeric':
								if (!ctype_digit($item_value) && $rule_value) {
									$this->addError($item, 'El campo no es numérico');
								}
								break;
							case 'alpha':
								if (!preg_match("/^[a-zA-ZÁÉÍÓÚÑáéíóúñ]+$/i", $item_value) && $rule_value) {
									$this->addError($item, 'El campo debe contener solo letras');
								}
								break;
							case 'alphaSpace':
								if (!preg_match("/^[a-zA-ZÁÉÍÓÚáéíóúñ ]+$/i", $item_value) && $rule_value) {
									$this->addError($item, 'El campo debe contener solo letras y espacios');
								}
								break;
							case 'upperCase':
								if (!ctype_upper($item_value) && $rule_value) {
									$this->addError($item, 'El campo debe contener solo letras mayúsculas');
								}
								break;
							case 'upperCaseSpace':
								if (!preg_match('/^[A-ZÁÉÍÓÚÜÑ ]+$/u', $item_value) && $rule_value) {
									$this->addError($item, 'El campo debe contener solo letras mayúsculas y espacio');
								}
								break;
							case 'lowerCase':
								if (!ctype_lower($item_value) && $rule_value) {
									$this->addError($item, 'El campo debe contener solo letras minúsculas');
								}
								break;
							case 'lowerCaseSpace':
								if (!preg_match('/^[a-záéíóúüñ ]+$/u', $item_value) && $rule_value) {
									$this->addError($item, 'El campo debe contener solo letras minúsculas y espacio');
								}
								break;
							case 'cedula':
								if (!preg_match('/^([VE])(?!0)\d{7,8}$/u', $item_value) && $rule_value) {
									$this->addError($item, 'La cédula de identidad debe tener el formato V00000000 sin puntos');
								}
								break;
							case 'email':
								if (!filter_var($item_value, FILTER_VALIDATE_EMAIL) && $rule_value) {
									$this->addError($item, 'El campo no es un correo válido');
								}
								break;
							case 'alphaNum':
								if (!ctype_alnum($item_value) && $rule_value) {
									$this->addError($item, 'El campo debe contener letras o números');
								}
								break;
							case 'in':
								if (!is_array($rule_value)) {
									throw new Exception('El argumento debe ser un arreglo', 1);
									exit(1);
								} else {
									if (!in_array($item_value, $rule_value)) {
										$this->addError($item, 'Debe seleccionar algunos con ' . implode(', ', $rule_value));
									}
								}
								break;
							case 'unique':
								if(!is_array($rule_value)){
									throw new Exception('El argumento debe ser un arreglo', 1);
									exit(1);

								} else {
									if (count($rule_value) != 2){
										throw new Exception('El argumento debe contener solo dos valores', 1);
										exit(1);
									}

									$reg = $rule_value[0]::unique($rule_value[1],$item_value);
									if (!empty($reg)) {
										$this->addError($item, 'El '.$rule_value[0].' ya ha sido registrado');
									}
								}
								break;
							case 'uniques':
								if (!is_array($rule_value)) {
									throw new Exception('El parámetro debe ser un arreglo', 1);
								} else {
									if (count($rule_value) != 2) {
										throw new Exception('Debe contener dos argumentos', 1);
									} else {
										if(count($rule_value[0]) != 2){
											throw new Exception('El primer argumento debe contener dos argumentos', 1);
										} else if(count($rule_value[1]) != 2){
											throw new Exception('El segundo argumento debe contener dos argumentos', 1);
										} else {
											$reg = $rule_value[0][0]::unique($rule_value[0][1],$item_value);
											$reg2 = $rule_value[1][0]::unique($rule_value[1][1],$item_value);
											if(!empty($reg) && !empty($reg2)){
												$this->addError($item, 'El elemento '.str_replace('-', ' ', $item).' ha sido duplicado');
											}
										}
									}
								}
								break;
							case "password":
								if (!preg_match( "/^(?=\w*\d)(?=\w*[A-Z])(?=\w*[a-z])\S{8,16}$/", $item_value)) {
									$this->addError($item, 'La contraseña no puede tener espacios ni caracteres especiales y, al menos, debe contar con:<br>- Dos letra mayúscula<br>- Una letra minúscula<br>- Un número <br> -Minimo 8 Caracteres.');
								}
								break;
							case 'confirm':
							    // Verifica que la contraseña y su confirmación sean idénticas.
							    // $rule_value sería el nombre del campo original, por ejemplo, 'password'.
							    if ($item_value !== $data[$rule_value[0]]) {
							        $this->addError($item, 'Las contraseñas no coinciden.');
							    }
							    break;
							case "equals":
								if ($item_value !== $data[$rule_value]) {
									$this->addError($item, 'Ambos campos deben ser iguales.');
								}
								break;
							case "notEquals":
								if ($item_value === $data[$rule_value]) {
									$this->addError($item, 'Ambos campos no deben ser iguales.');
								}
								break;
						}
					}
				}
			}
		}

		//Permite agregar errores. 
		private function addError($item, $error){
			$this->_errors[$item][] = $error;
		}

		//Permite obtener todos los errores.
		public function error(){
			if (empty($this->_errors)) return false;
			return $this->_errors;
		}

		//Permite limpiar los datos especificando los datos en un arreglo
		public function sanitaize(&$data){
		 return array_walk($data, [$this, "input"]);
		}

		//Permite realizar obtener los datos limpios.
		private function input(&$value){
			$value = trim($value);
			$value = htmlspecialchars($value);
			$value = stripslashes($value);
			if (is_float($value)) {
				$value = filter_var($value, FILTER_SANITIZE_NUMBER_FLOAT);
			}else if (is_numeric($value)) {
				$value = filter_var($value, FILTER_SANITIZE_NUMBER_INT);
			} else if(is_string($value)){
				$value = filter_var($value, FILTER_SANITIZE_STRING);
			}
		}
	}

 ?>