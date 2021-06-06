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
		/*
		 * if requrest method is not POST
		 */
		if($_SERVER['REQUEST_METHOD'] !== 'POST') {
			$response["is_error"] = "yes";
			$response['error'] = 'Wrong Request Method!';
			echo json_encode($response);
			exit;
		}
		$action = $this->input->post('data_action');
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
		 * get all employees details
		 */
		if($action == "fetch_data") {
			$data = $this->api_model->fetchAll();
			$response["is_error"] = "no";
			$response["data"] = $data->result_array();
			echo json_encode($response);
			exit;

		}
		
		/*
		 * add new employee
		 */
		if($action == "add_user") {
			$error = 0;
			if($this->input->post('first_name') == "") {
				$error = 1;
				$errorArray["first_name_error"] = "First name required";
			}
			if($this->input->post('last_name') == "") {
				$error = 1;
				$errorArray["last_name_error"] = "Last name required";
			}
			if($this->input->post('email') == "") {
				$error = 1;
				$errorArray["email_error"] = "Email required";
			}

			if($error == 1) {
				$response['is_error'] = 'yes';
				$response['error'] = $errorArray;
			} else {
				$formData['first_name'] = strtolower($this->input->post('first_name'));
				$formData['last_name'] = strtolower($this->input->post('last_name'));
				$formData['email'] = strtolower($this->input->post('email'));
				$formData['status'] = 1;
				$employee_id = $this->api_model->addUser($formData);

				$transactionData['employee_id'] = $employee_id;
				$transactionData['transaction_details'] ="New employee added.";
				$this->api_model->addTransaction($transactionData);

				$response['is_error'] = 'no';
			}
			echo json_encode($response);
			exit;
		}
		
		/*
		 * get employee details for edit and delete
		 */
		if($action == "get_user_detail") {
			$user_id = $this->input->post('user_id');
			$data = $this->api_model->getUserById($user_id);
			$response["is_error"] = "no";
			$response["data"] = $data;
			echo json_encode($response);
			exit;
		}
		
		/*
		 * update employee details
		 */
		if($action == "update_user") {
			$error = 0;
			if((int)$this->input->post('user_id') == 0) {
				$error = 1;
				$errorArray["user_id_error"] = "user id required";
			}
			if($this->input->post('first_name') == "") {
				$error = 1;
				$errorArray["first_name_error"] = "First name required";
			}
			if($this->input->post('last_name') == "") {
				$error = 1;
				$errorArray["last_name_error"] = "Last name required";
			}
			if($this->input->post('email') == "") {
				$error = 1;
				$errorArray["email_error"] = "Email required";
			}

			if($error == 1) {
				$response['is_error'] = 'yes';
				$response['error'] = $errorArray;
			} else {
				$formData['id'] = $this->input->post('user_id');
				$formData['first_name'] = strtolower($this->input->post('first_name'));
				$formData['last_name'] = strtolower($this->input->post('last_name'));
				$formData['email'] = strtolower($this->input->post('email'));
				$formData['status'] = 1;
				$this->api_model->updateUser($formData);

				$transactionData['employee_id'] = $formData['id'];
				$transactionData['transaction_details'] ="Employee details updated.";
				$this->api_model->addTransaction($transactionData);

				$response['is_error'] = 'no';
			}
			echo json_encode($response);
			exit;
		}
		
		/*
		 * delete employee (for this we will change the employee status 2 so that data will not be lost)
		 */ 
		if($action == "delete_user") {
			
			if((int)$this->input->post('user_id') == 0) {
				$response['is_error'] = 'yes';
				$response['error'] = 'data validation failed';
			} else {
				$formData['id'] = $this->input->post('user_id');
				$formData['status'] = 2;
				$this->api_model->deleteUser($formData);

				$transactionData['employee_id'] = $formData['id'];
				$transactionData['transaction_details'] ="Employee deleted.";
				$this->api_model->addTransaction($transactionData);
				
				$response['is_error'] = 'no';
			}
			echo json_encode($response);
			exit;
		}
	}
}
