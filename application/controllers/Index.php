<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Index extends CI_Controller {
	
	public function index()
	{
		$this->load->view('header');
		$this->load->view('index');
		$this->load->view('footer');
	}

	public function action() {
		if($this->input->post_get('data_action')) {
			$username = "rest_user";
			$password = "rest_password";
			$requestMethod = $this->input->server('REQUEST_METHOD');
			$data="";
			if($requestMethod === "GET") {
				foreach($_GET as $key=>$value) {
					$data .= $key . "=" . $value . "&";
				}
			} else {
				foreach($_POST as $key=>$value) {
					$data .= $key . "=" . $value . "&";
				}
			}

			$data = rtrim($data, "&");
			$curl = curl_init();
			if($requestMethod === "GET") {
				$apiURL = 'http://localhost/Projects/interview/ludaregames_todo_app/api?'.$data;
			} else {
				$apiURL = 'http://localhost/Projects/interview/ludaregames_todo_app/api';
			}
			curl_setopt($curl, CURLOPT_URL, $apiURL);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($curl, CURLOPT_ENCODING, '');
			curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
			curl_setopt($curl, CURLOPT_TIMEOUT, 0);
			curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
			curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
			curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $requestMethod);
			if($requestMethod !== "GET") { 
				curl_setopt($curl,CURLOPT_POST, 1);
				curl_setopt($curl,CURLOPT_POSTFIELDS,$data);
			}
			curl_setopt($curl, CURLOPT_USERPWD, $username . ":" . $password);

			$response = curl_exec($curl);

			curl_close($curl);
			if (curl_errno($curl)) {
				$data["is_error"] = "yes";
				$data["error"] = "something went wrong. Please try again later.";
				echo json_encode($data);
			} else {
				echo $response;
			}
		}
		exit;
	}

	public function newTodo()
	{
		$this->load->view('header');
		$this->load->view('add-todo');
		$this->load->view('footer');
	}

	public function editTodo()
	{
		$this->load->view('header');
		$this->load->view('edit-todo');
		$this->load->view('footer');
	}

	public function viewTodo()
	{
		$this->load->view('header');
		$this->load->view('view-todo');
		$this->load->view('footer');
	}

	public function completeTodo()
	{
		$this->load->view('header');
		$this->load->view('complete-todo');
		$this->load->view('footer');
	}

	public function deleteTodo()
	{
		$this->load->view('header');
		$this->load->view('delete-todo');
		$this->load->view('footer');
	}
}
