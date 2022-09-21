<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

    public function __construct(){
        parent::__construct();
        if($this->session->userdata('userRole') != '3'){ // 3 = user
            redirect('member','refresh');
        }
    }

	public function index()
	{
        $this->load->view('Layouts/header');
		$this->load->view('user/user_view');
        $this->load->view('Layouts/footer');
	}
}