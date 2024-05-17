<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/** 
 * Function: cookie_user_data
 * Description: Get logged in user data from cookie
 */
function cookie_user_data()
{
    $CI = &get_instance();
    $userData =  $CI->input->cookie('jiRfwHZKndflXtJg_testmodule', true);
    $returnData = array();
    if ($userData) {
        $userData = aes_decrypt($userData);
        $returnData = json_decode($userData, true);
    }
    return $returnData;
}

/** 
 * Function: is_logged_in
 * Description: Check if the user is logged in for the application access.
 */
function is_logged_in()
{
    $CI = &get_instance();
    $CI->load->model('common_model');

    $valid = 0;
    $userData = cookie_user_data();
    $user_id = (isset($userData['user_id'])) ? (int)$userData['user_id'] : 0;
    $user_email = (isset($userData['email'])) ? $userData['email'] : '';
    $user_name = (isset($userData['name'])) ? $userData['name'] : '';

    $token_data =  $CI->input->cookie('khODdyHjmJgkxra9_testmodule', true);

    if ($user_id > 0 && $user_email != '' && $user_name != '' && $token_data != '') {
        $saved_token_data = $CI->common_model->getRecordData('user_token', "user_id = $user_id");
        if (!empty($saved_token_data)) {
            $saved_token = $saved_token_data[0]['token'];
            $saved_ip = $saved_token_data[0]['ip_address'];
            $token_data = aes_decrypt($token_data);
            $explose = explode('~', $token_data);
            if (isset($explose[0]) && isset($explose[1])) {
                $token = $explose[0];
                $ip_address = $explose[1];
                if ($saved_token == $token && $saved_ip == $ip_address) {
                    $valid = 1;
                }
            }
        }
    }

    if ($valid == 1) {
        return true;
    } else {
        redirect('user/logout', 'refresh');
    }
}

/** 
 * Function: is_already_logged_in
 * Description: Check if the user is logged in for the login process.
 */
function is_already_logged_in()
{
    $CI = &get_instance();
    $CI->load->model('user_model');
    $valid = 0;
    $userData = cookie_user_data();
    $user_id = (isset($userData['user_id'])) ? (int)$userData['user_id'] : 0;
    $user_email = (isset($userData['email'])) ? $userData['email'] : '';
    $user_name = (isset($userData['name'])) ? $userData['name'] : '';

    if ($user_id > 0 && $user_email != '' && $user_name != '') {
        $dtt = $CI->user_model->check_valid_cookie($user_id, $user_email);
        if (!empty($dtt)) {
            $valid = 1;
        }
    }

    if ($valid == 1) {
        redirect('test', 'refresh');
    } else {
        return true;
    }
}

/** 
 * Function: get_user_id, get_user_name, get_user_email, get_user_role
 * Description: Return the user related data from the cookie data.
 */

function get_user_id()
{
    $userData = cookie_user_data();
    $user_id = (isset($userData['user_id'])) ? (int)$userData['user_id'] : 0;
    return $user_id;
}

function get_user_name()
{
    $userData = cookie_user_data();
    $user_name = (isset($userData['name'])) ? $userData['name'] : '';
    return $user_name;
}

function get_user_email()
{
    $userData = cookie_user_data();
    $user_email = (isset($userData['email'])) ? $userData['email'] : '';
    return $user_email;
}

function get_user_role()
{
    $userData = cookie_user_data();
    $user_role_id = (isset($userData['user_role_id'])) ? (int)$userData['user_role_id'] : 0;
    return $user_role_id;
}

/** 
 * Function: check_is_admin
 * Description: Check the logged in user is a admin to limit the user permissions
 */

function check_is_admin()
{
    if (get_user_role() == 1) {
        return true;
    } else {
        redirect('test', 'refresh');
    }
}

function user_ip()
{
    $CI = &get_instance();
    return $CI->input->ip_address();        //return ip.
}
