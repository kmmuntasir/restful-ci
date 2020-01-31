<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function testing_my()
	{
		echo 'Testing My<br>';
	}
}

class REST_Controller extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function testing_rest()
	{
		echo 'Testing Rest<br>';
	}
}
