<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api_model extends CI_model {

    function fetchAll ($status) {
    //    die($status);
        $this->db->select('*');
        $this->db->from('todo');
        if($status !== NULL) {
            $this->db->where('status', $status );
        }
        $this->db->order_by('short_desc', 'ASC');
        $data = $this->db->get();
        return $data;
    }

    function getTodoById($todo_id) {
        $this->db->select('*');
        $this->db->from('todo');
        $this->db->where('id', $todo_id );
        $query = $this->db->get();
        if ( $query->num_rows() > 0 ) {
            $row = $query->row_array();
            return $row;
        } else {
            return 0;
        }
    }

    function addTodo($formData) {
        $this->db->insert("todo", $formData);
        $todo_id = $this->db->insert_id();
        return  $todo_id;
    }

    function updateTodo($formData) {
        extract($formData);
        $data = array(
            'name' => $name,
            'short_desc' => $short_desc,
            'long_desc' => $long_desc
        );
        $this->db->where('id', $id);
        $this->db->update("todo", $data);
        return true;
    }

    function completeTodo($todo_id) {
        $data = array(
            'status' => 2
        );
        $this->db->where('id', $todo_id);
        $this->db->update("todo", $data);
        return true;
    }

    function deleteTodo($todo_id) {
        $this->db->where('id', $todo_id);
        $this->db->update("todo", array('status' => 0));
        return true;
    }

}
	