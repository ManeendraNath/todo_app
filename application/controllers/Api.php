<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {

    public function __construct() {
        parent::__construct();
		$this->load->model('api_model');
    }

	public function index() {
		/*
		 * if user authentication not available
		 */
		if (!isset($_SERVER['PHP_AUTH_USER'])) {
			header('WWW-Authenticate: Basic realm="My Realm"');
			header('HTTP/1.0 401 Unauthorized');
			$response["is_error"] = "yes";
			$response['error'] = 'Unauthorised access!';
			echo json_encode($response);
			exit;
		}
		/*
		 * if username or password not matched
		 */
		if($_SERVER['PHP_AUTH_USER']!="rest_user" || $_SERVER['PHP_AUTH_PW']!="rest_password") {
			header('WWW-Authenticate: Basic realm="My Realm"');
			header('HTTP/1.0 401 Unauthorized');
			$response["is_error"] = "yes";
			$response['error'] = 'Unauthorised access!';
			echo json_encode($response);
			exit;
		}
if($this->input->server('REQUEST_METHOD') === "GET") {
		$action = $this->input->get('data_action');
} else {
		$action = $this->input->post('data_action');
}
		/*
		 * if valid data_action is not available.
		 */
		if(empty($action)) {
			$response["is_error"] = "yes";
			$response["error"] = "Unknown request";
			echo json_encode($response);
			exit;
		} 

		/*
		 * get all todo details
		 */
		if($action == "fetch_data") {
			$isRequestMethodValid = $this->validateRequestMethod('GET');
			/*
			 * if requrest method is not GET
			 */
			if($this->input->get('status') == "") {
				$status = NULL;
			} else {
				$status = (int)$this->input->get('status');
			}
			if($isRequestMethodValid == 'no') {
				$response["is_error"] = "yes";
				$response['error'] = 'Wrong Request Method!';
				echo json_encode($response);
				exit;
			}
			$data = $this->api_model->fetchAll($status);
			$response["is_error"] = "no";
			$response["data"] = $data->result_array();
			echo json_encode($response);
			exit;

		}
		
		/*
		 * add new todo
		 */
		if($action == "add_todo") {

			$isRequestMethodValid = $this->validateRequestMethod('POST');
			/*
			 * if requrest method is not POST
			 */
			if($isRequestMethodValid == 'no') {
				$response["is_error"] = "yes";
				$response['error'] = 'Wrong Request Method!';
				echo json_encode($response);
				exit;
			}

			$error = 0;
			if($this->input->post('name') == "") {
				$error = 1;
				$errorArray["name_error"] = "Name required";
			}
			if($this->input->post('short_desc') == "") {
				$error = 1;
				$errorArray["short_desc_error"] = "Short Description required";
			}
			if($this->input->post('long_desc') == "") {
				$error = 1;
				$errorArray["long_desc_error"] = "Long Description required";
			}

			if($error == 1) {
				$response['is_error'] = 'yes';
				$response['error'] = $errorArray;
			} else {
				$formData['name'] = strtolower($this->input->post('name'));
				$formData['short_desc'] = strtolower($this->input->post('short_desc'));
				$formData['long_desc'] = strtolower($this->input->post('long_desc'));
				$this->api_model->addTodo($formData);

				$response['is_error'] = 'no';
			}
			echo json_encode($response);
			exit;
		}
		
		/*
		 * get todo details for edit and delete
		 */
		if($action == "get_todo_detail") {

			$isRequestMethodValid = $this->validateRequestMethod('GET');
			/*
			 * if requrest method is not GET
			 */
			if($isRequestMethodValid == 'no') {
				$response["is_error"] = "yes";
				$response['error'] = 'Wrong Request Method!';
				echo json_encode($response);
				exit;
			}
			$todo_id = $this->input->get('todo_id');
			$data = $this->api_model->getTodoById($todo_id);
			$response["is_error"] = "no";
			$response["data"] = $data;
			echo json_encode($response);
			exit;
		}
		
		/*
		 * update todo details
		 */
		if($action == "update_todo") {

			$isRequestMethodValid = $this->validateRequestMethod('POST');
			/*
			 * if requrest method is not POST
			 */
			if($isRequestMethodValid == 'no') {
				$response["is_error"] = "yes";
				$response['error'] = 'Wrong Request Method!';
				echo json_encode($response);
				exit;
			}
			$error = 0;
			if((int)$this->input->post('todo_id') == 0) {
				$error = 1;
				$errorArray["todo_id_error"] = "todo id required";
			}
			if($this->input->post('name') == "") {
				$error = 1;
				$errorArray["name_error"] = "Name required";
			}
			if($this->input->post('short_desc') == "") {
				$error = 1;
				$errorArray["short_desc_error"] = "Short Description required";
			}
			if($this->input->post('long_desc') == "") {
				$error = 1;
				$errorArray["long_desc_error"] = "Long Description required";
			}

			if($error == 1) {
				$response['is_error'] = 'yes';
				$response['error'] = $errorArray;
			} else {
				$formData['id'] = $this->input->post('todo_id');
				$formData['name'] = strtolower($this->input->post('name'));
				$formData['short_desc'] = strtolower($this->input->post('short_desc'));
				$formData['long_desc'] = strtolower($this->input->post('long_desc'));
				$this->api_model->updateTodo($formData);

				$response['is_error'] = 'no';
			}
			echo json_encode($response);
			exit;
		}
		
		/*
		 * mark complete todo
		 */
		if($action == "complete_todo") {
			
			$isRequestMethodValid = $this->validateRequestMethod('POST');
			/*
			 * if requrest method is not POST
			 */
			if($isRequestMethodValid == 'no') {
				$response["is_error"] = "yes";
				$response['error'] = 'Wrong Request Method!';
				echo json_encode($response);
				exit;
			}
			$error = 0;
			if((int)$this->input->post('todo_id') == 0) {
				$error = 1;
				$errorArray["todo_id_error"] = "todo id required";
			}
			if($error == 1) {
				$response['is_error'] = 'yes';
				$response['error'] = $errorArray;
			} else {
				$todo_id = $this->input->post('todo_id');
				$this->api_model->completeTodo($todo_id);

				$response['is_error'] = 'no';
			}
			echo json_encode($response);
			exit;
		}
		
		/*
		 * delete todo (for this we will change the todo status 2 so that data will not be lost)
		 */ 
		if($action == "delete_todo") {

			$isRequestMethodValid = $this->validateRequestMethod('POST');
			/*
			 * if requrest method is not POST
			 */
			if($isRequestMethodValid == 'no') {
				$response["is_error"] = "yes";
				$response['error'] = 'Wrong Request Method!';
				echo json_encode($response);
				exit;
			}
			
			$error = 0;
			if((int)$this->input->post('todo_id') == 0) {
				$error = 1;
				$errorArray["todo_id_error"] = "todo id required";
			}
			if($error == 1) {
				$response['is_error'] = 'yes';
				$response['error'] = $errorArray;
			} else {
				$todo_id = $this->input->post('todo_id');
				$this->api_model->deleteTodo($todo_id);
				
				$response['is_error'] = 'no';
			}
			echo json_encode($response);
			exit;
		}
	}

	private function validateRequestMethod($requiredRequiredMethod) {
		if($this->input->server('REQUEST_METHOD') !== $requiredRequiredMethod) {
			return 'no';
		} else {
			return 'yes';
		}
	}
}
