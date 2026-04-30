<?php

    require_once __DIR__ . '/../models/Usuario.php';

    class AuthController {
        private $modelo;

        public function __construct() {
            $this->modelo = new Usuario();
        }

        public function login() {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $form = new Validation();
                $form->sanitaize($_POST);
                $form->validate($_POST, 
                [
                    'email' => ['required', 'email'],
                    'password' => ['required', 'password'],
                ]);

                if($form->error()){
                    location()->to('backend/auth/login')->withMessage(['errors' => $form->error()]);
                }

                $log = $this->modelo->validarCredenciales($_POST['email'], $_POST['password']);
                if (!$log) {
                    location()->to('backend/auth/login')->withMessage(['errors' => "Las credenciales no son correctas."]);
                } else {
                    location()->to('backend/admin')->withMessage(['success' => "Ingreso con exito."]);
                }
                exit;
            } else {
                include __DIR__ . '/../../frontend/vistas/auth/index.php';
            }
        }
        
        public function logout() {
            Session::logout();
            location()->to('backend/auth/login');
            exit;
        }

        public function register() {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $form = new Validation();
                $form->sanitaize($_POST);
                $form->validate($_POST, 
                [
                    'email' => ['required', 'email'],
                    'password' => ['required', 'password'],
                    'password_confirm' => ['required', 'password', 'confirm' => ['password']],
                ]);

                if($form->error()){
                    location()->to('backend/auth/register')->withMessage(['errors' => $form->error()]);
                }

                if (!$this->modelo->validarUnicidad($_POST['email'])) {
                    location()->to('backend/auth/register')->withMessage(['errors' => "El usuario ya ha sido registrado"]);
                }

                $reg = $this->modelo->registrar($_POST);
                if (!$reg) {
                    location()->to('backend/auth/register')->withMessage(['errors' => "Hubo un problema"]);
                }
                location()->to('backend/auth/login')->withMessage(['success' => "Ha sido registrado con exito"]);    

                exit;
            } else {
                include __DIR__ . '/../../frontend/vistas/auth/register.php';
            }
        }

        public function reset() {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {

                exit;
            } else {
                include __DIR__ . '/../../frontend/vistas/auth/register.php';
            }
        }

        public function admin() {
            include __DIR__ . '/../../frontend/vistas/auth/admin.php';
        }
    }

 ?>
