<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Companys extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('Model_Validation');
		$this->load->model('Model_Cek_Id');
		$this->load->model('Model_Id');
	}
	
	public function index()
	{
		$data['title'] = 'Companys';
		$data['page'] = $this->session->userdata('companyName');
		$data['userId'] = $this->session->userdata('userId');
		$data['username'] = $this->session->userdata('username');
		$data['email'] = $this->session->userdata('email');
		$data['roleId'] = $this->session->userdata('roleId');
		$data['companyId'] = $this->session->userdata('companyId');
		$data['companyName'] = $this->session->userdata('companyName');
		$companyId = $data['companyId'];

		if ($data['userId'] == null) {
			redirect('authentication');
		}
		
		if ($data['roleId'] !== '777' ) {
			redirect('dashboard');
		}

		$dataCompanys = $this->getCompanyById($companyId);
		$data['companyCreatedAt'] = $dataCompanys['created_at'];
		$data['companyUpdatedAt'] = $dataCompanys['updated_at'];
		$data['companyOwner'] = $dataCompanys['owner'];

		$this->template->load("template/v_template", "companys/v_companys", $data);
	}

	private function getCompanyById($companyId)
	{
		$dataCompanys = $this->db->query("SELECT * FROM companys WHERE id = '$companyId'")->row_array();
		return $dataCompanys;
	}

	public function ajaxGetCompanyById($id) 
	{
		try{
			if ($this->session->userdata('roleId') === '777') {
				$dataCompanys = $this->getCompanyById($id);
				
				echo json_encode(array('responseCode' => 200, "responseMessage" => "success", "data" => $dataCompanys));
				exit;
			} else {
				throw new Error('You are not entitled to access this feature');
			}
		} catch(Exception $error) {
			echo json_encode(array('responseCode' => 500, 'responseMessage' => $error));
			exit;
		}
	}

	public function updateCompanyName()
	{
		try{
			if ($this->session->userdata('roleId') === '777') {
				$this->Model_Validation->validationUpdateCompanyName();
				if ($this->form_validation->run() == FALSE) {
					$messageError = array(
						'errorCompanyName' => form_error('companyName'),
					);
					
					echo json_encode(array('responseCode' => 400,"responseMessage" => "validation", "data" => $messageError));
					exit;
				};
				
				$companyId = htmlspecialchars($this->session->userdata('companyId'));
				$companyName = htmlspecialchars($this->input->post('companyName'));
				$nowTime = date('Y-m-d H:i:s');

				$data = array(
					'companyName' => $companyName,
					'companyId' => $companyId,
				);

				$this->db->query("UPDATE companys
								SET name = '$companyName',
								updated_at = '$nowTime'
								WHERE id = '$companyId'");

				if ($this->db->affected_rows() < 0) {
					echo json_encode(array('responseCode' => 403, 'responseMessage' => 'Failed Update'));
					exit;
				}
				
				// Update session companyName
				$this->session->set_userdata('companyName', $companyName);

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

	public function loadCategory() 
	{
		try{
			if ($this->session->userdata('roleId') === '777') {
				$companyId = $this->session->userdata('companyId');
				$query = $this->db->query("SELECT id AS categoryId, name AS categoryName FROM categories WHERE company_id = '$companyId'");
				$data = $query->result();

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

	public function addOrEditCategory()
	{
		try{
			if ($this->session->userdata('roleId') === '777') {
				$categoryId = htmlspecialchars($this->input->post('categoryId'));
				if ( $categoryId === '') {
					$this->Model_Validation->validationCategory();
					if ($this->form_validation->run() == FALSE) {
						$messageError = array(
							'errorCategoryName' => form_error('categoryName'),
						);
						
						echo json_encode(array('responseCode' => 400,"responseMessage" => "validation", "data" => $messageError));
						exit;
					};
				}
				
				$companyId = $this->session->userdata('companyId');
				$categoryName = htmlspecialchars(strtolower($this->input->post('categoryName')));
				$nowTime = date('Y-m-d H:i:s');
				$maxId = $this->Model_Cek_Id->cekIdCategory();
				$id = $this->Model_Id->IdManagement('CT', $maxId);
				
				if ($categoryId != null) {
					$data = array(
						'name' => $categoryName,
						'updated_at' => $nowTime,
					);
					$this->db->set($data);
					$this->db->where('id', $categoryId);
					$this->db->update('categories');
				} else {
					$data = array(
						'id' => $id,
						'name' => $categoryName,
						'company_id' => $companyId,
						'created_at' => $nowTime,
						'updated_at' => $nowTime,
					);

					$this->db->insert('categories', $data);
				}	
	
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

	public function deleteCategory()
	{
		try{
			if ($this->session->userdata('roleId') === '777') {
				
				$companyId = $this->session->userdata('companyId');
				$categoryId = htmlspecialchars($this->input->post('categoryId'));
				
				$data = array(
					'categoryId' => $categoryId,
				);
				
				$this->db->query("DELETE FROM categories WHERE id = '$categoryId' AND company_id = '$companyId'");
	
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

	public function loadProducts()
	{
		try{
			if ($this->session->userdata('roleId') === '777') {
				$companyId = $this->session->userdata('companyId');
				$query = $this->db->query("SELECT products.id AS productId, products.name AS productName, products.category_id AS categoryId,  
											categories.name AS categoryName,
											products.price AS productPrice
											FROM products LEFT JOIN categories
											ON products.category_id = categories.id
											WHERE products.company_id = '$companyId'");
				$data = $query->result();

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

	public function addOrEditProduct()
	{
		try{
			if ($this->session->userdata('roleId') === '777') {
				$productId = htmlspecialchars($this->input->post('productId'));
				if ($productId === '') {
					$this->Model_Validation->validationProduct();
					if ($this->form_validation->run() == FALSE) {
						$messageError = array(
							'errorProductName' => form_error('productName'),
							'errorProductPrice' => form_error('productPrice'),
						);
						
						echo json_encode(array('responseCode' => 400,"responseMessage" => "validation", "data" => $messageError));
						exit;
					};
				}
				
				$companyId = $this->session->userdata('companyId');
				
				$productName = htmlspecialchars($this->input->post('productName'));
				$productPrice = htmlspecialchars($this->input->post('productPrice'));
				$productCategoryId = htmlspecialchars($this->input->post('productCategoryId'));
				$nowTime = date('Y-m-d H:i:s');
				$maxId = $this->Model_Cek_Id->cekIdProduct();
				$id = $this->Model_Id->IdManagement('PR', $maxId);
				
				if ($productId != null) {
					$data = array(
						'name' => $productName,
						'category_id' => $productCategoryId,
						'price' => $productPrice,
						'updated_at' => $nowTime,
					);
					$this->db->set($data);
					$this->db->where('id', $productId);
					$this->db->update('products');
				} else {
					$data = array(
						'id' => $id,
						'name' => $productName,
						'category_id' => $productCategoryId,
						'company_id' => $companyId,
						'price' => $productPrice,
						'created_at' => $nowTime,
						'updated_at' => $nowTime,
					);

					$this->db->insert('products', $data);
				}	
	
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

	public function deleteProduct()
	{
		try{
			if ($this->session->userdata('roleId') === '777') {
				
				$companyId = $this->session->userdata('companyId');
				$productId = htmlspecialchars($this->input->post('productId'));
				
				$data = array(
					'productId' => $productId,
				);
				
				$this->db->query("DELETE FROM products WHERE id = '$productId' AND company_id = '$companyId'");
	
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
}