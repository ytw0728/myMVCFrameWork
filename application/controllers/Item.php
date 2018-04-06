<?php

class Item extends Controller {
	function __construct(){

	}
	function index(){
		$this->load->view('items/index');
		$this->load->controller('test');
		$this->load->test->abc();
	}
}