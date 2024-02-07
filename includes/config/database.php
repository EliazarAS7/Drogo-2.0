<?php 
    //Se realiza la conexión a la base de datos
function conectarDB(){
    $dns = 'mysql:dbname='.$_ENV['DB_DB'].';host='.$_ENV['DB_HOST'];
    $user= $_ENV['DB_USER'];
    $password = $_ENV['DB_PASS'];
    $db = new PDO($dns, $user, $password);

    if(!$db) {
        echo "Error: No se pudo conectar a MySQL.";
            echo "Error: " . PDO::errorInfo();
            exit;
    } 

    return $db;
    
}