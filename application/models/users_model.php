<?php
require_once('MY_base_model.php');
class Users_model extends MY_base_model
{

    public function __construct()
    {
        parent::__construct('users');
    }

    public function get_auth_user($login, $password)
    {
        $this->db->where('username', $login);
        $this->db->where('password', md5($password));
        return $this->db->get($this->table)->row_array();
    }

    public function update_password($id, $password)
    {
        $this->db->where('id', $id);
        $this->db->set('password', md5($password));
        return $this->db->update($this->table);
    }
}