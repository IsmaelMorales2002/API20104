<?php

    class DbConnect{
        private $con;

        function connect(){

            include_once dirname(__FILE__).'/Constants.php';

            $this->con = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);

            if(mysqli_connect_errno()){
                echo "Error en la conexion". mysqli_connect_error();
                return null;
            }

            return $this->con;
        }
    }