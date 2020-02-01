<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

	public function __construct()  {
		parent::__construct();
	}
}

class REST_Controller extends MY_Controller {

	public $_POST_GLOBAL;
	public $_GET_GLOBAL;

	public function __construct() {
		parent::__construct();
		$this->prepareMethodData();
	}

	/*
	* Data Methods
	*/

	public function input($method, $key=NULL, $value=NULL) {
		if(($method == GET || $method == DELETE)) {
			$_dataObj = &$this->_GET_GLOBAL;
		}
		else $_dataObj = &$this->_POST_GLOBAL;

		if($key) {
			if(is_array($key)) { // Return multiple key values
				$result = new stdClass();
				foreach ($key as $k) {
					$result->$k = $this->input($method, $k);
				}
				return $result;
			}
			else if(is_object($key)) { // Overwrite object with parameter data
				$_dataObj = $key;
			}
			else if($value) { // Update single key with single value
				$_dataObj->$key = $value;
			}
			else return isset($_dataObj->$key) ? $_dataObj->$key : null; // Return the value of the single key
			return true;
		}
		else return $_dataObj; // Return whole object
	}

	public function get($key=NULL, $value=NULL) {
		return $this->input(GET, $key, $value);
	}

	public function post($key=NULL, $value=NULL) {
		return $this->input(POST, $key, $value);
	}

	public function put($key=NULL, $value=NULL) {
		return $this->input(PUT, $key, $value);
	}

	public function patch($key=NULL, $value=NULL) {
		return $this->input(PATCH, $key, $value);
	}

	public function delete($key=NULL, $value=NULL) {
		return $this->input(DELETE, $key, $value);
	}

	public function prepareMethodData() {
		$this->_POST_GLOBAL = json_decode($this->input->raw_input_stream);
		$this->_GET_GLOBAL = (object) $_GET;
	}

	 /*
	 * Response Methods
	 */

	public function response($payload, $message=NULL, $status=NULL) {
		if(!$status) $status = "success";
		if(!$message) $message = "success";

		$response = new stdClass();
		$response->status = $status;
		$response->message = $message;
		$response->payload = $payload;

		return $response;
	}

	public function jsonResponse($payload, $message=NULL, $status=NULL) {
		return json_encode($this->response($payload, $message, $status), JSON_PRETTY_PRINT);
	}

	public function restResponse($payload, $message=NULL, $status=NULL, $HTTPstatus=NULL) {
		if(!$HTTPstatus) $HTTPstatus = HTTP_OK;

		$this->output
			->set_header('Cache-Control: no-store, no-cache, must-revalidate')
			->set_content_type('application/json', 'UTF-8')
			->set_status_header($HTTPstatus)
			->set_output($this->jsonResponse($payload, $message, $status));
	}
}
