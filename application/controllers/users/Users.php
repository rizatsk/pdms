<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('Model_Validation');
		$this->load->model('Model_Cek_Id');
		$this->load->model('Model_Id');
	}
	
	public function index()
	{
		$data['title'] = 'User';
		$data['page'] = 'Data User';
        $data['companyId'] = $this->session->userdata('companyId');
		$data['userId'] = $this->session->userdata('userId');
		$data['username'] = $this->session->userdata('username');
		$data['email'] = $this->session->userdata('email');
		$data['roleId'] = $this->session->userdata('roleId');
		
		$userId = $data['userId'];

		if ($data['userId'] == null) {
			redirect('authentication');
		}

		$query = $this->db->query("SELECT users.*, role_users.name AS role_name, companys.name as company_name,
				CASE WHEN shops.name IS NULL THEN 'Tidak terdaftar sebagai admin toko' ELSE shops.name END AS shop_name
				FROM users
				LEFT JOIN shops ON shops.admin_id = users.id
				JOIN companys ON users.company_id = companys.id
				JOIN role_users ON users.role_id = role_users.id WHERE users.id = '$userId' LIMIT 1")->row_array();

		$data['fullname'] = $query['fullname'];
		$data['roleUsers'] = $query['role_name'];		
		$data['shopName'] = $query['shop_name'];
		$data['companyName'] = $query['company_name'];
		$data['createdAt'] = $query['created_at'];
		$data['updatedAt'] = $query['updated_at'];

		$this->template->load("template/v_template", "users/v_user", $data);
	}

	public function changePassword()
	{
		try{
			if ($this->session->userdata('roleId') === '777') {
				$nowTime = date('Y-m-d H:i:s');
				$this->Model_Validation->validationChangePassword();
				if ($this->form_validation->run() == FALSE) {
					$messageError = array(
						'errorOwnerPassword' => form_error('ownerPassword'),
						'errorPasswordNew' => form_error('passwordNew'),
						'errorRePasswordNew' => form_error('rePasswordNew'),
					);
					
					echo json_encode(array('responseCode' => 400,"responseMessage" => "validation", "data" => $messageError));
					exit;
				};
				
				$companyId = $this->session->userdata('companyId');
				$idCEO = $this->session->userdata('userId');
				$idUser = $this->input->post('idUser');
				$ownerPassword = hash('sha256',$this->input->post('ownerPassword'));
				$passwordNew= hash('sha256', $this->input->post('passwordNew'));

				// Validation password owner
				$result = $this->db->query("SELECT * FROM users WHERE id = '$idCEO'");
				if (!$result->row()) {
					echo json_encode(array("responseCode" => 404, "responseMessage" => "Username atau Email tidak terdaftar"));
					exit;
				}
			
				$ownerPasswordDB = $result->row()->password;
				if ($ownerPassword !== $ownerPasswordDB) { 
					echo json_encode(array("responseCode" => 403, "responseMessage" => "Password yang diberikan salah"));
					exit;																																		
				}

				$this->db->query("UPDATE users set password = '$passwordNew', updated_at = '$nowTime' WHERE id = '$idUser' AND company_id = '$companyId'");

				if($this->db->affected_rows() < 0) {
					echo json_encode(array('responseCode' => 403, 'responseMessage' => 'Failed Change Passwowrd'));
					exit;
				} 

				echo json_encode(array('responseCode' => 200, "responseMessage" => "success", "data" => 'ok'));
				exit;
			} else {
				throw new Error('You are not entitled to access this feature');
			}
		} catch(Exception $error) {
			echo json_encode(array('responseCode' => 500, 'responseMessage' => $error));
			exit;
		}
	}

	public function getDataUserById($id) 
	{
		try{
			if ($this->session->userdata('roleId') === '777') {
				$companyId = $this->session->userdata('companyId');
				$query = $this->db->query("SELECT users.*, shops.id as shopId, shops.name as shopName,
											companys.name as company_name,
											CASE WHEN shops.name IS NULL THEN 'Toko Tidak Ada' ELSE shops.name END AS case
											FROM users 
											LEFT JOIN shops ON users.id = shops.admin_id
											JOIN companys ON users.company_id = companys.id
											WHERE users.id = '$id' AND users.company_id = '$companyId'")->row_array();

				if($this->db->affected_rows() < 0) {
					echo json_encode(array('responseCode' => 403, 'responseMessage' => 'Failed Deleted'));
					exit;
				} 

				echo json_encode(array('responseCode' => 200, "responseMessage" => "success", "data" => $query));
				exit;
			} else {
				throw new Error('You are not entitled to access this feature');
			}
		} catch(Exception $error) {
			echo json_encode(array('responseCode' => 500, 'responseMessage' => $error));
			exit;
		}
	}

	public function updateProfileCeo()
	{
		try{
			if ($this->session->userdata('roleId') === '777') {
				
				$this->Model_Validation->validationUpdateProfileCeo();
				if ($this->form_validation->run() == FALSE) {
					$messageError = array(
						'errorFullname' => form_error('fullname'),
					);
					
					echo json_encode(array('responseCode' => 400,"responseMessage" => "validation", "data" => $messageError));
					exit;
				};
				
				$userId = $this->session->userdata('userId');
				$fullname = $this->input->post('fullname');
				$nowTime = date('Y-m-d H:i:s');

				$data = array(
					'fullname' => $fullname,
				);

				$this->db->query("UPDATE users
								SET fullname = '$fullname',
								updated_at = '$nowTime'
								WHERE id = '$userId'");

				if ($this->db->affected_rows() < 0) {
					echo json_encode(array('responseCode' => 403, 'responseMessage' => 'Failed Update'));
					exit;
				}

				echo json_encode(array('responseCode' => 200, "responseMessage" => "success", "data" => $data));
				exit;
			} else {
				throw new Error('You are not entitled to access this feature');
			}
		} catch(Exception $error) {
			echo json_encode(array('responseCode' => 500, 'responseMessage' => $error));
			exit;
		}
	}

	public function changePasswordCeo()
	{
		try{
			if ($this->session->userdata('roleId') === '777') {
				
				$this->Model_Validation->validationChangePasswordCeo();
				if ($this->form_validation->run() == FALSE) {
					$messageError = array(
						'errorPasswordNew' => form_error('password'),
						'errorPrePasswordNew' => form_error('pre-password'),
					);
					
					echo json_encode(array('responseCode' => 400,"responseMessage" => "validation", "data" => $messageError));
					exit;
				};
				
				$companyId = $this->session->userdata('companyId');
				$userId = $this->session->userdata('userId');
				$passwordNew = hash('sha256', $this->input->post('password'));
				$nowTime = date('Y-m-d H:i:s');
				
				$this->db->query("UPDATE users SET password = '$passwordNew', updated_at = '$nowTime' WHERE id = '$userId' AND company_id = '$companyId'");

				if($this->db->affected_rows() < 0) {
					echo json_encode(array('responseCode' => 403, 'responseMessage' => 'Failed Update'));
					exit;
				} 

				echo json_encode(array('responseCode' => 200, "responseMessage" => "success", "data" => 'ok'));
				exit;
			} else {
				throw new Error('You are not entitled to access this feature');
			}
		} catch(Exception $error) {
			echo json_encode(array('responseCode' => 500, 'responseMessage' => $error));
			exit;
		}
	}
}