<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Bangkok');
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Upload extends CI_Controller {
	
	public function __construct() {
		parent::__construct();
		// Load Model
		$this->load->model('upload_model');
		$this->ip_address    = $_SERVER['REMOTE_ADDR'];
		$this->datetime 	    = date("Y-m-d H:i:s");
	}
	
	public function index() {
        $this->load->view('admin/admin_css');
        $this->load->view('admin/admin_js');
	    $this->load->view("formupload_view");
	}
	
	public function display() {
    	$data 	= [];
    	$data ["result"] = $this->upload->get_all();
    	$this->load->view("formupload_view");
    }

	public function import() {
		$path 		= 'documents/users/';
		$json 		= [];
		$this->upload_config($path);
		if (!$this->upload->do_upload('file')) {
			$json = [
				'error_message' => showErrorMessage($this->upload->display_errors()),
			];
		} else {
			$file_data 	= $this->upload->data();
			$file_name 	= $path.$file_data['file_name'];
			$arr_file 	= explode('.', $file_name);
			$extension 	= end($arr_file);
			if('csv' == $extension) {
				$reader 	= new \PhpOffice\PhpSpreadsheet\Reader\Csv();
			} else {
				$reader 	= new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
			}
			$spreadsheet 	= $reader->load($file_name);
			$sheet_data 	= $spreadsheet->getActiveSheet()->toArray();
			$list 			= [];
			foreach($sheet_data as $key => $val) {
				if($key != null && $val[0] != null) {
                    $list[] = array(
                        'projectCode' => $val[1],
                        'projectCertificateNo' => $val[2],
                        'projectNameTH' => $val[3],
                        'projectNameEN' => $val[4],
                        'projectPosition' => $val[5],
                        'projectLeader' => $val[6],
                        'projectDepartment' => $val[7],
                        'projectFaculty' => $val[8],
                        'projectMobile' => $val[9],
                        'projectEmail' => $val[10],
                        'projectSecurityLab' => $val[11],
                        'projectType' => $val[12],
                        'projectRoom' => $val[13],
                        'projectRequestDate' => $val[14],
                        'projectApprovalDate' => $val[15],
                        'projectProcessDate' => $val[16],
                        'projectCertificateExpireDate' => $val[17],
                        'projectProcessResearcherDate' => $val[18],
                        'projectExtendDate' => $val[19],
                        'projectExtendDateEnd' => $val[20],
                        'projectDateClose' => $val[21],
                        'projectStatus' => $val[22],
                        'projectCreated' => $val[23],
                    );
				}
			}

            // echo "<pre>";
            // print_r($list);
            // echo "</pre>";
            // exit;
			if(file_exists($file_name))
				unlink($file_name);
			if(count($list) > 0) {
                $this->table = 'projects';
				$result 	= $this->upload_model->add_batch($list);
				if($result) {
					$json = [
						'success_message' 	=> "Something went wrong. Please try again.",
					];
				} else {
					$json = [
						'error_message' 	=> "No new record is found."
					];
				}
			} else {
				$json = [
					'error_message' => "No new record is found.",
				];
			}
		}
		echo json_encode($json);
	}

	public function upload_config($path) {
		if (!is_dir($path)) 
			mkdir($path, 0777, TRUE);		
		$config['upload_path'] 		= './'.$path;		
		$config['allowed_types'] 	= 'csv|CSV|xlsx|XLSX|xls|XLS';
		$config['max_filename']	 	= '255';
		$config['encrypt_name'] 	= TRUE;
		$config['max_size'] 		= 4096; 
		$this->load->library('upload', $config);
	}
}