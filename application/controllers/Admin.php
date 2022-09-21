<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

    public function __construct(){
        parent::__construct();
        if($this->session->userdata('userRole') != '1'){
            redirect('user','refresh');
        }else{
            $this->load->model('Admin_model');
        }
    }

	public function index()
	{
        $this->load->view('admin/admin_css');
        $this->load->view('admin/admin_js');
        $this->load->view('Layouts/header');
        $this->load->view('Layouts/navbar');
        $this->load->view('Layouts/sidebar');
		$this->load->view('admin/admin_view');
        $this->load->view('Layouts/footer');
	}

    public function report(){

        $data['result'] = $this->Admin_model->fetch_projectAll();

        // echo "<pre>";
        // print_r($data);
        // echo "</pre>";


        // exit;
        
        $this->load->view('admin/admin_css');
        $this->load->view('admin/admin_js');
        $this->load->view('Layouts/sidebar');
        $this->load->view('Layouts/header');
		$this->load->view('admin/report_view',$data);
        $this->load->view('Layouts/footer');
    }

    public function setting(){
        $this->load->view('admin/admin_css');
        $this->load->view('admin/admin_js');
        $this->load->view('Layouts/sidebar');
        $this->load->view('Layouts/header');
		$this->load->view('admin/setting');
        $this->load->view('Layouts/footer');
    }
}