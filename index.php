<?php
session_start();
include 'autoload/autoload.php';

$request = $_SERVER['REQUEST_URI'];

#handling route definitions
foreach ($routes as $key => $value) {
	$request = str_ireplace($key, $value, $request);
}

//if (substr($request, 0,1) == '/') $request = substr($request, 1);

$request = explode('/', substr($request, 1));
#var_dump($request);
#exit;
if (!empty($config['basefolder']) && $request[0] == $config['basefolder']) array_splice($request, 0, 1);

$path = "/".((!empty($config['basefolder']))? $config['basefolder'].'/' : '');
$breadcrumb = 'You are here: <li><a href="'.$path.'">Home</a></li>';
$page_title = "";

for ($k=0; $k<count($request); $k++) {
	if (empty($request[$k])) break;
	$title = ucwords(str_replace('_', ' ', $request[$k]));
	$page_title = ucwords(str_replace('_', ' ', $request[$k])).' | '.$page_title;
	$path .= $request[$k].'/';
	$breadcrumb .= '<li><a href="'.$path.'">'.$title.'</a></li>';
}

$controller_class = $controller_file = empty($request[0])? 'AppDefault' : $request[0];
$function = empty($request[1])? 'index' : $request[1];


#var_dump($controller_class, $function);
#exit;

if (!empty($request[2])) $arg1 = $request[2];
if (!empty($request[3])) $arg2 = $request[3];
if (!empty($request[4])) $arg3 = $request[4];

if (is_dir('controllers/'.$controller_file)) {
	$controller_file .= '/'.$request[1];
	$controller_class = $request[1];
	$function = empty($request[2])? 'index' : $request[2];
	if (!empty($request[3])) $arg1 = $request[3];
	if (!empty($request[4])) $arg2 = $request[4];
	unset($arg3);
}

#$file = 'controllers/'.ucfirst($controller_file).'.php';
#var_dump($file, is_file($file));
#exit;

if ($controller_file == "favicon.ico" || !(include 'controllers/'.ucfirst($controller_file).'.php')) {
	$controller_class = $controller_file = 'AppDefault';
	$function = 'invalidURL';
	include 'controllers/'.ucfirst($controller_file).'.php';
}

$obj = new $controller_class();
if (!method_exists($obj, $function)) {
	$controller_class = $controller_file = 'AppDefault';
	$function = 'invalidURL';
	include 'controllers/'.ucfirst($controller_file).'.php';
	$obj = new $controller_class();
}

if (empty($arg1)) $obj->$function();
else if (empty($arg2)) $obj->$function($arg1);
else if (empty($arg3)) $obj->$function($arg1, $arg2);
else $obj->$function($arg1, $arg2, $arg3);
?>