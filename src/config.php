<?php
define("URLSITE", "http://localhost:8080/");

// Database connection parameters
define("SERVIDOR", getenv('MYSQL_HOST') ?: "localhost"); // Database server
define("USUARIO", getenv('MYSQL_USER') ?: "root");       // Database username
define("CONTRASENA", getenv('MYSQL_PASSWORD') ?: "root"); // Database password
define("BASEDATOS", getenv('MYSQL_DATABASE') ?: "mvc");   // Database name
