<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Shops extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('Model_Validation');
		$this->load->model('Model_Cek_Id');
		$this->load->model('Model_Id');
		$this->load->model('Model_MaximumCreate');
	}

	public function index()
	{
		$data['title'] = 'Add Shop';
		$data['page'] = 'Tambah Toko';
		$data['userId'] = $this->session->userdata('userId');
		$data['username'] = $this->session->userdata('username');
		$data['email'] = $this->session->userdata('email');
		$data['roleId'] = $this->session->userdata('roleId');
		$data['companyId'] = $this->session->userdata('companyId');
		$data['companyName'] = $this->session->userdata('companyName');
		
		if ($data['userId'] == null) {
			redirect('authentication');
		}
		
		if ($data['roleId'] !== '777' ) {
			redirect('dashboard');
		}

		$this->template->load("template/v_template", "shops/v_shop", $data);
	}

	public function addOrEditShop() 
	{
		try{
			if ($this->session->userdata('roleId') === '777') {
				$idShop = $this->input->post('idShop');
				$companyId = $this->session->userdata('companyId');
				$this->Model_Validation->validationAddShop();
				if ($this->form_validation->run() == FALSE) {
					$messageError = array(
						'errorName' => form_error('name'),
						'errorLocation' => form_error('location'),
					);
					echo json_encode(array('responseCode' => 400, "reponseMessage" => "validation", "data" => $messageError));
					exit;
				}

				if ($idShop == "") {
					$maximumCrete = $this->Model_MaximumCreate->maxsimumCreate("shops", "company_id = '$companyId'");
					if ($maximumCrete >= 3) {
						echo json_encode(array('responseCode' => 203, 'responseMessage' => 'Maximal Shop Only 3'));
						exit;
					};
					
					$maxId = $this->Model_Cek_Id->cekIdShop();
					$id = $this->Model_Id->IdManagement('TK', $maxId);
					$data = array(
						'id' => $id,
						'name' => htmlspecialchars($this->input->post('name')),
						'location' => htmlspecialchars($this->input->post('location')),
						'created_at' => date('Y-m-d H:i:s'),
						'updated_at' => date('Y-m-d H:i:s'),
						'company_id' => $this->session->userdata('companyId'),
					);
					$this->db->insert('shops', $data);
				} else {
					$data = array(
						'name' => htmlspecialchars($this->input->post('name')),
						'location' => htmlspecialchars($this->input->post('location')),
						'updated_at' => date('Y-m-d H:i:s'),
					);
					$this->db->set($data);
					$this->db->where('id', $idShop);
					$this->db->update('shops');
				}

				if($this->db->affected_rows() < 0) {
					echo json_encode(array('responseCode' => 403, 'responseMessage' => 'Failed Save Shop'));
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

	public function loadListShops($companyId, $userId, $roleId) 
	{
		try{
			if ($roleId == 777) {
				$where = "";
			} elseif ($roleId == 775) {
				$where = "AND admin_id = '$userId'";
			};

			$query = $this->db->query("SELECT * FROM shops WHERE company_id = '$companyId' $where");

			echo json_encode(array('responseCode' => 200, "responseMessage" => "success", "data" => $query->result()));
			exit;
		} catch(Exception $error) {
			echo json_encode(array('responseCode' => 500, 'responseMessage' => $error));
			exit;
		}
	}

	public function loadTable($companyId) 
	{
		try{
			$query = $this->db->query("SELECT * FROM shops WHERE company_id = '$companyId'");

			echo json_encode(array('responseCode' => 200, "responseMessage" => "success", "data" => $query->result()));
			exit;
		} catch(Exception $error) {
			echo json_encode(array('responseCode' => 500, 'responseMessage' => $error));
			exit;
		}
	}

	public function getShopById($id)
	{
		try{
			$query = $this->db->query("SELECT * FROM shops WHERE id = '$id'");
			
			if (!$query->row_array()) {
				echo json_encode(array("responseCode" => 404, "responseMessage" => "Tidak Ada Toko"));
				exit;
			};

			echo json_encode(array('responseCode' => 200, "responseMessage" => "success", "data" => $query->row()));
			exit;
		} catch(Exception $error) {
			echo json_encode(array('responseCode' => 500, 'responseMessage' => $error));
			exit;
		}
	}

	public function deleteShopById($id)
	{
		try{
			if ($this->session->userdata('roleId') === '777') {
				$companyId = $this->session->userdata('companyId');
				$this->db->query("DELETE FROM shops WHERE id = '$id' AND company_id = '$companyId'");
				
				if($this->db->affected_rows() < 0) {
					echo json_encode(array('responseCode' => 403, 'responseMessage' => 'Failed Deleted'));
					exit;
				} 
				
				echo json_encode(array('responseCode' => 200, "responseMessage" => "success", "data" => $id));
				exit;
			} else {
				throw new Error('You are not entitled to access this feature');
			}
		} catch(Exception $error){
			echo json_encode(array('responseCode' => 500, 'responseMessage' => $error));
			exit;
		}
	}
}
