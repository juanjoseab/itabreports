<?php

/**
 * Se definen las constantes de los directorios de los recursos fundamentales
 * @author Juan Jose A. Baires
 */
defined("_SYSEXEC") or die("acceso restringido");

//Global definitions
//framework path definitions
$parts = explode( DS, PATH_BASE );

//Defines
define( 'P_ROOT',implode( DS, $parts ) );
define('BASE_URL',str_replace('/index.php','', str_replace("?",'',  str_replace($_SERVER['QUERY_STRING'], "", $_SERVER['REQUEST_URI']))));
define('HOSTNAME',$_SERVER['HTTP_HOST']);
define('FULL_URL',HOSTNAME.DS.str_replace('/index.php','', str_replace("?",'',  str_replace($_SERVER['QUERY_STRING'], "", $_SERVER['REQUEST_URI']))));
define( 'P_SITE',P_ROOT );
define( 'P_INCLUDES',P_ROOT.DS.'includes');
define( 'P_CLASES',P_INCLUDES.DS.'classes');
define( 'P_CONFIG',P_ROOT );
define( 'P_MODULES',P_ROOT.DS.'modules' );
define( 'P_LIB',P_ROOT.DS.'libraries');
//define( 'LIB_FB',P_LIB.DS.'facebook');
define('THEME_DIRNAME','template');
define( 'P_THEME', PATH_BASE.DS.THEME_DIRNAME );
define( 'P_PAGES',PATH_BASE.DS.'pages' );
define( 'VIEWS','views' );
define( 'P_VISTAS',P_ROOT.DS."views");
define( 'P_SYS',P_LIB.DS.'system');
define( 'P_MODELOS',P_ROOT.DS.'models');
define( 'P_CTRLS',P_ROOT.DS.'controladores');
define( 'SITE_NAME',' Reportes iTab');
define( 'SITE_TITLE',' Reportes iTab');
define( 'SESSION_NAME','Mesasdfi53168');
define('ITEMSPERPAGE',20);



date_default_timezone_set("America/Guatemala");  
