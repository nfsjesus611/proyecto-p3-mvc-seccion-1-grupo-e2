<?php
	define('PROJECT_DIR', str_replace("\\", "/", __DIR__ . '/'));
	define('CONTROLLERS_DIR', str_replace("\\", "/", __DIR__ . '/controllers/'));
	define('MODELS_DIR', str_replace("\\", "/", __DIR__ . '/models/'));

	require_once PROJECT_DIR . '/core/Location.php';
	require_once PROJECT_DIR . '/core/Session.php';
	require_once PROJECT_DIR . '/core/Validation.php';
	require_once PROJECT_DIR . '/routes/routes.php';
	require_once PROJECT_DIR . '/helpers/helpers.php';

	Session::init();

	spl_autoload_register(function ($class_name) {
	    // Ajusta la ruta base según tu estructura
	    $file = CONTROLLERS_DIR . $class_name . '.php';
	    if (file_exists($file)) {
	        require_once $file;
	    }
	});

	$request = $_SERVER['REQUEST_URI'];
	$base_path = '/proyecto-p3-mvc-seccion-1-grupo-e2/backend';
	$requestUri = str_replace($base_path, '', $request);
	$matched = false;


	foreach ($routes as $pattern => $handler) {
	    $pattern = '#^' . $pattern . '$#';
	    if (preg_match($pattern, $requestUri, $matches)) {
	        array_shift($matches);
	        $controllerName = $handler[0];
	        $method = $handler[1];
	        $controller = new $controllerName();
	        call_user_func_array([$controller, $method], $matches);
	        $matched = true;
	        break;
	    }
	}

	if (!$matched) {
	    http_response_code(404);
	    include dirname(PROJECT_DIR, 1) . '/frontend/vistas/errors/404.php';
	    // echo "Página no encontrada";
	}

 ?>
