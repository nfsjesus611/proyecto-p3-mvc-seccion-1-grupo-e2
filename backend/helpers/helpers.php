<?php 

//Permite obtener la url base
function base_url(){
	$dir = str_replace('\\', '/', dirname($_SERVER['PHP_SELF'], 2));
	if ($dir == '/') {
		return "{$_SERVER['REQUEST_SCHEME']}://{$_SERVER['HTTP_HOST']}" . $dir;
	} else {
		return "{$_SERVER['REQUEST_SCHEME']}://{$_SERVER['HTTP_HOST']}" . $dir . '/';
	}
}

//Permite obtener una url especificada
function url($url = ''){
	$url = htmlentities($url);
	$url = htmlspecialchars($url);
	return base_url() . $url;
}

function location(){
	return new Location();
}

?>
