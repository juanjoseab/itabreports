<?php
/**
 * Se hacen llamadas unicas a los ficheros que contienen las clases nencesarias 
 * para construir el contenido del sistema, asi como aquellas librerias que son
 * indispensables para su funcionamiento y que deben ser cargadas desde el principio
 * 
 * @author Juan Jose A. Baires
 * @version 1.0
 */
defined("_SYSEXEC") or die('Acceso restringido');

require_once ( P_SYS.DS.'database.php' );
require_once ( P_CTRLS.DS.'ControlSesiones.php' );

require_once ( P_SYS.DS.'display.php' );

require_once ( P_SYS.DS.'modeloMaestro.php' );
require_once ( P_SYS.DS.'controladorMaestro.php' );
require_once ( P_INCLUDES.DS.'framework.php' );
require_once (P_CLASES.DS.'ormclass.php');
?>