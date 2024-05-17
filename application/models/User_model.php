<?php
class User_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function validate_login($usr, $pass)
    {
        $this->db->where('ur.email', $usr);
        $this->db->where('ur.password', $pass);
        $this->db->where('ur.is_active', 1);
        $this->db->select('ur.user_id,ur.name,ur.email,ur.user_role_id,ut.user_token_id');
        $this->db->from('user as ur');
        $this->db->join("user_token as ut", "ut.user_id = ur.user_id", "left");
        $this->db->limit(1);
        $result = $this->db->get();
        return $result->result_array();
    }

    function check_valid_cookie($user_id, $user_email)
    {
        $this->db->where('user_id', $user_id);
        $this->db->where('email', $user_email);
        $this->db->where('is_active', 1);
        $this->db->select('user_id');
        $this->db->limit(1);
        $result = $this->db->get('user');
        return $result->result_array();
    }
}
