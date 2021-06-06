<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {

	public function index() {
		$this->load->view('header');
		$this->load->view('index');
		$this->load->view('footer');
	}

	public function action() {
		if($this->input->post('data_action')) {
			$action = $this->input->post('data_action');
			if($action == "fetch_all") {
				$apiUrl = "http://localhost/Projects/interview/api";

				$client = curl_init($apiUrl);
				curl_setopt($client, CURLOPT_RETURNTRANSFER, TURE);
			}
		}
	}
	
	public function addUser()
	{
		$this->load->model('Api_model');
		$this->form_validation->set_rules('name', 'Name', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');

		if($this->form_validation->run() == false) {
			$response['is_error'] = 'yes';
		} else {
			// save user

			$formData['name'] = $this->input->post('name');
			$formData['email'] = $this->input->post('email');

			$this->Api_model->addUser($formData);

			$response['is_error'] = 'no';
		}
	}
}
