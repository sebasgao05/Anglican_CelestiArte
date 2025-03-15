<?php
session_start();
$host = "localhost";
$user = "root"; 
$password = "";
$database = "anglican_celestiarte";

// Crear conexión
$conexion = new mysqli($host, $user, $password, $database);

// Verificar conexión
if ($conexion->connect_error) {
    die("❌ Error de conexión a MySQL: " . $conexion->connect_error);
} else {
    echo "✅ Conexión exitosa a la base de datos: $database";
}
?>
