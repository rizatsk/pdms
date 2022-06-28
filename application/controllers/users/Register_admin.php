<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register_admin extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('Model_Validation');
		$this->load->model('Model_Cek_Id');
		$this->load->model('Model_Id');
		$this->load->model('Model_MaximumCreate');
	}
	
	public function index()
	{
		$data['title'] = 'Register Admin';
		$data['page'] = 'Daftarkan Admin';
		$data['companyId'] = $this->session->userdata('companyId');
		$data['userId'] = $this->session->userdata('userId');
		$data['username'] = $this->session->userdata('username');
		$data['email'] = $this->session->userdata('email');
		$data['roleId'] = $this->session->userdata('roleId');
		$data['companyName'] = $this->session->userdata('companyName');
		
		if ($data['userId'] == null) {
			redirect('authentication');
		}
		
		if ($data['roleId'] !== '777') {
			redirect('dashboard');
		}

		$this->template->load("template/v_template", "users/register/v_formRegisterAdmin", $data);
	}

    public function loadTable($companyId)
    {
        try {
            $query = $this->db->query("SELECT users.id, users.fullname, users.username, users.email, users.created_at, 
										users.role_id, 
										shops.name as shop_name,
										CASE WHEN shops.name IS NULL THEN 'Tidak Ada' ELSE shops.name END AS case
                                        FROM users LEFT JOIN shops ON users.id = shops.admin_id where users.company_id = '$companyId' ORDER BY id");
            
            echo json_encode(array('responseCode' => 200, "responseMessage" => "success", "data" => $query->result()));
			exit;
        } catch (Exception $error) {
            echo json_encode(array('responseCode' => 500, 'responseMessage' => $error));
			exit;
        }
    }

	public function loadComboAdminToko($companyId)
	{
		try {
            $query = $this->db->query("SELECT id, name FROM shops WHERE company_id = '$companyId' AND admin_id IS NULL");
            
            echo json_encode(array('responseCode' => 200, "responseMessage" => "success", "data" => $query->result()));
			exit;
        } catch (Exception $error) {
            echo json_encode(array('responseCode' => 500, 'responseMessage' => $error));
			exit;
        }
	}

	public function register()
	{	
		try {
			if ($this->session->userdata('roleId') === '777') {
				$companyId = $this->session->userdata('companyId');
				$this->Model_Validation->validationRegisterAdmin();
				if ($this->form_validation->run() == FALSE) {
					$messageError = array(
						'errorName' => form_error('name'),
						'errorUsername' => form_error('username'),
						'errorEmail' => form_error('email'),
						// 'errorAdminToko' => form_error('adminToko'),
						'errorPassword' => form_error('password'),
						'errorRePassword' => form_error('re-password'),
					);

					echo json_encode(array('responseCode' => 400,"responseMessage" => "validation", "data" => $messageError));
					exit;
				};

				$maximumCrete = $this->Model_MaximumCreate->maxsimumCreate("users", "company_id = '$companyId'");
				if ($maximumCrete >= 4) {
					echo json_encode(array('responseCode' => 203, 'responseMessage' => 'Maximal User Admin Only 3'));
					exit;
				};
				
				$maxIdUsers = $this->Model_Cek_Id->cekIdUsers();
				$idShop = $this->input->post('adminToko');
				$idUsers = $this->Model_Id->IdManagement('AP', $maxIdUsers);
				$password = hash('sha256', $this->input->post('password'));
				$data = array(
					'id' => $idUsers,
					'fullname' => htmlspecialchars($this->input->post('name')),
					'username' => htmlspecialchars($this->input->post('username')),
					'email' => $this->input->post('email'),
					'password' => $password,
					'role_id' => '775',
					'owner' => $this->session->userdata('userId'),
					'created_at' => date('Y-m-d H:i:s'),
					'updated_at' => date('Y-m-d H:i:s'),
					'company_id' => $this->session->userdata['companyId'],
				);
				$result = $this->db->insert('users', $data);

				if ($this->db->affected_rows() < 0) {
					echo json_encode(array('responseCode' => 403, 'responseMessage' => 'Failed Register'));
					exit;
				}

				$this->db->query("UPDATE shops SET admin_id = '$idUsers' WHERE id = '$idShop'");
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

	public function deleteAdmin($id)
	{
		try{
			if ($this->session->userdata('roleId') === '777') {
				$companyId = $this->session->userdata('companyId');
				$this->db->query("DELETE FROM users WHERE id = '$id' AND company_id = '$companyId'");

				if($this->db->affected_rows() < 0) {
					echo json_encode(array('responseCode' => 403, 'responseMessage' => 'Failed Deleted'));
					exit;
				} 

				$this->db->query("UPDATE shops set admin_id = null WHERE admin_id = '$id' AND company_id = '$companyId'");
				echo json_encode(array('responseCode' => 200, "responseMessage" => "success", "data" => $id));
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
											CASE WHEN shops.name IS NULL THEN 'Toko Tidak Ada' ELSE shops.name END AS case
											FROM users 
											LEFT JOIN shops ON users.id = shops.admin_id
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

	public function editAdminShop()
	{
		try{
			if ($this->session->userdata('roleId') === '777') {
				$companyId = $this->session->userdata('companyId');
				$idUser = $this->input->post('idUser');
				$idShop = $this->input->post('idShop') != null ? $this->input->post('idShop') : null;
				$nowTime = date('Y-m-d H:i:s');

				$this->db->query("UPDATE shops set admin_id = '$idUser', updated_at = '$nowTime' WHERE id = '$idShop' AND company_id = '$companyId'");

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
