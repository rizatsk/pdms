<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->helper('url');

		// Get date tanggal minggu pertama dan terakhir
		$dateTime = new DateTime('now');
		$monday = clone $dateTime->modify('Monday this week');
		$sunday = clone $dateTime->modify('Sunday this week');
		$this->_firstWeek = $monday->format('Y-m-d');
		$this->_endWeek = $sunday->format('Y-m-d');

		// Get Date Month Start and End.
		$thisDay = date("Y-m-d");
		$this->_dateFirstMonth = date('Y-m-01', strtotime($thisDay));
		$this->_dateLateMonth = date('Y-m-t', strtotime($thisDay));

		// Get Date Year Start and End. 
		$this->_dateFirstYear = date('Y-01-01', strtotime($thisDay));
		$this->_dateLateYear = date('Y-12-31', strtotime($thisDay));
	}
	
	public function index()
	{
		$data['title'] = 'Dashboard';
		$data['page'] = 'Dashboard';
		$data['userId'] = $this->session->userdata('userId');
		$data['username'] = $this->session->userdata('username');
		$data['email'] = $this->session->userdata('email');
		$data['roleId'] = $this->session->userdata('roleId');
		$data['companyId'] = $this->session->userdata('companyId');
		$data['companyName'] = $this->session->userdata('companyName');

		if ($data['userId'] == null) {
			redirect('authentication');
		}
			
		$this->template->load("template/v_template", "v_dashboard", $data);
	}

	public function getData()
	{
		if ($this->session->userdata('roleId') === '777' || $this->session->userdata('roleId') === '775') {
			setlocale(LC_TIME, 'id_ID.utf8');
			$data['userId'] = $this->session->userdata('userId');
			$data['username'] = $this->session->userdata('username');
			$data['email'] = $this->session->userdata('email');
			$data['roleId'] = $this->session->userdata('roleId');
			$data['companyId'] = $this->session->userdata('companyId');
			$data['companyName'] = $this->session->userdata('companyName');
			$thisDay = new DateTime();
			$data['thisDay'] = strftime('%A %d %B %Y', $thisDay->getTimestamp());
			
			if ($data['userId'] == null) {
				echo json_encode(array('responseCode' => 400, "reponseMessage" => "validation", "data" => 'Silahkan melakukan authentications terlebih dahulu'));
				exit;
			}
		
			echo json_encode(array('responseCode' => 200, "reponseMessage" => "validation", "data" => $data));
			exit;
		} else {
			echo json_encode(array('responseCode' => 400, "reponseMessage" => "validation", "data" => 'Anda tidah berhak mengakses data ini'));
			exit;
		}
	}

	public function getDataForDashboard()
	{
		try{
			if ($this->session->userdata('roleId') === '777' || $this->session->userdata('roleId') === '775') {
				$companyId = $this->session->userdata('companyId');

				// PerDate
				$query = $this->db->query("SELECT date, 
					SUM(total_income) AS total
					FROM incomes
					WHERE company_id = '$companyId'
					GROUP BY date
					ORDER BY date DESC
					LIMIT 1");

				$dataIncomePerDate = $query->row();

				$dataExpenditurePerDate = $this->db->query("SELECT date, 
					SUM(total_expenditure) AS total
					FROM expenditures
					WHERE company_id = '$companyId'
					GROUP BY date
					ORDER BY date DESC
					LIMIT 1")->row();

				// Per Week
				$dataIncomePerWeek = $this->db->query("SELECT
					SUM(total) AS total FROM(
					SELECT date, 
					SUM(total_income) AS total
					FROM incomes 
					WHERE company_id = '$companyId'
					AND date BETWEEN '$this->_firstWeek' AND '$this->_endWeek'
					GROUP BY date
					ORDER BY date DESC) AS income_per_week")->row();

				$dataExpenditurePerWeek = $this->db->query("SELECT
					SUM(total) AS total FROM(
					SELECT date, 
					SUM(total_expenditure) AS total
					FROM expenditures
					WHERE company_id = '$companyId'
					AND date BETWEEN '$this->_firstWeek' AND '$this->_endWeek'
					GROUP BY date
					ORDER BY date DESC) AS expenditure_per_week")->row();

				// Per Month
				$dataIncomePerMonth = $this->db->query("SELECT
					SUM(total) AS total FROM(
					SELECT date, 
					SUM(total_income) AS total
					FROM incomes 
					WHERE company_id = '$companyId'
					AND date BETWEEN '$this->_dateFirstMonth' AND '$this->_dateLateMonth'
					GROUP BY date
					ORDER BY date DESC) AS income_per_month")->row();

				$dataExpenditurePerMonth = $this->db->query("SELECT
					SUM(total) AS total FROM(
					SELECT date, 
					SUM(total_expenditure) AS total
					FROM expenditures
					WHERE company_id = '$companyId'
					AND date BETWEEN '$this->_dateFirstMonth' AND '$this->_dateLateMonth'
					GROUP BY date
					ORDER BY date DESC) AS expenditure_per_month")->row();

				// Per Year
				$dataIncomePerYear = $this->db->query("SELECT
					SUM(total) AS total FROM(
					SELECT date, 
					SUM(total_income) AS total
					FROM incomes 
					WHERE company_id = '$companyId'
					AND date BETWEEN '$this->_dateFirstYear' AND '$this->_dateLateYear'
					GROUP BY date
					ORDER BY date DESC) AS income_per_year")->row();

				$dataExpenditurePerYear = $this->db->query("SELECT
					SUM(total) AS total FROM(
					SELECT date, 
					SUM(total_expenditure) AS total
					FROM expenditures
					WHERE company_id = '$companyId'
					AND date BETWEEN '$this->_dateFirstYear' AND '$this->_dateLateYear'
					GROUP BY date
					ORDER BY date DESC) AS income_per_week")->row();

				$data = array(
					"dataIncomePerDate" => $dataIncomePerDate,
					"dataIncomePerWeek" => $dataIncomePerWeek,
					"dataIncomePerMonth" => $dataIncomePerMonth,
					"dataIncomePerYear" => $dataIncomePerYear,

					"dataExpenditurePerDate" => $dataExpenditurePerDate,
					"dataExpenditurePerWeek" => $dataExpenditurePerWeek,
					"dataExpenditurePerMonth" => $dataExpenditurePerMonth,
					"dataExpenditurePerYear" => $dataExpenditurePerYear
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

	public function getIncomeOrExpenditurePerWeek()
	{
		try{
			if ($this->session->userdata('roleId') === '777' || $this->session->userdata('roleId') === '775') {
				$companyId = $this->session->userdata('companyId');
				$dateStart = $this->input->post('dateStart');
				$dateEnd = $this->input->post('dateEnd');

				$dateTime = new DateTime('now');
				$monday = clone $dateTime->modify('Monday this week');
				// $monday = clone $dateTime->modify(('Sunday' == $dateTime->format('l')) ? 'Monday last week' : 'Monday this week');
				$sunday = clone $dateTime->modify('Sunday this week');

				$firstWeek = $monday->format('Y-m-d');
				$endWeek = $sunday->format('Y-m-d');
				
				// $where = "AND date > getDateEndIncome() - INTERVAL '7' DAY";

				$where = "AND date BETWEEN '$firstWeek' AND '$endWeek'";
				if (isset($dateStart)) {
					$where = "AND date BETWEEN '$dateStart' AND '$dateEnd'";
				}

				$query = $this->db->query("SELECT
				SUM(total) AS total FROM(
				SELECT date, 
				SUM(total_income) AS total
				FROM incomes 
				WHERE company_id = '$companyId'
				$where
				GROUP BY date
				ORDER BY date DESC) AS income_per_week");

				$data = $query->row();

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

	public function getIncomePerMonth()
	{
		try{
			if ($this->session->userdata('roleId') === '777' || $this->session->userdata('roleId') === '775') {
				$companyId = $this->session->userdata('companyId');
				$dateStart = $this->input->post('dateStart');
				$dateEnd = $this->input->post('dateEnd');
				
				$thisDay = date("Y-m-d");
				$dateFirstMonth = date('Y-m-01', strtotime($thisDay));
				$dateLateMonth = date('Y-m-t', strtotime($thisDay));

				// $where = "AND date > getDateEndIncome() - INTERVAL '1' MONTH";

				$where = "AND date BETWEEN '$dateFirstMonth' AND '$dateLateMonth'";

				if (isset($dateStart)) {
					$where = "AND date BETWEEN '$dateStart' AND '$dateEnd'";
				}

				$query = $this->db->query("SELECT
				SUM(total) AS total FROM(
				SELECT date, 
				SUM(total_income) AS total
				FROM incomes 
				WHERE company_id = '$companyId'
				$where
				GROUP BY date
				ORDER BY date DESC) AS income_per_week");

				$data = $query->row();

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

	public function getIncomePerYear()
	{
		try{
			if ($this->session->userdata('roleId') === '777' || $this->session->userdata('roleId') === '775') {
				$companyId = $this->session->userdata('companyId');
				$dateStart = $this->input->post('dateStart');
				$dateEnd = $this->input->post('dateEnd');
				
				$thisDay = date("Y-m-d");
				$dateFirstYear = date('Y-01-01', strtotime($thisDay));
				$dateLateYear = date('Y-12-31', strtotime($thisDay));

				// $where = "AND date > getDateEndIncome() - INTERVAL '1' MONTH";

				$where = "AND date BETWEEN '$dateFirstYear' AND '$dateLateYear'";

				if (isset($dateStart)) {
					$where = "AND date BETWEEN '$dateStart' AND '$dateEnd'";
				}

				$query = $this->db->query("SELECT
				SUM(total) AS total FROM(
				SELECT date, 
				SUM(total_income) AS total
				FROM incomes 
				WHERE company_id = '$companyId'
				$where
				GROUP BY date
				ORDER BY date DESC) AS income_per_week");

				$data = $query->row();

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
