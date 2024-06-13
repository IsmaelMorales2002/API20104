<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../includes/DbOperations.php';

$app = AppFactory::create();

/*
	endpoint: createPropietarios
	parameters: idPropietario,nombres,apellidos,fechaNacimiento,genero,telefono,email
	method: POST
*/
$app->post('/createPropietarios',function(Request $request,Response $response){
	if(!haveEmptyParameters(array('idPropietario','nombres','apellidos','fechaNacimiento','genero','telefono','email'),$response)){
		$request_data = $request->getParsedBody();

		$idPropietario = $request_data['idPropietario'];
		$nombres = $request_data['nombres'];
		$apellidos = $request_data['apellidos'];
		$fechaNacimiento = $request_data['fechaNacimiento'];
		$genero = $request_data['genero'];
		$telefono = $request_data['telefono'];
		$email = $request_data['email'];

		$db = new DbOperations;

		$result = $db->createPropietarios($idPropietario,$nombres,$apellidos,$fechaNacimiento,$genero,$telefono,$email);
		if($result == USER_CREATED){

			$message = array();
			$message['error'] = false;
			$message['message'] = "Usuario Creado de Manera Exitosa";

            $response->getBody()->write(json_encode($message));
			return $response
							->withHeader('Content-type','application/json')
							->withStatus(201);


		}else if($result == USER_FAILURE){

			
			$message = array();
			$message['error'] = true;
			$message['message'] = "Ocurrio un Error";

            $response->getBody()->write(json_encode($message));
			return $response
							->withHeader('Content-type','application/json')
							->withStatus(422);

		}else if($result == USER_EXISTS){

			
			$message = array();
			$message['error'] = true;
			$message['message'] = "El Usuario ya existe";

            $response->getBody()->write(json_encode($message));
			return $response
							->withHeader('Content-type','application/json')
							->withStatus(422);
		}
	}
	return $response
							->withHeader('Content-type','application/json')
							->withStatus(422);
});

function haveEmptyParameters($required_params,$response){
	$error = false;
	$error_params = '';
	$request_params = $_REQUEST;

	foreach($required_params as $param){
		if(!isset($request_params[$param]) || strlen($request_params[$param])<= 0){
			$error = true;
			$error_params .= $param . ', ';
		}
	}

	if($error){
		$error_detail = array();
		$error_detail['error'] = true;
		$error_detail['message'] = 'Required paramets ' . substr($error_params,0,-2) . ' are missing or empty';
        $response->getBody()->write(json_encode($error_detail));
	}
	return $error;

}

/*
	endpoint: getAllInmuebles
	method: GET
*/

$app->get("/allinmuebles",function(Request $request, Response $response){
	$db = new DbOperations;
	$inmuebles = $db->getAllInmuebles();

	$response_data = array();

	$response_data['error'] = false;
	$response_data['inmuebles'] = $inmuebles;

	$response->getBody()->write(json_encode($response_data));

	return $response
					->withHeader('Content-type','application/json')
					->withStatus(200);
});

/*
	endpoint: createInmueble
	parameters: idInmueble,departamento,municipio,residencia,calle,poligono,numeroCasa,idPropietario
	method: POST
*/
$app->post('/createInmueble',function(Request $request,Response $response){
	if(!haveEmptyParameters(array('idInmueble','departamento','municipio','residencia','calle','poligono','numeroCasa','idPropietario'),$response)){
		$request_data = $request->getParsedBody();

		$idInmueble = $request_data['idInmueble'];
		$departamento = $request_data['departamento'];
		$municipio = $request_data['municipio'];
		$residencia = $request_data['residencia'];
		$calle = $request_data['calle'];
		$poligono = $request_data['poligono'];
		$numeroCasa = $request_data['numeroCasa'];
		$idPropietario = $request_data['idPropietario'];

		$db = new DbOperations;

		$result = $db->createInmuebles($idInmueble,$departamento,$municipio,$residencia,$calle,$poligono,$numeroCasa,$idPropietario);
		if($result == USER_CREATED){

			$message = array();
			$message['error'] = false;
			$message['message'] = "Inmueble Creado de Manera Exitosa";

            $response->getBody()->write(json_encode($message));
			return $response
							->withHeader('Content-type','application/json')
							->withStatus(201);


		}else if($result == USER_FAILURE){

			
			$message = array();
			$message['error'] = true;
			$message['message'] = "Ocurrio un Error";

            $response->getBody()->write(json_encode($message));
			return $response
							->withHeader('Content-type','application/json')
							->withStatus(422);

		}else if($result == USER_EXISTS){

			
			$message = array();
			$message['error'] = true;
			$message['message'] = "El Inmueble ya existe";

            $response->getBody()->write(json_encode($message));
			return $response
							->withHeader('Content-type','application/json')
							->withStatus(422);
		}
	}
	return $response
							->withHeader('Content-type','application/json')
							->withStatus(422);
});

/*
	endpoint: obtenerPropietario
	method: GET
*/

$app->get("/obtenerPropietario/{id}",function(Request $request, Response $response,array $args){
	$id = $args['id'];
	$db = new DbOperations;
	$propietarios = $db->obtenerPropietario($id);

	$response_data = array();

	$response_data['error'] = false;
	$response_data['propietarios'] = $propietarios;

	$response->getBody()->write(json_encode($response_data));

	return $response
					->withHeader('Content-type','application/json')
					->withStatus(200);
});


$app->run();
