<?php
defined("_SYSEXEC") or die(';D');
/** 
 * Manejo de conexiones y ejecuciones de sentencias sql
 * 
 * La Clase dbexec, basicamente maneja las conexiones y peticiones a la base de datos manteniendo un nivel aceptable de seguridad, asi como centralizando la manera manera de solicitar informacion a la base de datos
 * @author Juan Jose A. Baires <jbaires@enchulatuweb.com>
 * @version 1.0
 */

class Dbexec {
    /**
     * Indica el nombre del servidor donde esta alojada la base de datos
     * @var String 
     */
    var $host = "localhost";
    
    /**
     * Indica el nombre de la base de datos asignada para el sistema
     * @var String 
     */
    var $base = "itabreports";
    
    /**
     * Indica el nombre de usuario para crear la conexion al motor de base de datos
     * @var String 
     */
    var $user = "root";
    
    /**
     * Indica la clave de acceso del usuario para crear la conexion a la base de datos
     * @var String 
     */
    var $pass = "";
    
    /**
     * Guarda un objeto de tipo Mysql de conexion a la base de datos, se usa para indentificar la conexiona sobre las que se enviaran a ejecutar las sentencias SQL a la base de datos
     * @var Object 
     */
    var $link;
    
    /**
     * Si se produce algun error este atributo guarda el mensaje de error
     * @var String 
     */
    var $error;
    
    /**
     * Si se produce algun error este atributo guarda el numero de error
     * @var String 
     */
    var $errno;
    
    /**
     * Guardara el ResultSet recuperado de la ejecucion de una sentencia SQL sobre la conexion dada
     * @var Object 
     */
    var $results;
    
    
    /**
     * Intenta crear un enlace de conexion con la base de datos, si lo logra lo devuelve, si no, setea un mensaje de error y retorna false;
     * @return      objeto
     */
    
    function conexion(){
        $link = @mysql_connect($this->host, $this->user, $this->pass);
        if(!$link){
            $this->errno = mysql_errno();
            $this->error = "Error en la conexion al motor de MySQL";
            echo 'se conecto <br>';
            return false;
        }else{
            @mysql_set_charset('utf8',$link);
            if(!@mysql_select_db($this->base,$link)){
                $this->errno = mysql_errno();
                $this->error = "Error al seleccionar la base de datos";
                return false;
            }
        }
		//mysql_set_charset('utf8',$link); 
        return $link;
    }
    
     /**
     * Libera la memoria ocupada por el resultSet     
     * @return      Boolean
     */ 
    function liberar($resultset){
        return @mysql_free_result($resultset);
    }
    
     /**
     * Cierra la conexion echa por el enlace dado (@param)
     * @param       Objeto
     * @return      Boolean
     */ 
    
    function desconectar($enlace){
        return @mysql_close($link);
    }
    
    
    /**
     * Ejecuta una sentencia SQL de una via, es decir que no recupera o retorna ningun resultset desde el motor
     * @param       String
     * @return      Boolean
     */     
    function execute ($sql){
        if(!$this->link){
            $this->link = $this->conexion();
        }        
        if(!@mysql_query($sql)){
            $this->errno = mysql_errno();
            $this->error = "error en la ejecucion de la sentencia SQL: (" . mysql_errno() . ") " . mysql_error();            
            return false;
        }else{
            return true;            
        }        
                
    }
    
    /**
     * Ejecuta una sentencia y devuelve el resultado en un objeto resultSet de mysql
     * @param       String
     * @return      ResultSet
     */
    function queryExecute($sql){
        if(!$this->link){
            $this->link = $this->conexion();
        }
        $this->results = mysql_query($sql);
        if(!$this->results){
            $this->errno = mysql_errno();
            $this->error = "error en la ejecucion de la sentencia SQL: (" . mysql_errno() . ") " . mysql_error();
            return false;
        }else{            
            return true;
        }
    }
    
     /**
     * Devuelve el numero de filas del resultSet guardado a traves de la funcion queryExecute();
     * @return      Integer
     */     
    function numeroFilas(){
        if($this->results){
            return @mysql_num_rows($this->results);
        }else{
            return false;
        }        
    }
    
    /**
     * Devuelve el numero de filas afectadas por la ejecucion de queryExecute();
     * @return      Integer
     */     
    function filasAfectadas(){
        if($this->results){
            return @mysql_affected_rows($this->results);
        }else{
            return false;
        }        
    }
    
     /**
     * Devuelve un arreglo del resultSet guardado a traves de la funcion queryExecute();s
     * @return      Array
     */ 
    function getArray(){
        if($this->results){
            return @mysql_fetch_array($this->results);
        }
    }
    
    /**
     * Devuelve un arreglo de una consulta a una fila en el resultSet guardado a traves de la funcion queryExecute();s
     * @return      Array
     */ 
    function getFila(){
        if($this->results && $this->numeroFilas()==1){
            return @mysql_fetch_row($this->results);
        }else{
            return false;
        }
    }
    
    /**
     * Devuelve el numero de campos del resultSet guardado a traves de la funcion queryExecute();s
     * @return      Integer
     */ 
    function numeroCampos(){
        if($this->results){
            return @mysql_num_fields($this->results);
        }else{
            return false;
        }
    }
    
    /**
     * Devuelve el ultimo indice autoincremental del ultimo registro guardado;
     * @param   String El nombre de la tabla de la que se recuperara el ultimo indice
     * @param   String El nombre del campo 
     * @return      Integer
     */     
    function ultimoIndice($table,$field){
       if(!$this->link){
            $this->link = $this->conexion();
        }
        $result = mysql_query("SELECT $field FROM $table ORDER BY $field DESC LIMIT 1;",$this->link);
        $data = mysql_fetch_array($result);                
        return $data[$field];
    }
    
    
    /**
     * Devuelve el nombre de los campos del resultSet guardado a traves de la funcion queryExecute();s
     * @return      Array
     */ 
    function nombreCampos(){
        if($this->results){
            $campos = Array();
            for($i = 0; $i < $this->numeroCampos(); $i++){
                $campos[] = @mysql_field_name($this->results,$i);
            }            
            return $campos;
        }else{
            return false;
        }
    }
    
    /**
     * Si existe un resulSet, libera la memoria que ocupa y si existe un enlace lo desconecta.
     * @return      Void
     */ 
    function limpiar(){
        if($this->results){
            @mysql_free_result($this->results);
        }
        if($this->link){
            @mysql_close($this->link);
        }
    }
    
    /**
     * Para evitar la acumulacion de conexiones en estado "Sleep" o dormido que saturen el servidor de Base de Datos, se corre este proceso para eliminarlas.
     * @return      Void
     */
    function killAllMysqlThread(){
        if(!$this->link){
            $this->link = $this->conexion();
        }
        
        $result = mysql_query("SHOW PROCESSLIST",$this->link);        
        while ($row=mysql_fetch_array($result)) {
            $process_id=$row["Id"];
            if($row[4]=="Sleep"){                
                $sql="KILL $process_id";
                mysql_query($sql);
            }            
        }
    }
    
    /**
     * Al finalizar la ejecucion de la clase esta funcion automaticamente se ejecuta para liberar memoria y conexiones a la base de datos
     * @return      Void
     */ 
    function __destruct() {
        $this->limpiar();
        @mysql_close();
    }
    
    
    
    
    
}

?>
