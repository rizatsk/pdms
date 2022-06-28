<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Shop_sales extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('Model_Validation');
		$this->load->model('Model_Cek_Id');
		$this->load->model('Model_Id');
	}

	public function index($id)
	{
		$data['title'] = "Management Toko";
        $data['idShop'] = $id;
		$data['userId'] = $this->session->userdata('userId');
		$data['username'] = $this->session->userdata('username');
		$data['email'] = $this->session->userdata('email');
		$data['roleId'] = $this->session->userdata('roleId');
		$data['companyId'] = $this->session->userdata('companyId');
		$data['companyName'] = $this->session->userdata('companyName');
		$userId = $data['userId'];

		if ($data['userId'] == null) {
			redirect('authentication');
		}

		if ($data['roleId'] == 777) {
			$where = "";
		} elseif ($data['roleId'] == 775) {
			$where = "AND shops.admin_id = '$userId'";
		};

		$query = $this->db->query("SELECT DISTINCT shops.id, shops.name, shops.location, shops.admin_id, shops.company_id
								FROM shops JOIN users ON shops.company_id = users.company_id 
								WHERE shops.id = '$id' $where")->row_array();
		
		if ( $query['company_id'] == $data['companyId'] ) {
			$data['page'] = $query['name'];
			$data['nameShop'] = $query['name'];
			$data['locationShop'] = $query['location'];
			
			$this->template->load("template/v_template", "shops/v_shopSale", $data);
		} else {
			redirect('dashboard');
		}
	}

	public function insertDate()
	{
		try{
			if ($this->session->userdata('roleId') === '777' || $this->session->userdata('roleId') === '775') {
				$companyId = $this->session->userdata('companyId');
				$shopId = htmlspecialchars($this->input->post('shopId'));
				$date = trim(htmlspecialchars($this->input->post('input-date')));
				$typeDate = trim(htmlspecialchars($this->input->post('typeDate')));
				
				$this->Model_Validation->validationInsertDate();
				if ($this->form_validation->run() == FALSE) {
					$messageError = array(
						'errorDate' => form_error('input-date'),
					);
					echo json_encode(array('responseCode' => 400, "reponseMessage" => "validation", "data" => $messageError));
					exit;
				}

				$table = $typeDate == 'income' ? 'incomes' : 'expenditures';
				$query = $this->db->query("SELECT id FROM $table WHERE date = '$date' AND shop_id = '$shopId' AND company_id = '$companyId'");
				$data = $query->result();

				if(count($data) > 0) {
					$messageError = array(
						'errorDate' => 'Tanggal sudah pernah digunakan',
					);
					echo json_encode(array('responseCode' => 400, "reponseMessage" => "validation", "data" => $messageError));
					exit;
				} 

				$data = array(
					'date' => $date,
					'shopId' => $shopId,
					'typeDate' => $typeDate
				);

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

	public function loadTableIncome() 
	{
		try{
			if ($this->session->userdata('roleId') === '777' || $this->session->userdata('roleId') === '775') {
				$companyId = $this->session->userdata('companyId');
				$table = trim(htmlspecialchars($this->input->post('table')));
				$shopId = htmlspecialchars($this->input->post('shopId'));
				$date = trim(htmlspecialchars($this->input->post('inputDate')));

				if ($date != null) {
					$query = $this->db->query("SELECT 
						incomes.id AS id,
						incomes.date,
						incomes.id_product AS id_product,
						products.name AS product_name,
						products.price AS product_price,
						incomes.total_product AS total_product,
						incomes.total_income AS total
						FROM $table 
						JOIN products ON products.id = $table.id_product
						WHERE date = '$date' AND shop_id = '$shopId' AND incomes.company_id = '$companyId'");
				} else {
					$query = $this->db->query("SELECT date,
					SUM(total_income) AS total,
					shop_id
					FROM incomes 
					WHERE shop_id = '$shopId' 
					AND company_id = '$companyId'
					GROUP BY date, shop_id
					ORDER BY date;");
				}
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

	public function loadTableExpenditure() 
	{
		try{
			if ($this->session->userdata('roleId') === '777' || $this->session->userdata('roleId') === '775') {
				$companyId = $this->session->userdata('companyId');
				$table = trim(htmlspecialchars($this->input->post('table')));
				$shopId = htmlspecialchars($this->input->post('shopId'));
				$date = trim(htmlspecialchars($this->input->post('inputDate')));

				if ($date != null) {
					$query = $this->db->query("SELECT id,
						date,
						name AS product_name, 
						price AS product_price,
						total_product,
						total_expenditure AS total
						FROM expenditures
						WHERE date = '$date' AND shop_id = '$shopId' AND company_id = '$companyId'");
				} else {
					$query = $this->db->query("SELECT date,
					SUM(total_expenditure) AS total,
					shop_id
					FROM expenditures 
					WHERE shop_id = '$shopId' 
					AND company_id = '$companyId'
					GROUP BY date, shop_id
					ORDER BY date");
				}
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

	public function loadComboProducts() 
	{
		try{
			if ($this->session->userdata('roleId') === '777' || $this->session->userdata('roleId') === '775') {
				$companyId = $this->session->userdata('companyId');
				$categoryId = $this->input->post('categoryId');

				if ($categoryId != null) {
					if ($categoryId === "99") {
						$where = '';
					} else {
						$where = " AND category_id = '$categoryId'";
					} 
					
					$query = $this->db->query("SELECT * FROM products WHERE company_id = '$companyId' $where");
					$data = $query->result();
				} else {
					$data = null;
				}

				echo json_encode(array('responseCode' => 200, "responseMessage" => "success", "data" => $data));
				exit;
			} else {
				throw new Error(json_encode(array('responseMessage' => 'You are not entitled to access this feature')));
			}
		} catch(Exception $error) {
			echo json_encode(array('responseCode' => 500, 'responseMessage' => $error));
			exit;
		}
	}

	public function addOrEditIncome() 
	{
		try{
			if ($this->session->userdata('roleId') === '777' || $this->session->userdata('roleId') === '775') {
	
				$this->Model_Validation->validationInsertIncome();
				if ($this->form_validation->run() == FALSE) {
					$messageError = array(
						'errorProductId' => form_error('productId'),
						'errorManyProduct' => form_error('manyProduct'),
					);
					
					echo json_encode(array('responseCode' => 400,"responseMessage" => "validation", "data" => $messageError));
					exit;
				};

				$companyId = $this->session->userdata('companyId');
				$shopId = htmlspecialchars($this->input->post('idShop'));
				$inputDate = htmlspecialchars($this->input->post('inputDate'));
				$productId = htmlspecialchars($this->input->post('productId'));
				$manyProduct = htmlspecialchars($this->input->post('manyProduct'));

				$query = $this->db->query("SELECT id FROM incomes 
							WHERE id_product =  '$productId' AND date = '$inputDate' 
							AND company_id = '$companyId' AND shop_id = '$shopId'");
				$data = $query->result();

				if(count($data) > 0) {
					$messageError = array(
						'errorProductId' => 'Produk sudah ada pada tanggal ini. silahkan diedit',
					);
					echo json_encode(array('responseCode' => 400, "reponseMessage" => "validation", "data" => $messageError));
					exit;
				} 
				
				$maxId = $this->Model_Cek_Id->cekIdIncomes();
				$id = $this->Model_Id->IdManagement('IC', $maxId);
				$total_income = $this->db->query("SELECT total_income( 
								(SELECT price FROM products 
								WHERE company_id = '$companyId' 
								AND id = '$productId'), $manyProduct) AS total_income")->row()->total_income;

				$data = array(
					'id' => $id,
					'date' => $inputDate,
					'id_product' => $productId,
					'total_product' => $manyProduct,
					'total_income' => $total_income,
					'shop_id' => $shopId,
					'company_id' => $companyId,
					'created_at' => date('Y-m-d H:i:s'),
					'updated_at' => date('Y-m-d H:i:s')
				);

				$this->db->insert('incomes', $data);

				if($this->db->affected_rows() < 0) {
					echo json_encode(array('responseCode' => 403, 'responseMessage' => 'Failed Save Incomes'));
					exit;
				} 

				echo json_encode(array('responseCode' => 200, "responseMessage" => "success", "data" => $data));
				exit;
			} else {
				throw new Error(json_encode(array('responseMessage' => 'You are not entitled to access this feature')));
			}
		} catch(Exception $error) {
			echo json_encode(array('responseCode' => 500, 'responseMessage' => $error));
			exit;
		}
	}

	public function addExpenditure() 
	{
		try {
			if ($this->session->userdata('roleId') === '777' || $this->session->userdata('roleId') === '775') {
				$this->Model_Validation->validationInsertExpenditure();
				if ($this->form_validation->run() == FALSE) {
					$messageError = array(
						'errorProductName' => form_error('productNameExpenditure'),
						'errorManyProduct' => form_error('manyProductExpenditure'),
						'errorPriceExpenditure' => form_error('productPriceExpenditure'),
					);
					
					echo json_encode(array('responseCode' => 400,"responseMessage" => "validation", "data" => $messageError));
					exit;
				};

				$companyId = $this->session->userdata('companyId');
				$shopId = htmlspecialchars($this->input->post('idShop'));
				$inputDate = htmlspecialchars($this->input->post('inputDate'));
				$productName = htmlspecialchars($this->input->post('productNameExpenditure'));
				$priceProduct = htmlspecialchars($this->input->post('productPriceExpenditure'));
				$manyProduct = htmlspecialchars($this->input->post('manyProductExpenditure'));

				$query = $this->db->query("SELECT id FROM expenditures 
							WHERE name =  '$productName' AND date = '$inputDate' 
							AND company_id = '$companyId' AND shop_id = '$shopId'");
				$data = $query->result();

				if(count($data) > 0) {
					$messageError = array(
						'errorProductName' => 'Produk sudah ada pada tanggal ini. silahkan diedit',
					);
					echo json_encode(array('responseCode' => 400, "reponseMessage" => "validation", "data" => $messageError));
					exit;
				} 
				
				$maxId = $this->Model_Cek_Id->cekIdExpenditure();
				$id = $this->Model_Id->IdManagement('EX', $maxId);
				$total_income = $this->db->query("SELECT total_income($priceProduct , $manyProduct) AS total_income")->row()->total_income;

				$data = array(
					'id' => $id,
					'date' => $inputDate,
					'name' => $productName,
					'price' => $priceProduct,
					'total_product' => $manyProduct,
					'total_expenditure' => $total_income,
					'shop_id' => $shopId,
					'company_id' => $companyId,
					'created_at' => date('Y-m-d H:i:s'),
					'updated_at' => date('Y-m-d H:i:s')
				);

				$this->db->insert('expenditures', $data);

				if($this->db->affected_rows() < 0) {
					echo json_encode(array('responseCode' => 403, 'responseMessage' => 'Failed Save Expenditure'));
					exit;
				} 

				echo json_encode(array('responseCode' => 200, "responseMessage" => "success", "data" => $data));
				exit;
			} else {
				throw new Error(json_encode(array('responseMessage' => 'You are not entitled to access this feature')));
			}
		} catch(Exception $error) {
			echo json_encode(array('responseCode' => 500, 'responseMessage' => $error));
			exit;
		}
	}

	public function deleteIncome()
	{
		try{
			if ($this->session->userdata('roleId') === '777' || $this->session->userdata('roleId') === '775') {
				$idIncome = $this->input->post('id');
	
				$this->db->query("DELETE FROM incomes WHERE id = '$idIncome'");
				
				if($this->db->affected_rows() < 0) {
					echo json_encode(array('responseCode' => 403, 'responseMessage' => 'Failed Delete Incomes'));
					exit;
				} 

				echo json_encode(array('responseCode' => 200, "responseMessage" => "success", "data" => $idIncome));
				exit;
			} else {
				throw new Error(json_encode(array('responseMessage' => 'You are not entitled to access this feature')));
			}
		} catch(Exception $error) {
			echo json_encode(array('responseCode' => 500, 'responseMessage' => $error));
			exit;
		}
	}

	public function deleteExpenditure()
	{
		try{
			if ($this->session->userdata('roleId') === '777' || $this->session->userdata('roleId') === '775') {
				$idIncome = $this->input->post('id');
	
				$this->db->query("DELETE FROM expenditures WHERE id = '$idIncome'");
				
				if($this->db->affected_rows() < 0) {
					echo json_encode(array('responseCode' => 403, 'responseMessage' => 'Failed Delete Expenditures'));
					exit;
				} 

				echo json_encode(array('responseCode' => 200, "responseMessage" => "success", "data" => $idIncome));
				exit;
			} else {
				throw new Error(json_encode(array('responseMessage' => 'You are not entitled to access this feature')));
			}
		} catch(Exception $error) {
			echo json_encode(array('responseCode' => 500, 'responseMessage' => $error));
			exit;
		}
	}

	public function getIncomeById($id) 
	{
		try{
			if ($this->session->userdata('roleId') === '777' || $this->session->userdata('roleId') === '775') {
	
				$query = $this->db->query("SELECT incomes.id, incomes.total_product, 
									products.id AS product_id,
									products.name AS product_name 
									FROM incomes 
									JOIN products ON products.id = incomes.id_product
									WHERE incomes.id = '$id'");
				$data = $query->row();

				echo json_encode(array('responseCode' => 200, "responseMessage" => "success", "data" => $data));
				exit;
			} else {
				throw new Error(json_encode(array('responseMessage' => 'You are not entitled to access this feature')));
			}
		} catch(Exception $error) {
			echo json_encode(array('responseCode' => 500, 'responseMessage' => $error));
			exit;
		}
	}

	public function getExpenditureById($id) 
	{
		try{
			if ($this->session->userdata('roleId') === '777' || $this->session->userdata('roleId') === '775') {
	
				$query = $this->db->query("SELECT id,
									date, 
									name AS product_name,
									price AS product_price,
									total_product AS product_many 
									FROM expenditures
									WHERE id = '$id'");
				$data = $query->row();

				echo json_encode(array('responseCode' => 200, "responseMessage" => "success", "data" => $data));
				exit;
			} else {
				throw new Error(json_encode(array('responseMessage' => 'You are not entitled to access this feature')));
			}
		} catch(Exception $error) {
			echo json_encode(array('responseCode' => 500, 'responseMessage' => $error));
			exit;
		}
	}

	public function editIncomeById()
	{
		try{
			if ($this->session->userdata('roleId') === '777' || $this->session->userdata('roleId') === '775') {
	
				$this->Model_Validation->validationEditIncome();
				if ($this->form_validation->run() == FALSE) {
					$messageError = array(
						'errorManyProduct' => form_error('editManyProduct'),
					);
					
					echo json_encode(array('responseCode' => 400,"responseMessage" => "validation", "data" => $messageError));
					exit;
				};

				$incomeId = htmlspecialchars($this->input->post('incomeId'));
				$productId = htmlspecialchars($this->input->post('productId'));
				$manyProduct = htmlspecialchars($this->input->post('editManyProduct'));
				$total_income = $this->db->query("SELECT total_income( 
					(SELECT price FROM products 
					WHERE id = '$productId'), $manyProduct) AS total_income")->row()->total_income;
				
				$data = array(
					'total_product' => $manyProduct,
					'total_income' => $total_income,
					'updated_at' => date('Y-m-d H:i:s'),
				);

				$this->db->set($data);
				$this->db->where('id', $incomeId);
				$this->db->update('incomes');

				if($this->db->affected_rows() < 0) {
					echo json_encode(array('responseCode' => 403, 'responseMessage' => 'Failed Save Shop'));
					exit;
				} 

				echo json_encode(array('responseCode' => 200, "responseMessage" => "success", "data" => $data));
				exit;
			} else {
				throw new Error(json_encode(array('responseMessage' => 'You are not entitled to access this feature')));
			}
		} catch(Exception $error) {
			echo json_encode(array('responseCode' => 500, 'responseMessage' => $error));
			exit;
		}
	}

	public function editExpenditureById()
	{
		try{
			if ($this->session->userdata('roleId') === '777' || $this->session->userdata('roleId') === '775') {
	
				$this->Model_Validation->validationEditIncome();
				if ($this->form_validation->run() == FALSE) {
					$messageError = array(
						'errorNameProduct' => form_error('editNameProduct'),
						'errorPriceProduct' => form_error('editPriceProduct'),
						'errorManyProduct' => form_error('editManyProduct'),
					);
					
					echo json_encode(array('responseCode' => 400,"responseMessage" => "validation", "data" => $messageError));
					exit;
				};

				$companyId = $this->session->userdata('companyId');
				$shopId = htmlspecialchars($this->input->post('idShop'));
				$expenditureId = htmlspecialchars($this->input->post('expenditureId'));
				$inputDate = htmlspecialchars($this->input->post('expenditureDate'));
				$productName = htmlspecialchars($this->input->post('editNameProduct'));
				$priceProduct = htmlspecialchars($this->input->post('editPriceProduct'));
				$manyProduct = htmlspecialchars($this->input->post('editManyProduct'));

				$query = $this->db->query("SELECT id FROM expenditures 
							WHERE name =  '$productName' AND date = '$inputDate' 
							AND company_id = '$companyId' AND shop_id = '$shopId'");
				$data = $query->result();

				if(count($data) > 1) {
					$messageError = array(
						'errorNameProduct' => 'Produk sudah ada pada tanggal ini. silahkan diedit',
					);
					echo json_encode(array('responseCode' => 400, "reponseMessage" => "validation", "data" => $messageError));
					exit;
				} 

				$manyProduct = htmlspecialchars($this->input->post('editManyProduct'));
				$total_expenditure = $this->db->query("SELECT total_income($priceProduct, $manyProduct) AS total_income")->row()->total_income;
				
				$data = array(
					'name' => $productName,
					'price' => $priceProduct,
					'total_product' => $manyProduct,
					'total_expenditure' => $total_expenditure,
					'updated_at' => date('Y-m-d H:i:s'),
				);

				$this->db->set($data);
				$this->db->where('id', $expenditureId);
				$this->db->update('expenditures');

				if($this->db->affected_rows() < 0) {
					echo json_encode(array('responseCode' => 403, 'responseMessage' => 'Failed Save Shop'));
					exit;
				} 

				echo json_encode(array('responseCode' => 200, "responseMessage" => "success", "data" => $data));
				exit;
			} else {
				throw new Error(json_encode(array('responseMessage' => 'You are not entitled to access this feature')));
			}
		} catch(Exception $error) {
			echo json_encode(array('responseCode' => 500, 'responseMessage' => $error));
			exit;
		}
	}
}