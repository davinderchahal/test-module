<?php
class Test_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function get_all_with_paging($limit, $offset)
    {
        $this->db->limit($limit, $offset);
        $query = $this->db->get('user_test');
        return $query->result_array();
    }

    function get_totle_for_paging()
    {
        $this->db->select('test_id');
        $this->db->from('user_test');
        $query = $this->db->get();
        return $query->num_rows();
    }

    function get_test_by_id($test_id, $date = '', $is_published = '')
    {
        if ($test_id > 0) {
            $this->db->where('user_test.test_id', $test_id);
        }
        if ($date != '') {
            $this->db->where('DATE(user_test.test_date)', $date);
        }
        if ((int)$is_published == 1) {
            $this->db->where('user_test.is_published', 1);
        }
        $this->db->select('user_test.*,utq.*');
        $this->db->from('user_test');
        $this->db->join('user_test_questions as utq', 'utq.test_id = user_test.test_id');
        $query = $this->db->get();
        return $query->result_array();
    }
}
