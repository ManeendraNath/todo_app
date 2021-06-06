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
		if($this->input->post('data_action')) {
			$username = "rest_user";
			$password = "rest_password";
			$data="";
			foreach($_POST as $key=>$value) {
				$data .= $key . "=" . $value . "&";
			}
			$data = rtrim($data, "&");
			$curl = curl_init();
			$apiURL = 'http://localhost/Projects/interview/codigniter/api';
			curl_setopt($curl, CURLOPT_URL, $apiURL);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($curl, CURLOPT_ENCODING, '');
			curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
			curl_setopt($curl, CURLOPT_TIMEOUT, 0);
			curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
			curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
			curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');

			curl_setopt($curl,CURLOPT_POST, 1);
			curl_setopt($curl,CURLOPT_POSTFIELDS,$data);
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

	public function newUser()
	{
		$this->load->view('header');
		$this->load->view('add-user');
		$this->load->view('footer');
	}

	public function editUser()
	{
		$this->load->view('header');
		$this->load->view('edit-user');
		$this->load->view('footer');
	}

	public function deleteUser()
	{
		$this->load->view('header');
		$this->load->view('delete-user');
		$this->load->view('footer');
	}
}
