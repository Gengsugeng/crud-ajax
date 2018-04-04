<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employee_m extends CI_Model {

	public function showAllEmployee()
	{
		$this->db->order_by('created_at', 'desc');
		$query = $this->db->get('tbl_employee');
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function addEmployee(){
		$field = array(
				'employee_name' => $this->input->post('textEmployeeName'),
				'address' => $this->input->post('textAddress'),
				'created_at' => date('Y-m-d H:i:s')
				);
		$this->db->insert('tbl_employee', $field);
		if ($this->db->affected_rows()>0) {
			return true;
		} else {
			return false;
		}
	}

	public function editEmployee()
	{
		$id = $this->input->get('id_employee');
		$this->db->where('id_employee', $id);
		$query = $this->db->get('tbl_employee');
		if ($query->num_rows()>0) {
			return $query->row();
		} else {
			return false;
		}
	}

	public function updateEmployee()
	{
		$id = $this->input->post('textId');
		$field = array(
				'employee_name' => $this->input->post('textEmployeeName'),
				'address' => $this->input->post('textAddress'),
				'update_at' => date('Y-m-d H:i:s')
				);
		$this->db->where('id_employee', $id);
		$this->db->update('tbl_employee', $field);

		if ($this->db->affected_rows()>0) {
			return true;
		} else {
			return false;
		}
	}

	public function deleteEmployee(){
		$id = $this->input->get('id_employee');
		$this->db->where('id_employee', $id);
		$this->db->delete('tbl_employee');

		if ($this->db->affected_rows()>0) {
			return true;
		}else {
			return false;
		}
	}

}

/* End of file Employee_m.php */
/* Location: ./application/models/Employee_m.php */