<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * Author: Davinder Singh Chahal <imdschahal@gmail.com>
 * Date: December 2023
 * Class: Test
 * Description: Test interface for creating, updating and deleting tests for admin. Normal user can attempt test. 
 */
class Test extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('test_model');
		$this->load->model('common_model');
		is_logged_in();
	}


	public function index()
	{
		$test_started = $this->session->userdata('userTestStarted');
		$current_date = date('Y-m-d');
		//Get current date published test 
		$test_data = $this->test_model->get_test_by_id('', $current_date, $is_published = 1);
		$test_attemted = 0;
		if (!empty($test_data)) {
			$test_id = (int)$test_data[0]['test_id'];
			$test_duration = (int)$test_data[0]['test_duration'];
			if (!empty($test_started)) {
				//If the test started check whether the test is still running or over.
				$test_end_time = date('Y-m-d H:i:s', strtotime(' +' . $test_duration . ' minutes ', strtotime($test_started)));
				$current_date_time = date('Y-m-d H:i:s');
				if (strtotime($current_date_time) > strtotime($test_end_time)) {
					$this->session->set_userdata('form-fail', 'Time has expired for this test');
					redirect('test/finish');
				}
			} else {
				//If the test is not running check whether the test has been attempted or not.
				$user_id = get_user_id();
				$check_test_result = $this->common_model->getRecordData('user_test_result', array('user_id' => $user_id, 'test_id' => $test_id));
				if (!empty($check_test_result)) {
					$test_attemted = 1;
				}
			}
		}
		$data['test_data'] = $test_data;
		$data['test_attemted'] = $test_attemted;
		$data['test_started'] = $test_started;
		$this->load->view('test/test', $data);
	}

	function start()
	{
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$test_started = $this->session->userdata('userTestStarted');
			if ($test_started == '') {
				$current_date_time = date('Y-m-d H:i:s');
				$this->session->set_userdata('userTestStarted', $current_date_time);
				echo 1;
			} else {
				echo 'You have been started test';
			}
		} else {
			echo 'Something Went Wrong.';
		}
	}

	function finish()
	{
		$this->session->unset_userdata('userTestStarted');
		redirect('test', 'refresh');
	}

	function save_option()
	{
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			if (isset($_POST['val'])) {
				$post_data = aes_decrypt($_POST['val']);
				$explode_data = explode('~', $post_data);
				if (count($explode_data) == 3) {
					$test_id = (int)$explode_data[0];
					$test_data = $this->common_model->getRecordData('user_test', array('test_id' => $test_id));
					if (!empty($test_data)) {
						$test_duration = (int)$test_data[0]['test_duration'];
						$test_started = $this->session->userdata('userTestStarted');
						if (!empty($test_started)) {
							//If the test started check whether the test is still running or over.
							$test_end_time = date('Y-m-d H:i:s', strtotime(' +' . $test_duration . ' minutes ', strtotime($test_started)));
							$current_date_time = date('Y-m-d H:i:s');
							if (strtotime($current_date_time) > strtotime($test_end_time)) {
								$this->session->set_userdata('form-fail', 'Time has expired for this test');
								echo 'redirect#~@' . site_url('test/finish');
								exit;
							}
						}
						$question_id = (int)$explode_data[1];
						$option = $explode_data[2];
						$user_id = get_user_id();
						$table = 'user_test_result';
						//Check the test result whether the answer of is saved or not
						$check_test_result = $this->common_model->getRecordData($table, array('user_id' => $user_id, 'question_id' => $question_id));
						if (!empty($check_test_result)) {
							//If the answer is saved then update the answer
							$result_id = $check_test_result[0]['result_id'];
							$update_data = array('answer' => $option, 'date_time' => date('Y-m-d H:i:s'));
							$rData = $this->common_model->update($result_id, $update_data, 'result_id', $table);
						} else {
							//If the answer is not saved then insert it
							$insert_data = array(
								'user_id' => $user_id,
								'test_id' => $test_id,
								'question_id' => $question_id,
								'answer' => $option,
								'date_time' => date('Y-m-d H:i:s')
							);
							$rData = $this->common_model->insert($insert_data, $table);
						}
						echo $rData;
					} else {
						echo 'Something Went Wrong.';
					}
				} else {
					echo 'Invalid Option';
				}
			} else {
				echo 'Something Went Wrong.';
			}
		} else {
			echo 'Something Went Wrong.';
		}
	}

	public function manage_test()
	{
		check_is_admin();
		$data['page_title'] = 'Enquiry';
		if ($this->uri->segment(3) !== false) {
			$offset = $this->uri->segment(3);	//Set offset for paging
		} else {
			$offset = 0;	//Set offset for paging
		}
		$test_id = (int)aes_decrypt($this->uri->segment(4));
		$limit = 10;	//Set totle number of records per page
		$config['base_url'] = site_url('test/manage_test');
		$config['total_rows'] = $this->test_model->get_totle_for_paging();	//Get totle number of rows for paging
		$config['per_page'] = $limit;
		$config["uri_segment"] = 3;
		$this->pagination->initialize($config);
		$data['paging'] = $this->pagination->create_links();
		$data['all_test'] = $this->test_model->get_all_with_paging($limit, $offset); //Get all data from table
		$data['edit_test_data'] = array();
		$data['uri3'] = $offset;
		//test_id is greater than zero in case of edit test
		if ($test_id > 0) {
			/*Check if test is already attempted by any user
			if not then get the test data else return error message */

			$check_test_result = $this->common_model->getRecordData('user_test_result', array('test_id' => $test_id));
			if (empty($check_test_result)) {
				$data['edit_test_data'] = $this->test_model->get_test_by_id($test_id);
			} else {
				$this->session->set_userdata('form-fail', 'You Can Not Edit This Test');
				redirect('test/manage_test/' . $this->uri->segment(3));
			}
		}
		$this->load->view('test/manage_test', $data);
	}

	function add_test()
	{
		check_is_admin();
		if (isset($_POST)) {
			$this->form_validation->set_rules('tst_tle', 'Test Title', 'trim|required|max_length[100]|alpha_numeric_spaces');
			$this->form_validation->set_rules('tst_descpton', 'Test Description', 'trim|max_length[250]');
			$this->form_validation->set_rules('tst_date', 'Test Date', 'trim|required');
			$this->form_validation->set_rules('tst_duration', 'Test Duration', 'trim|required|integer');
			$this->form_validation->set_rules('tst_pblsh', 'Publish Test', 'trim|integer');
			$this->form_validation->set_rules('qus[]', 'Questions', 'trim|required|max_length[250]');

			if ($this->form_validation->run() == FALSE) {
				$errors = validation_errors();
				$errors = str_replace('<p>', '<li>', $errors);
				$errors = str_replace('</p>', '</li>', $errors);
				echo  '<ul>' . $errors . '</ul>';
			} else {
				$this->db->trans_start();
				$title = $this->input->post('tst_tle');
				$description = $this->input->post('tst_descpton');
				$date = $this->input->post('tst_date');
				$duration = $this->input->post('tst_duration');
				$is_publish = $this->input->post('tst_pblsh');

				$questions = $this->input->post('qus');
				$options = $this->input->post('option');
				$answers = $this->input->post('qus_ans');

				$user_id = get_user_id();
				//create array of all post values 
				$data = array(
					'test_title' => $title,
					'test_description' => $description,
					'test_date' => $date,
					'test_duration' => $duration,
					'is_published' => $is_publish,
					'created_by' => $user_id,
					'creation_date_time' => date('Y-m-d H:i:s'),

				);
				$table = 'user_test';
				$test_id = $this->common_model->insert($data, $table);	//Insert data in database table through common insert function
				if ((int)$test_id > 0) {

					foreach ($questions as $key => $value) {
						$option = $answer = array();
						if (isset($options[$key])) {
							$option = $options[$key];
						}
						if (isset($answers[$key])) {
							$answer = $answers[$key];
						}
						$checkOptionHasValues = array_filter($option);
						if (!empty($checkOptionHasValues)) {
							$option = json_encode($option);
							$answer = json_encode($answer);

							$data = array(
								'test_id' => $test_id,
								'question' => $value,
								'question_option' => $option,
								'question_answer' => $answer,
							);
							$table = 'user_test_questions';
							$question_id = $this->common_model->insert($data, $table);
							if ((int)$question_id == 0) {
								echo $question_id;
								exit;
							}
						}
					}
					$this->db->trans_complete();
					$this->session->set_userdata('form-success', 'Test Have Been Added Successfully');
					echo 1;
				} else {
					echo $test_id;
				}
			}
		} else {
			echo 'Unauthorized Method';
		}
	}

	function edit_test()
	{
		check_is_admin();
		if (isset($_POST)) {
			$test_id = (int)aes_decrypt($this->uri->segment(3));
			if ($test_id > 0) {

				$this->form_validation->set_rules('tst_tle', 'Test Title', 'trim|required|max_length[100]|alpha_numeric_spaces');
				$this->form_validation->set_rules('tst_descpton', 'Test Description', 'trim|max_length[250]');
				$this->form_validation->set_rules('tst_date', 'Test Date', 'trim|required');
				$this->form_validation->set_rules('tst_duration', 'Test Duration', 'trim|required|integer');
				$this->form_validation->set_rules('tst_pblsh', 'Publish Test', 'trim|integer');
				$this->form_validation->set_rules('qus[]', 'Questions', 'trim|required|max_length[250]');

				if ($this->form_validation->run() == FALSE) {
					$errors = validation_errors();
					$errors = str_replace('<p>', '<li>', $errors);
					$errors = str_replace('</p>', '</li>', $errors);
					echo  '<ul>' . $errors . '</ul>';
				} else {
					$this->db->trans_start();
					$title = $this->input->post('tst_tle');
					$description = $this->input->post('tst_descpton');
					$date = $this->input->post('tst_date');
					$duration = $this->input->post('tst_duration');
					$is_publish = $this->input->post('tst_pblsh');

					$questions = $this->input->post('qus');
					$options = $this->input->post('option');
					$answers = $this->input->post('qus_ans');

					//create array of all post values 
					$data = array(
						'test_title' => $title,
						'test_description' => $description,
						'test_date' => $date,
						'test_duration' => $duration,
						'is_published' => $is_publish,
					);
					$table = 'user_test';
					$rData = $this->common_model->update($test_id, $data, 'test_id', $table);	//Insert data in database table through common insert function
					if ((int)$rData > 0) {
						$table = 'user_test_questions';
						$delete_all_test_question = $this->common_model->delete($test_id, 'test_id', $table);
						if ((int)$delete_all_test_question > 0) {
							foreach ($questions as $key => $value) {
								$option = $answer = array();
								if (isset($options[$key])) {
									$option = $options[$key];
								}
								if (isset($answers[$key])) {
									$answer = $answers[$key];
								}
								$checkOptionHasValues = array_filter($option);
								if (!empty($checkOptionHasValues)) {
									$option = json_encode($option);
									$answer = json_encode($answer);

									$data = array(
										'test_id' => $test_id,
										'question' => $value,
										'question_option' => $option,
										'question_answer' => $answer,
									);

									$question_id = $this->common_model->insert($data, $table);
									if ((int)$question_id == 0) {
										echo $question_id;
										exit;
									}
								}
							}
							$this->db->trans_complete();
							$this->session->set_userdata('form-success', 'Test Have Been Updated Successfully');
							echo "redirect#~@" . site_url('test/manage_test');
						} else {
							echo 'Unable To Update Test Questions';
						}
					} else {
						echo $rData;
					}
				}
			} else {
				echo 'Something Went Wrong! Please Contact To Administrator';
			}
		} else {
			echo 'Unauthorized Method';
		}
	}

	function delete_test()
	{
		check_is_admin();
		$test_id = (int)aes_decrypt($this->uri->segment(3));
		if ($test_id > 0) {
			$user_id = get_user_id();
			$check_test_result = $this->common_model->getRecordData('user_test_result', array('user_id' => $user_id, 'test_id' => $test_id));
			if (empty($check_test_result)) {
				$this->db->trans_start();
				$delete_all_test_question = $this->common_model->delete($test_id, 'test_id', 'user_test_questions');
				if ((int)$delete_all_test_question > 0) {
					$delete_test = $this->common_model->delete($test_id, 'test_id', 'user_test');
					if ((int)$delete_test > 0) {
						$this->db->trans_complete();
						$this->session->set_userdata('form-success', 'Test Have Been Deleted Successfully');
						echo 1;
					} else {
						echo $delete_test;
					}
				} else {
					echo $delete_all_test_question;
				}
			} else {
				echo 'You can not delete this test, becasue it has result data';
			}
		} else {
			echo 'Something Went Wrong! Please Contact To Administrator';
		}
	}
}//End Class
