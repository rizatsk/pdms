<?php

class Model_MaximumCreate extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }

    public function maxsimumCreate($table, $where)
    {
        try {
            $query = $this->db->query("SELECT * FROM $table WHERE $where")->num_rows();
            return $query;
        } catch (Exception $error) {
            return $error;
        }

    }
}