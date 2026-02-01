<?php
define("URLSITE", "http://localhost/mvc-project/src/");


// Database connection parameters
define("SERVIDOR", getenv('MYSQL_HOST') ?: "localhost"); // Database server
define("USUARIO", getenv('MYSQL_USER') ?: "root");       // Database username
define("CONTRASENA", getenv('MYSQL_PASSWORD') ?: ""); // Database password
define("BASEDATOS", getenv('MYSQL_DATABASE') ?: "mvc");   // Database name

$conexion = new mysqli(SERVIDOR, USUARIO, CONTRASENA, BASEDATOS);

if ($conexion->connect_error) {
    die("Error al conectar a la base de datos: " . $conexion->connect_error);
} else {
    echo "Conexión exitosa";
}