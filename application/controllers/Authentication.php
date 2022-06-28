<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Authentication extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('Model_Validation');
	}
	
	public function index()
	{
		$data['userId'] = $this->session->userdata('userId');

		if ($data['userId'] != null) {
			redirect('dashboard');
		}

		$this->template->load("users/authentication/v_template", "users/authentication/v_formLogin");
	}

	public function authentication()
	{
		try{
			$this->Model_Validation->validationLogin();
			if ($this->form_validation->run() == FALSE) {
				$messageError = array(
					'errorUser' => form_error('user'),
					'errorPassword' => form_error('password'),
				);
				echo json_encode(array('responseCode' => 400,"responseMessage" => "validation", "data" => $messageError));
				exit;
			};
			$user = htmlspecialchars($this->input->post('user'));
			$password = hash('sha256',$this->input->post('password'));
			
			$result = $this->db->query("SELECT users.*, companys.name as company_name
									FROM users 
									JOIN companys ON users.company_id = companys.id
									WHERE users.username = '$user' OR users.email = '$user' LIMIT 1");
			if (!$result->row()) {
				echo ("SELECT users.*, companys.name as company_name
				FROM users 
				JOIN companys ON users.company_id = companys.id
				WHERE users.username = '$user' OR users.email = '$user' LIMIT 1");
				// echo json_encode(array("responseCode" => 404, "responseMessage" => "Username atau Email tidak terdaftar"));
				exit;
			}

			$passwordDB = $result->row()->password;
			if ($password !== $passwordDB) {
				echo json_encode(array("responseCode" => 403, "responseMessage" => "Password yang diberikan salah"));
				exit;																																		
			}
			$result = $result->row_array();
			$data = array(
				'userId' => $result['id'],
				'username' => $result['username'],
				'email' => $result['email'],
				'roleId' => $result['role_id'],
				'companyId' => $result['company_id'],
				'fullname' => $result['fullname'],
				'companyName' => $result['company_name'],
			);
			$this->session->set_userdata($data);
			echo json_encode(array("responseCode" => 200, "responseMessage" => "success", "data" => $data));
			exit;

		} catch(Exception $error) {
			echo json_encode(array("responseCode" => 500, "responseMessage" => $error));
			exit;
		}
	}

	public function logout()
	{
		$data = array(
			'userId',
			'username',
			'email',
		);
		$this->session->unset_userdata($data);
		redirect('authentication');
	}
}
