<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * Author: Davinder Singh Chahal <imdschahal@gmail.com>
 * Date: December 2023
 * Class: User
 * Description: User interface for login, logout and signup
 */
class User extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
        $this->load->model('common_model');
    }

    function index()
    {
        $this->login();
    }

    function login()
    {
        is_already_logged_in();
        $data['error'] = "";

        $this->form_validation->set_rules('email', 'Email', 'trim|required');
        $this->form_validation->set_rules('pwd', 'Password', 'trim|required');

        if ($this->form_validation->run() == false) {
            $this->load->view('login', $data);
        } else {
            $usr = $this->input->post('email');
            $pwd = md5($this->input->post('pwd'));
            $result = $this->user_model->validate_login($usr, $pwd);

            if (!empty($result)) {
                $domain_valid = '';
                $cookie_secure = true;

                delete_cookie('jiRfwHZKndflXtJg_testmodule');
                delete_cookie('khODdyHjmJgkxra9_testmodule');

                $result = reset($result);

                $encodeResult = json_encode($result);

                $cookie = array(
                    'name'   => 'jiRfwHZKndflXtJg_testmodule',
                    'value'  => aes_encrypt($encodeResult),
                    'expire' => '86400', //one day expiry
                    'domain' => $domain_valid,
                    'secure' => $cookie_secure
                );
                $this->input->set_cookie($cookie);

                $token = rand(1000000000, 9999999999);
                $ip_address = user_ip();
                $user_id = (int)$result['user_id'];
                $user_token_id = (int)$result['user_token_id'];

                $cookie = array(
                    'name'   => 'khODdyHjmJgkxra9_testmodule',
                    'value'  => aes_encrypt($token . '~' . $ip_address),
                    'expire' => '86400', //one day expiry
                    'domain' => $domain_valid,
                    'secure' => $cookie_secure
                );
                $this->input->set_cookie($cookie);

                $data = array(
                    'user_id' => $user_id,
                    'token' => $token,
                    'ip_address' => $ip_address,
                    'created_date' => date('Y-m-d H:i:s')
                );

                $table = 'user_token';
                if ($user_token_id > 0) {
                    $result = $this->common_model->update($user_token_id, $data, 'user_token_id', $table);
                } else {
                    $result = $this->common_model->insert($data, $table);
                }
                redirect('test', 'refresh');
            } else {
                $this->session->set_userdata('form-fail', 'Invalid login details');
                redirect('user/login');
            }
        }
    }


    function logout()
    {
        delete_cookie('jiRfwHZKndflXtJg_testmodule');
        delete_cookie('khODdyHjmJgkxra9_testmodule');
        redirect('user/login', 'refresh');
    }

    function sign_up()
    {
        $data['error'] = "";

        $this->form_validation->set_rules('full_name', 'Full Name', 'trim|required|alpha_numeric_spaces|max_length[100]');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|max_length[100]|is_unique[user.email]');
        $this->form_validation->set_rules('mobile', 'Mobile', 'trim|required|integer|exact_length[10]|is_unique[user.mobile]');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[8]');
        $this->form_validation->set_rules('confirm_password', 'Retype Password', 'trim|required|min_length[8]|matches[password]');

        if ($this->form_validation->run() == false) {
            $this->load->view('sign_up', $data);
        } else {
            $full_name = $this->input->post('full_name');
            $email = $this->input->post('email');
            $mobile = $this->input->post('mobile');
            $password = md5($this->input->post('password'));

            $data = array(
                'name' => $full_name,
                'mobile' => $mobile,
                'email' => $email,
                'password' => $password,
                'user_role_id' => 2,
                'is_active' => 1,
            );
            $table = 'user';
            $result = $this->common_model->insert($data, $table);
            if ((int)$result > 0) {
                $this->session->set_userdata('form-success', 'You Have Been Successfully Register.');
            } else {
                $this->session->set_userdata('form-fail', 'Something Went Wrong! Please Try Again');
            }
            redirect('user/login');
        }
    }
}
