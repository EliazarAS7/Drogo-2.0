<?php

namespace Model;
use Exception;

class Locker extends ActiveRecord {

    protected static $tabla = 'locker';
    protected static $columnasDB = ['refLocker', 'direccion', 'passwordLocker'];

    public $refLocker;
    public $direccion;
    public $passwordLocker;

    public function __construct($args=[]) {
        $this->refLocker = $args['refLocker'] ?? '';
        $this->direccion = $args['direccion'] ?? '';
        $this->passwordLocker = $args['passwordLocker'] ?? '';
    }
    public function crear(){
        try{
            // Sanitizar los datos
            $atributos = $this->sanitizarAtributos();
            $refLocker = md5(uniqid(rand(), true));

            // Para meterle la id
            $query = "INSERT INTO " . static::$tabla . " (";
            $query .= join(', ', array_keys($atributos));
            $query .= ") VALUES ('{$refLocker}";
            $query .= join("', '", array_values($atributos));
            $query .= "')";

            // Resultado de la consulta
            $resultado = self::$db->query($query);

            return $resultado;
        }catch(Exception $e){
            echo 'Error: ', $e->getMessage(), "\n";
        }
      
    }
    public function actualizar(){
        try{
           // Sanitización de datos
            $atributos = $this->sanitizarAtributos();

            $valores = [];
            foreach ($atributos as $key => $value) {
                $valores[] = "{$key}='{$value}'";
            }

            $query = "UPDATE " . static::$tabla . " SET ";
            $query .= join(', ', $valores);
            $query .= " WHERE refLocker = '" . $this->refLocker . "'";
            $query .= " LIMIT 1";

            return self::$db->query($query); 
        }catch(Exception $e){
            echo 'Error: ', $e->getMessage(), "\n";
        }
        
   }
    public function validar(){
        if(!$this->direccion) {
            self::$errores[] = "Es obligatorio poner la dirección";
        }
        if(!$this->passwordLocker) {
            self::$errores[] = "Es obligatorio poner un password";
        }
        return self::$errores;
    }

    public static function contarLockers() {
        try{
            $query = "SELECT COUNT(*) as total FROM locker";
            $resultado = self::$db->query($query);
            $fila = $resultado->fetch();
            return $fila['total'];
        }catch(Exception $e){
            echo 'Error: ', $e->getMessage(), "\n";
        }
       
    }

    // Método para obtener usuarios con paginación
    public static function obtenerLockersPorPagina($limit, $offset) {
        try{
            $query = "SELECT * FROM locker LIMIT {$limit} OFFSET {$offset}";
            return self::consultarSQL($query);
        }catch(Exception $e){
            echo 'Error: ', $e->getMessage(), "\n";
        }
       
    }

    public function eliminar(){
        try{
            $idValue = $this->refLocker;
            $query = "DELETE FROM " . static::$tabla . " WHERE refLocker = '{$this->refLocker}';";
            $resultado = self::$db->query($query);
    
            return $resultado;
        }catch(Exception $e){
            echo 'Error: ', $e->getMessage(), "\n";
        }
    }
    public function noExisteLocker() {
        try{
            $query = "SELECT * FROM " . self::$tabla . " WHERE refLocker = '{$this->refLocker}';";
            $resultado = self::$db->query($query);
            if($resultado->rowCount()) {
                self::$errores[] = 'El Locker Ya Existe';
                return false;
            }
            return true; 
        }catch(Exception $e){
            echo 'Error: ', $e->getMessage(), "\n";
        }
    }
    // Busca un registro por su id
    public static function find($id) {
        if (!$id) {
            return null; 
        }
    
        try {
            $query = "SELECT * FROM " . static::$tabla . " WHERE refLocker = '{$id}'"; 
            $resultado = self::consultarSQL($query);
    
            if ($resultado === false) {
                // Log del error, p.ej. error_log('Error en la consulta SQL: ' . self::$db->error);
                return null;
            }
    
            return array_shift($resultado);
        } catch (\Exception $e) {
            // Aquí puedes manejar la excepción y, opcionalmente, registrarla
            error_log('Excepción capturada en find: ' . $e->getMessage());
            return null;
        }
    }   
    public static function obtenerDireccion(){
        try{
            self::contarLockers();
            $query = "SELECT refLocker, direccion FROM locker";
            $lockers = self::$db->query($query);
            $cont=0;
            foreach ($lockers as $locker) {
                $direccion[$cont][0]=$locker['refLocker'];
                $direccion[$cont][1]=$locker['direccion'];
                $cont++;
            }
            return $direccion;
        }catch(Exception $e){
            echo 'Error: ', $e->getMessage(), "\n";
        }
    }

    
    public static function mssgExito($codigo){
        switch($codigo){
         case 1: 
             $mensaje="Locker creado con éxito";
             break;
         case 2:
             $mensaje="Locker actualizado con éxito";
             break;
         case 3:
             $mensaje="Locker eliminado con éxito";
             break;
         default:
             $mensaje="Operación realizada con éxito";
             break;
        }
            
        return $mensaje;
     }

     public function validacionExito($codigo){
         $mensaje=$this->mssgExito($codigo);
         $_SESSION['mensaje_exito']=$mensaje;
         header("Location: /lockers");
     }

     public function erroresActualizacionLocker($data){
        //Reinicio del arreglo de errores, just in case
        self::$errores=[];

        //Validación de la dirección del locker
        if(empty(trim($data['direccion']))){
            self::$errores[]="Se debe incluir la dirección del locker";
        }

        //Validación de la contraseña del locker
        if(empty($data['passwordLocker'])){
            self::$errores[]="Se debe incluir la contraseña del locker";
        }

        //Devuelve el arreglo de errores
        return self::$errores;    
    }
}