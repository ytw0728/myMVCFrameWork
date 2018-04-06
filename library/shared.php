<?php

/** Check if environment is development and display errors **/

function setReporting() {
	if (DEVELOPMENT_ENVIRONMENT == true) {
		error_reporting(E_ALL);
		ini_set('display_errors','On');
	}
	else{
		error_reporting(E_ALL);
		ini_set('display_errors','Off');
		ini_set('log_errors', 'On');
		ini_set('error_log', ROOT.DS.'tmp'.DS.'logs'.DS.'error.log');
	}
}

/** Check for Magic Quotes and remove them **/

function stripSlashesDeep($value) {
	$value = is_array($value) ? array_map('stripSlashesDeep', $value) : stripslashes($value);
	return $value;
}

function removeMagicQuotes() {
if ( get_magic_quotes_gpc() ) {
	$_GET    = stripSlashesDeep($_GET   );
	$_POST   = stripSlashesDeep($_POST  );
	$_COOKIE = stripSlashesDeep($_COOKIE);
}
}

/** Check register globals and remove them **/

function unregisterGlobals() {
    if (ini_get('register_globals')) {
        $array = array('_SESSION', '_POST', '_GET', '_COOKIE', '_REQUEST', '_SERVER', '_ENV', '_FILES');
        foreach ($array as $value) {
            foreach ($GLOBALS[$value] as $key => $var) {
                if ($var === $GLOBALS[$key]) {
                    unset($GLOBALS[$key]);
                }
            }
        }
    }
}

/** Main Call Function **/

function callHook() {
	global $url;

	$urlArray = array();
	$urlArray = explode("/",$url);
	for( $i = 0; $i < count($urlArray); $i++){
		if( strlen($urlArray[$i]) == 0 ){
			unset( $urlArray[$i] );
		}
	}
	$url_length = count($urlArray);
	if( $url_length < 1 ){
		$controller = DEFAULT_CONTROLLER;
		$action = "index";
	}
	else if( $url_length <= 1 ){
		$controller = $urlArray[0];	
		array_shift($urlArray);
		$action = "index";
		array_shift($urlArray);
		$queryString = $urlArray;
	}
	else if( $url_length <= 2){
		$controller = $urlArray[0];
		array_shift($urlArray);
		$action = $urlArray[0];
		array_shift($urlArray);
		$queryString = $urlArray;
	}
	else if( $url_length <= 3 ){
		$controller = $urlArray[0];
		array_shift($urlArray);
		$action = $urlArray[0];
		array_shift($urlArray);
		$queryString = $urlArray;
	}
	$controller = ucwords($controller);
	$Controller_temp = new Controller();
	$Controller_temp->call_controller($controller,$action);

}
/** Autoload any classes that are required **/

function __autoload($argu) {
	if (file_exists(ROOT . DS . 'library' . DS . 'controller.class.php')) {
		require_once(ROOT . DS . 'library' . DS .'controller.class.php');
	}
	else{
		/* Error Generation Code Here */
	}
}

setReporting();
removeMagicQuotes();
unregisterGlobals();
callHook();