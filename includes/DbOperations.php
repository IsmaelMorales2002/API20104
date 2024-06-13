<?php

    class DbOperations{
        private $con;

        function __construct(){
            require_once dirname(__FILE__) . '/DbConnect.php';
            $db = new DbConnect;
            $this-> con =$db->connect();
        }

        public function createPropietarios($idPropietario,$nombres,$apellidos,$fechaNacimiento,$genero,$telefono,$email){
            if(!$this->IdPropietarioExiste($idPropietario)){
                $stmt = $this->con->prepare("INSERT INTO propietarios (idPropietario,nombres,apellidos,fechaNacimiento,genero,telefono,email) VALUES (?,?,?,?,?,?,?)");
                $stmt->bind_param("sssssss",$idPropietario,$nombres,$apellidos,$fechaNacimiento,$genero,$telefono,$email);
                if($stmt->execute()){
                    return USER_CREATED;
                }else{
                    return USER_FAILURE;
                }
            }
            return USER_EXISTS;
        }

        private function IdPropietarioExiste($idPropietario){
            $stmt = $this->con->prepare("SELECT idPropietario FROM propietarios WHERE idPropietario = ? ");
            $stmt->bind_param("s",$idPropietario);
            $stmt->execute();
            $stmt->store_result();
            return $stmt->num_rows() > 0;
        }

        public function getAllInmuebles(){
            $stmt = $this->con->prepare("SELECT idInmueble,departamento,municipio,residencia,calle,poligono,numeroCasa,idPropietario FROM inmueble;");
            $stmt->execute();
            $stmt->bind_result($idInmueble,$departamento,$municipio,$residencia,$calle,$poligono,$numeroCasa,$idPropietario);
            $inmuebles = array();
            while($stmt->fetch()){
                $inmueble = array();
                $inmueble['idInmueble'] = $idInmueble;
                $inmueble['departamento'] = $departamento;
                $inmueble['municipio'] = $municipio;
                $inmueble['residencia'] = $residencia;
                $inmueble['calle'] = $calle;
                $inmueble['poligono'] = $poligono;
                $inmueble['numeroCasa'] = $numeroCasa;
                $inmueble['idPropietario'] = $idPropietario;
                array_push($inmuebles,$inmueble);
            }
            return $inmuebles;
        }

        public function createInmuebles($idInmueble,$departamento,$municipio,$residencia,$calle,$poligono,$numeroCasa,$idPropietario){
            if(!$this->IdInmuebleExiste($idInmueble)){
                $stmt = $this->con->prepare("INSERT INTO inmueble (idInmueble,departamento,municipio,residencia,calle,poligono,numeroCasa,idPropietario) VALUES (?,?,?,?,?,?,?,?);");
                $stmt->bind_param("ssssssss",$idInmueble,$departamento,$municipio,$residencia,$calle,$poligono,$numeroCasa,$idPropietario);
                if($stmt->execute()){
                    return USER_CREATED;
                }else{
                    return USER_FAILURE;
                }
            }
            return USER_EXISTS;
        }

        private function IdInmuebleExiste($idInmueble){
            $stmt = $this->con->prepare("SELECT idInmueble FROM inmueble WHERE idInmueble = ? ");
            $stmt->bind_param("s",$idInmueble);
            $stmt->execute();
            $stmt->store_result();
            return $stmt->num_rows() > 0;
        }

        public function obtenerPropietario($idPropietario){
            $stmt = $this->con->prepare("SELECT idPropietario,nombres,apellidos,fechaNacimiento,genero,telefono,email FROM propietarios WHERE idPropietario = ?");
            $stmt->bind_param("s", $idPropietario);
            $stmt->execute();
            $stmt->bind_result($idPropietario,$nombres,$apellidos,$fechaNacimiento,$genero,$telefono,$email);
            $propietarios = array();
            while($stmt->fetch()){
                $propietario = array();
                $propietario['idPropietario'] = $idPropietario;
                $propietario['nombres'] = $nombres;
                $propietario['apellidos'] = $apellidos;
                $propietario['fechaNacimiento'] = $fechaNacimiento;
                $propietario['genero'] = $genero;
                $propietario['telefono'] = $telefono;
                $propietario['email'] = $email;
                array_push($propietarios,$propietario);
            }
            return $propietarios;
        }



    }

