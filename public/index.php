<?php	

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname( dirname(__FILE__) ) );
$url = "";
if( count($_GET) != 0 ){
	$url = $_GET['url'];
}

require_once (ROOT . DS . 'library' . DS . 'bootstrap.php');