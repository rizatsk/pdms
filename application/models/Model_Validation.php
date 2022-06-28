<?php

class Model_Validation extends CI_Model
{
    public function validationRegister()
    {
        $this->form_validation->set_rules('name', 'Nama', 'required|min_length[3]|max_length[60]');
        $this->form_validation->set_rules('username', 'Username', 'is_unique[users.username]|trim|required|min_length[3]|max_length[20]');
        $this->form_validation->set_rules('email', 'Email', 'is_unique[users.email]|required|valid_email|max_length[60]');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|max_length[60]|min_length[6]');
        $this->form_validation->set_rules('re-password', 'Konfirmasi Password', 'trim|required|matches[password]');
    }

    public function validationLogin()
    {
        $this->form_validation->set_rules('user', 'Kolom', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');
    }

    public function validationAddShop()
    {
        $this->form_validation->set_rules('name', 'Nama', 'trim|required|min_length[3]|max_length[50]');
        $this->form_validation->set_rules('location', 'Location', 'trim|required|min_length[3]|max_length[50]');
    }

    public function validationRegisterAdmin()
    {
        $this->form_validation->set_rules('name', 'Nama', 'required|min_length[3]|max_length[60]');
        $this->form_validation->set_rules('username', 'Username', 'is_unique[users.username]|trim|required|min_length[3]|max_length[20]');
        $this->form_validation->set_rules('email', 'Email', 'is_unique[users.email]|required|valid_email|max_length[60]');
        // $this->form_validation->set_rules('adminToko', 'Admin Toko', 'required|max_length[50]');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|max_length[60]|min_length[6]');
        $this->form_validation->set_rules('re-password', 'Konfirmasi Password', 'trim|required|matches[password]');
    }

    public function validationChangePassword()
    {
        $this->form_validation->set_rules('ownerPassword', 'Password Owner', 'trim|required|max_length[60]|min_length[6]');
        $this->form_validation->set_rules('passwordNew', 'Password Baru', 'trim|required|max_length[60]|min_length[6]');
        $this->form_validation->set_rules('rePasswordNew', 'Konfirmasi Password Baru', 'trim|required|matches[passwordNew]');
    }

    public function validationUpdateProfileCeo()
    {
        $this->form_validation->set_rules('fullname', 'Nama Lengkap', 'trim|required|max_length[60]|min_length[6]');
    }

    public function validationChangePasswordCeo()
    {
        $this->form_validation->set_rules('password', 'Password Baru', 'trim|required|max_length[60]|min_length[6]');
        $this->form_validation->set_rules('pre-password', 'Konfirmasi Password Baru', 'trim|required|matches[password]');
    }

    public function validationUpdateCompanyName()
    {
        $this->form_validation->set_rules('companyName', 'Nama Usaha', 'trim|required|min_length[3]|max_length[60]');
    }

    public function validationCategory()
    {
        $this->form_validation->set_rules('categoryName', 'Nama Kategori', 'is_unique[categories.name]|trim|required|min_length[3]|max_length[60]');
    }

    public function validationProduct()
    {
        $this->form_validation->set_rules('productName', 'Nama Produk', 'is_unique[products.name]|trim|required|min_length[3]|max_length[60]');
        $this->form_validation->set_rules('productPrice', 'Harga Produk', 'trim|required|min_length[3]|max_length[60]|numeric');
    }

    public function validationInsertDate()
    {
        $this->form_validation->set_rules('shopId', 'Id Toko', 'trim|required|min_length[3]|max_length[60]');
        $this->form_validation->set_rules('input-date', 'Tanggal', 'trim|required|min_length[3]|max_length[60]');
    }

    public function validationInsertIncome()
    {
        $this->form_validation->set_rules('productId', 'Produk', 'trim|required|min_length[3]|max_length[10]');
        $this->form_validation->set_rules('manyProduct', 'Banyak Produk', 'trim|required|integer');
    }

    public function validationEditIncome()
    {
        $this->form_validation->set_rules('editManyProduct', 'Banyak Produk', 'trim|required|integer');
    }

    public function validationInsertExpenditure()
    {
        $this->form_validation->set_rules('productNameExpenditure', 'Produk', 'trim|required|min_length[3]|max_length[60]');
        $this->form_validation->set_rules('manyProductExpenditure', 'Banyak Produk', 'trim|required|integer');
        $this->form_validation->set_rules('productPriceExpenditure', 'Harga Produk', 'trim|required|integer');
    }
}