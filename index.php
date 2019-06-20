<?php 
//Con las siguientes líneas establecemos el control de errores de los scripts.php
	if(!isset($_SESSION)) { 
        session_start(); header ("Cache-Control:no-cache, must-revalidate");

        
    }else{
        $_SESSION=[];
        session_destroy();
        header('location: index.php');
    }
   
	ini_set("display_errors",1);
	ini_set("display_starup_errors",1);
	error_reporting(E_ALL);

	/*Este archivo carga el controlador y la acción, que luego son enviadas al archivo routing.php.  
	Al inicio se carga el archivo de conexión a la base de datos y al final se carga el archivo layout.php, que muestra la vista principal.*/ 
	
	 require_once('connection.php');
	// la variable controller guarda el nombre del controlador y action guarda la acción por ejemplo registrar 
	//si la variable controller y action son pasadas por la url desde layout.php entran en el if
	

	if (isset($_GET['controller'])&&isset($_GET['action'])) {
			$controller=$_GET['controller'];
			$action=$_GET['action'];		
	} else {
		$controller='usuario';
		if (isset($_SESSION['usuario'])) {
			$action='welcome';
		}else{
			if (isset($_GET['controller'])&&$_GET['controller']=='admin') {
				$controller='usuario';
				$action='updateUser';
			}else {
				$action='showLogin';
			}
		}
		
	}	
	//carga la vista layout.php
	require_once('Views/Layouts/layout.php');
?>