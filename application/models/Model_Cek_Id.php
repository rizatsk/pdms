<?php

class Model_Cek_Id extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }

    public function cekIdUsers()
    {
        $query = $this->db->query("SELECT MAX(id) as idUsers FROM users");
        $result = $query->row();
        return $result->idusers;
    }

    public function cekIdShop()
    {
        $query = $this->db->query("SELECT MAX(id) as idShop FROM shops");
        $result = $query->row();
        return $result->idshop;
    }

    public function cekIdCategory()
    {
        $query = $this->db->query("SELECT MAX(id) as idCategory FROM categories");
        $result = $query->row();
        return $result->idcategory;
    }

    public function cekIdProduct()
    {
        $query = $this->db->query("SELECT MAX(id) as idProduct FROM products");
        $result = $query->row();
        return $result->idproduct;
    }

    public function cekIdIncomes()
    {
        $query = $this->db->query("SELECT MAX(id) as idIncomes FROM incomes");
        $result = $query->row();
        return $result->idincomes;
    }
    
    public function cekIdExpenditure()
    {
        $query = $this->db->query("SELECT MAX(id) as idExpenditure FROM expenditures");
        $result = $query->row();
        return $result->idexpenditure;
    }
}