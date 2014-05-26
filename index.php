<?php
/**
 * 
 * El sistema de Mapas del La Unidad de Planificacion Estrategica,
 * tiene como objetivo, administrar, actualizar y gestionar el estado de la red
 * de servicios de salud en sus diferentes niveles, asi como geolocalizar cada uno
 * de los servicios en un mapa con Google maps.
 * Este Sistema sera usado por la Unidad de Planificacion Estrategica (UPE)
 * del Ministerio de Salud Publica y Asistencia Social (MSPAS).
 * 
 * @version        1.0
 * @copyright      Copyright (C) Sistema de Información Gerencial de Salud (SIGSA), Ministerio de Salud Publica (MSPAS) - Todos los Derechos Reservados.
 * @author         JBaires (Juan Jose Ajcuc Baires) 
 */

//echo sha1(md5("12547")); die;
//$_SESSION['usuario'] = true;
/** 
 * Se instancia en 1 o true para indicar que este es un archivo padre y desde el cual se pueden llamar y ejecutar otros controladores y modelos. * 
 * @param boolean
 * 
 */
define( '_SYSEXEC', 1 );

/**
 * Se Define PATH_BASE para crear una variable estatica que contendra la ruta base desde donde se ejecutaran todos los ficheros
 * o desde donde se mandaran a traer las librerias y controladores
 * @param       function
 */
define('PATH_BASE', dirname(__FILE__) );


/**
 * Se define la constante DS que contendra en separador de directorios en funcion al sistema operativo
 * @param       Constante
 */
define( 'DS', DIRECTORY_SEPARATOR );
require_once ( PATH_BASE .DS.'includes'.DS.'define.php' );

//Se inicializan las Sesiones
session_name(SESSION_NAME);
session_start();

require_once ( PATH_BASE .DS.'includes'.DS.'init.php' );
require_once ( P_INCLUDES . DS .'required.php' );
$system = new Framework();
$system->display->deployContent();




?>