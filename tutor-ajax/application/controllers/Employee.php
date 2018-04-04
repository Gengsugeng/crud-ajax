<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employee extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		//Do your magic here
		$this->load->model('employee_m','m');
	}

	public function index()
	{
		$this->load->view('employee/index');
	}

	public function showAllEmployee()
	{
		$result = $this->m->showAllEmployee();
		echo json_encode($result);
	}

	public function addEmployee(){
		$result = $this->m->addEmployee();
		$msg['success'] = false;
		$msg['type'] = 'add';
		if ($result) {
			$msg['success'] = true;
		}
		echo json_encode($msg);
	}

	public function editEmployee()
	{
		$result = $this->m->editEmployee();
		echo json_encode($result);
	}

	public function updateEmployee()
	{
		$result = $this->m->updateEmployee();
		$msg['success'] = false;
		$msg['type'] = 'update';
		if ($result) {
			$msg['success'] = true;
		}
		echo json_encode($msg);
	}

	public function deleteEmployee(){
		$result = $this->m->deleteEmployee();
		$msg['success'] = false;
		if($result){
			$msg['success'] = true;
		}
		echo json_encode($msg);
	}

}

/* End of file Employee.php */
/* Location: ./application/controllers/Employee.php */