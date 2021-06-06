<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api_model extends CI_model {

    function fetchAll () {
        $this->db->order_by('first_name');
        $data = $this->db->get('employees');
        return $data;
    }

    function getUserById($user_id) {
        $this->db->select('*');
        $this->db->from('employees');
        $this->db->where('id', $user_id );
        $query = $this->db->get();
        if ( $query->num_rows() > 0 ) {
            $row = $query->row_array();
            return $row;
        }
    }

    function addUser($formData) {
        $this->db->insert("employees", $formData);
        $employee_id = $this->db->insert_id();
        return  $employee_id;
    }

    function updateUser($formData) {
        extract($formData);
        $data = array(
            'first_name' => $first_name,
            'last_name' => $last_name,
            'email' => $email,
            'status' => $status
        );
        $this->db->where('id', $id);
        $this->db->update("employees", $data);
        return true;
    }

    function deleteUser($formData) {
        extract($formData);
        $this->db->where('id', $id);
        $this->db->update("employees", array('status' => $status));
        return true;
    }

    function addTransaction($formData) {
        $this->db->insert("transaction", $formData);
        $employee_id = $this->db->insert_id();
        return  $employee_id;
    }

}
	