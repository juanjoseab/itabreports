<?php
/**
 * Estas funciones se ejecutaran al momento de hacer cualquier solicitud
 * 
 * Esto permite sanitizar cualquier solicitud que se haga a traves de:
 * o $_POST
 * o $_GET
 * o $_REQUEST
 * o $_SESSION
 * o $_COOKIE * 
 * @author Juan Jose A. Baires
 * @version 1.0
 */

defined("_SYSEXEC") or die("acceso restringido");

/**
 * Hace recorrer de manera recursiva los array enviados por medio de POST o GET con la funcion @method sanitizarEntradas 
 * 
 * esto con el fin de elimiar los espacios en blanco al inicio ya al final de cada valor, asi como quitar o convertir cualquier caracter especial y evitar una injeccion SQL o cross-Script
 * @return Void
 */
function recorrerParametros(){
    if($_GET){
        array_walk_recursive($_GET,'sanitizarEntradas');
    }
    if($_POST){
        array_walk_recursive($_POST,'sanitizarEntradas');
    }
    

}


/**
 * sanitiza un item dado por referencia
 * @return Objetct
 */    
function sanitizarEntradas(&$item,$key){
    $item = addslashes(trim($item));
}

recorrerParametros();
?>
