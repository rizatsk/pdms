<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('Model_Validation');
		$this->load->model('Model_Cek_Id');
		$this->load->model('Model_Id');
	}
	
	public function index()
	{
		$data['title'] = 'Register Admin';
		$data['page'] = 'Daftarkan Admin';
		$data['userId'] = $this->session->userdata('userId');
		$data['username'] = $this->session->userdata('username');
		$data['email'] = $this->session->userdata('email');
		$data['roleId'] = $this->session->userdata('roleId');
		$data['roleId'] = $this->session->userdata('roleId');
		
		if ($data['userId'] == null) {
			redirect('authentication');
		}
		
		if ($data['roleId'] !== '999') {
			redirect('dashboard');
		}

		$this->template->load("users/register/v_template", "users/register/v_formRegister", $data);
	}

	public function register()
	{	
		try {
			$this->Model_Validation->validationRegister();
			if ($this->form_validation->run() == FALSE) {
				$messageError = array(
					'errorName' => form_error('name'),
					'errorUsername' => form_error('username'),
					'errorEmail' => form_error('email'),
					'errorPassword' => form_error('password'),
					'errorRePassword' => form_error('re-password'),
				);
				echo json_encode(array('responseCode' => 400,"responseMessage" => "validation", "data" => $messageError));
				exit;
			};

			$maxIdUsers = $this->Model_Cek_Id->cekIdUsers();
			$idUsers = $this->Model_Id->IdManagement('US', $maxIdUsers);
			$password = hash('sha256', $this->input->post('password'));
			$data = array(
				'id' => $idUsers,
				'fullname' => htmlspecialchars($this->input->post('name')),
				'username' => htmlspecialchars($this->input->post('username')),
				'email' => $this->input->post('email'),
				'password' => htmlspecialchars($password),
				'role_id' => '777',
				'created_at' => date('Y-m-d H:i:s'),
				'updated_at' => date('Y-m-d H:i:s'),
			);
			$result = $this->db->insert('users', $data);

			if ($this->db->affected_rows() < 0) {
				echo json_encode(array('responseCode' => 403, 'responseMessage' => 'Failed Register'));
				exit;
			}

			echo json_encode(array('responseCode' => 200, "responseMessage" => "success", "data" => $data));
			exit;
		} catch(Exception $error) {
			echo json_encode(array('responseCode' => 500, 'responseMessage' => $error));
			exit;
		}
	}
}
