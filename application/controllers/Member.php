<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Member extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('Member_model');
	}
	public function index()
	{
		$this->load->view('myCss');
		$this->load->view('bgAnimation');
		$this->load->view('login_view');
		$this->load->view('myJs');
	}
	public function check()
	{
		if(isset($_SESSION['userName'])){
			if($_SESSION['userRole'] == '1'){
				redirect('admin');
			}else{
				redirect('user');
			}
		}else{
			if($this->input->post('username') == '' || $this->input->post('password') == ''){
				$this->load->view('member');
			}else{
				$username = strtoupper($this->input->post('username'));
				$password = $this->input->post('password');
				$result = $this->Member_model->fetch_user_login($username,sha1($password));
				if(!empty($result)){
					$sess = array(
						'userName' => $result->userName,
						'userRole' => $result->userRole
					);
					$this->session->set_userdata($sess);
					($this->session->userdata('userName') == 'ADMIN') ? redirect('admin') : redirect('user');
				}else{
					$jsonurl = 'http://203.131.209.236/_authen/_authen.php?user_login=' . $username;
					$json = file_get_contents($jsonurl);
					$returnInfo = json_decode($json, true);
					if($returnInfo['chkData'] == md5($password)){
						$sess = array(
							'userName' => $username,
							'userRole' => '3'
						);
						$this->session->set_userdata($sess);
						print_r($_SESSION);
					}else{
						$this->load->library('session');
						$this->session->set_flashdata('err_message', 'Username or Password is invalid');
						$this->session->unset_userdata(array('userName','userRole'));
						redirect('member');
					}
				}
			}
		}
	}
	public function signup(){
		$this->load->view('myCss');
		$this->load->view('register_view');
		$this->load->view('myJs');
	}

	public function create(){
		$username = strtoupper($this->input->post('username_regis'));
		$password = strtoupper(sha1($this->input->post('password_regis')));
		if($username != '' && $password != ''){
			$result = $this->Member_model->create_user($username,$password);
		}
	}

	public function logout(){
		$this->session->sess_destroy();
		redirect('member');
	}
}