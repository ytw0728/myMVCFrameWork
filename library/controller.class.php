<?php
class Controller{
	function call_controller($controller , $action){
		require_once(ROOT . DS . 'application' . DS . 'controllers' . DS . $controller .'.php');
		$temp = new $controller();
		$temp->load = new Load();
		$temp->$action();
	}
	/*
	function __destruct(){

	}
	*/
}

class Load{
	function model($string){
		$string = str_replace('/', DS , $string );
		$temp = explode(DS , $string);
		$temp_small = $temp[count($temp)-1];
		$temp[count($temp)-1] = ucwords($temp[count($temp)-1]);
		$string = implode(DS, $temp);
	
		include_once(ROOT . DS . 'application' . DS . 'models' . DS . $string .'.php');
		$this->$temp_small = new $temp[count($temp) -1]();
	}
	function controller($string){
		$string = str_replace('/', DS , $string );
		$temp = explode(DS , $string);
		$temp_small = $temp[count($temp)-1];
		$temp[count($temp)-1] = ucwords($temp[count($temp)-1]);
		$string = implode(DS, $temp);
		
		include_once(ROOT . DS . 'application' . DS . 'controllers' . DS . $string . '.php');
		$this->$temp_small = new $temp[count($temp) -1]();
	}
	function view($string){
		$string = str_replace('/', DS , $string );
		$temp = explode(DS , $string);
		$temp[count($temp)-1] = ucwords($temp[count($temp)-1]);
		$string = implode(DS, $temp);

		include_once(ROOT . DS . 'application' . DS . 'views' . DS . $string . '.php');
	}
}
