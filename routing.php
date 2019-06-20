<?php
/** En este archivo es donde se declaran los controladores y las acciones para cada uno de los controladores, así mismo es el que se encarga de enviar al controlador adecuado y la acción (el método) que vienen desde el archivo index.php
*
**/ require_once('Models/Paginacion.php');
	require_once('Models/Book.php');

	if(!isset($_SESSION)){ 
        session_start();
        
        header('location: index.php'); 
        
    }
	

	
	//función que llama al controlador y su respectiva acción, que son pasados como parámetros
	function call($controller, $action){
		//importa el controlador desde la carpeta Controllers
		require_once('Controllers/' . $controller . 'Controller.php');
		//crea el controlador

		switch($controller){
			case 'usuario':
				require_once('Models/Usuario.php');
				require_once('Models/Profilehistory.php');
				require_once('Models/Gestiones.php');
				require_once('Models/Book.php');
				require_once('Models/Seguimiento.php');
				$controller= new UsuarioController();
				break; 

			case 'book':
				require_once('Models/Usuario.php');
				require_once('Models/Book.php');
				$controller= new BookController();
				break; 
		
			case 'gestiones':
				require_once('Models/Profilehistory.php');
				require_once('Models/Usuario.php');
				require_once('Models/Gestiones.php');
				require_once('Models/Mislibros.php');
				$controller= new GestionesController();
				break;
			
			case 'profilehistory':
				require_once('Models/Usuario.php');		
				require_once('Models/Gestiones.php');
				require_once('Models/Profilehistory.php');
				require_once('Models/Seguimiento.php');
				$controller= new ProfilehistoryController();
				break;
		}
		//llama a la acción del controlador
		$controller->{$action }();
	}


	//array con los controladores y sus respectivas acciones
	$controllers= array(
						'usuario'=>['showBook','show_book',/*'setError','saveUser'*/'show','register','save','showregister', 'updateAdmin', 'delete', 'showLogin','login','logout','error', 'welcome','registerUser','showUser','showupdate','updateUser','registerFoto','updatePas', 'savePas','buscar','consulta','consultar_exp'],

						'book'=>['show','showBook','register','save','showupdate','update','delete','search','error'],						

						'gestiones'=>['register','save', 'show', 'showupdate','update', 'delete','buscar', 'registerMislibros','saveMislibros','updateMislibros', 'deleteMislibros','showMislibros','showUpdateMislibros'],

						'profilehistory'=>[/*'show',*/'register','save', 'update','delete',/*'error',*/'showSeguimiento','showDocumento','tramitar','derivarShow','derivar','atenderShow','atender','buscar'],

						'consulta'=>['register','save','show', 'showupdate','update','recetaPdf','buscar']
						);
	//verifica que el controlador enviado desde index.php esté dentro del arreglo controllers
	if (array_key_exists($controller, $controllers)) {//if1 open

		//verifica que el arreglo controllers con la clave que es la variable controller del index exista la acción
		if (in_array($action, $controllers[$controller])) {//if2 open
			//llama  la función call y le pasa el controlador a llamar y la acción (método) que está dentro del controlador
			if (isset($_SESSION['usuario'])){//if3 open
			//ingresa sólo cuando el usuario tiene sesión abierta
				if (strcmp($_SESSION['usuario_tipo'],'A')==0) {//if3.1 open
					call($controller, $action);
				//cierroif3.1
				} elseif(strcmp($_SESSION['usuario_tipo'],'U')==0) {
				//elseif de if3.1 open
					
					// usuario
					if(($controller=='usuario'&&($action=='logout' || $action=='welcome'|| $action=='registerFoto'|| $action=='show'||$action=='updateUser'|| $action=='update'|| $action=='updatePas'|| $action=='savePas'|| $action=='save'))||($controller=='profilehistory'&&($action=='show' || $action=='register'|| $action=='save'|| $action=='showDocumento'||$action=='buscar'||$action=='save'))){ //if3.1.1 open
						call($controller, $action);
						//if3.1.1 cierro
					}else {//else de if3.1.1 open
						call('usuario', 'error');
					}////else de if3.1.1 cierro
				//elseif de if3.1 cierro	
				}else{//else de if3.1 open
					call('usuario', 'error');
				};//else de if3.1 open
			//if3 cierro	
			} elseif($controller=='usuario'&&($action=='showLogin'||$action=='login'||$action=='register'||$action=='save'|| /*$action=='showBook'|| $action=='show_book'||*/ $action=='consulta'|| $action=='consultar_exp')){
				//elseif de if3 open
			// ingresa a páginas que no necesitan sesión de usuario
				call($controller, $action);
			//elseif de if3 cierro	
			}else{//else de if3 open
			//página que indica que no hay permisos
				call($controller, 'error');			
			}//else de if3 cierro
		//if2 cierro	
		}else{//else de if2 open
			call('usuario', 'error');	
		}//else de if2 cierro
	//if1 cierro	
	}else{//else de if1 open
	// le pasa el nombre del controlador y la pagina de error
		call('usuario', 'error');
	}//else de if1 cierro
?>