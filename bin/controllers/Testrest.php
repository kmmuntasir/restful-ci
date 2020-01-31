<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Testrest extends REST_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		echo 'Test Rest<br>';
		$this->testing_my();
		$this->testing_rest();
	}
}
