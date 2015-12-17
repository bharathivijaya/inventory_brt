<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {
	private $_csv_file_name = '';

    public function adminRedirect(){
        if ((!$this->isLoggedIn()) || (($this->session->userdata('type') !== 'admin') && ($this->session->userdata('type') !== 'super'))){
            redirect('main/');
        }
    }
    public function index(){

        $this->adminRedirect();
        //$this->view();
        redirect('admin/customers');
    }
    public function cms(){
        $this->adminRedirect();

        if (!@empty($_POST)) {
            $data['page'] = $this->adminM->getPage($_POST['page']);
        }
        else {
            $data['pages'] = $this->adminM->getPages();
        }
        $this->view('', $data);

    }

	public function master_file()
	{
		$this->adminRedirect();

		$data = array();

		$this->view('', $data);
	}

    public function save(){
        $this->adminRedirect();

        if (!@empty($_POST)){
            $this->adminM->savePage($_POST);
        }
        redirect('admin/');

    }

    public function customers(){
        $this->adminRedirect();
        $data['customers'] = $this->userM->getCompanies();
        $this->view('', $data);
    }

    public function view_customer($id){
        $this->adminRedirect();
        $data['user'] = $this->userM->getOneBy('id', $id);
        if ($data['user']['type'] == 'user') {
            redirect('user/view_user/'.$id);
        }
        else {
            $this->view('', $data);
        }
    }

	public function statistic()
	{
		$this->adminRedirect();

		$data = array();

		$data["perDay"] = $this->userM->getVisitStatistic(date("Y-m-d", time()), date("Y-m-d", time()));
		$data["perMonth"] = $this->userM->getVisitStatistic(date("Y-m-d", strtotime('-1 month')), date("Y-m-d", time()));
		$data["perYear"] = $this->userM->getVisitStatistic(date("Y-m-d", strtotime('-1 year')), date("Y-m-d", time()));
		$data["onlineNow"] = $this->userM->getOnlineUsers();

		$this->view('', $data);
	}
	
    public function add_customer($id=''){
        $this->adminRedirect();
        /*if ($id == ''){//creation
            $data['user'] = array();
            if (!@empty($_POST)){
                $this->userM->createUser($cid, $_POST);
                redirect('user/my_users');
            }
            else {
                $this->view('', $data);
            }
        }*/
        $data['user'] = $this->userM->getOneBy('id', $id);
        if ($data['user']['type'] == 'user') {
                redirect('admin/');
        }
        if (@empty($_POST)){
            $this->view('', $data);
        }
        else {
			$nowUser = $this->userM->getOneBy('id', $id);

			if ($nowUser["status"] == "email_confirmed" && $_POST["status"] == "new")
			{
				$headers = 'From: donotreply@myrxpal.com' . "\r\n" .
					'Reply-To: donotreply@myrxpal.com' . "\r\n" .
					"MIME-Version: 1.0\r\n" .
					"Content-Type: text/html; charset=utf-8\r\n" .
					'X-Mailer: PHP/' . phpversion();

				$text_html = "";
				$text_html .= 'Your account has been disabled.';

				mail($nowUser['email'], 'Your account has been disabled.', $text_html, $headers);
			}

            $this->userM->editUser($id, $_POST);
            redirect('admin/customers');
        }

    }

	function uploadImage()
	{
		if(@$_FILES['image']){
			$config['upload_path'] = 'assets/files/images/';
			$config['allowed_types'] = 'gif|jpg|png';
			$config['max_size'] = '5024';
			$config['encrypt_name'] = true;

			$this->load->library('upload', $config);

			if ( $this->upload->do_upload('image'))
			{
				$img = $this->upload->data();
				$image = $img['file_name'];

				/*$config['image_library'] = 'gd2';
				$config['source_image'] = 'assets/files/'.$img['file_name'];
				$config['maintain_ratio'] = TRUE;
				$config['width'] = 400;
				$config['height'] = 400;

				$this->load->library('image_lib', $config);

				$this->image_lib->resize();*/

				echo $image;
			}
		}
	}

    public function add_admin($aid = ''){
        $this->adminRedirect();
        if ($this->session->userdata('type') !== 'super') {
            redirect('admin/customers');
        }
        if ($aid == '') {
            $data['user'] = array();
        }
        else {
            $data['user'] = $this->userM->getOneBy('id', $aid);
        }
        if (!@empty($_POST)) {
            if ($aid == ''){
                $this->adminM->createAdmin($_POST);
            }
            else {
                $this->adminM->editAdmin($_POST, $aid);
            }
            redirect('admin/admins');
        }
        else {
            $this->view('', $data);
        }
    }
    public function delete_admin($id) {
        $this->adminRedirect();
        if ($this->session->userdata('type') !== 'super') {
            redirect('admin/customers');
        }
        $admin = $this->userM->getOneBy('id', $id);
        if ($admin['status'] == 'deleted') {
            $this->userM->changeStatus($id, 'new');
        }
        else {
            $this->userM->changeStatus($id, 'deleted');
        }
        redirect('admin/admins');
    }

    public function admins() {
        $this->adminRedirect();
        if ($this->session->userdata('type') !== 'super') {
            redirect('admin/customers');
        }
        $data['users'] = $this->adminM->getAdmins();
        $this->view('', $data);
    }

    public function reports(){
        $this->adminRedirect();
        $this->view();
    }

    public function generate_report(){
        $this->adminRedirect();
        if (!@empty($_POST)) {
            if (($_POST['type'] == "users") || ($_POST['type'] == "customers")){
                $data['users'] = $this->adminM->usersReport($_POST);

                if ($_POST['type'] == "users") {
                    $data['type'] = $_POST['users'];
                }

                if ($_POST['type'] == "customers") {
                    $data['type'] = $_POST['customers'];
                }

                $this->view('admin/r_customers', $data);
            }
            else {
                $data['sales'] = $this->adminM->salesReport();
                $this->view('admin/r_sales', $data);
            }

        }
    }

    public function banners(){
        $this->adminRedirect();
        $data['banners'] = $this->adminM->getBanners();
        $this->view('', $data);
    }

    public function add_banner($id = ''){
        $this->adminRedirect();
        if ($id !== '') {
            $data['banner'] = $this->adminM->getBannerBy('b_id', $id);
        }
        else {
            $data['banner'] = array();
        }
        if (!@empty($_POST)) {
            $data['answer'] = $this->adminM->createBanner($_POST, $_FILES, $id);
            //redirect('admin/banners');
            $this->view('admin/banner_added', $data);
            //print_r($_FILES);
        }
        else {
            $this->view('', $data);
        }
    }

    public function delete_banner($id) {
        $this->adminRedirect();
        $this->adminM->deleteBanner($id);
        redirect('admin/banners');
    }
    
    public function upload_progress()
    {
    	$this->load->model ( 'drugm', '', TRUE );
    	$data = '';
    	
    	$data['total_count'] = $this->drugm->count_temp_drug_list();
    	
    	$this->view ( 'admin/upload/upload_progress', $data );
    	
    }
    
    public function ajax_update()
    {
    	//$this->output->enable_profiler ( TRUE );
    	$id = intval($this->input->post ( 'id' ));
    	$this->load->model ( 'drugm', '', TRUE );
    	$drug_list = $this->drugm->get_all_drug_list_temp_data (100, $id);
    	
    	$added_count = 0;
    	$updated_count = 0;
    	$date = date ( "Y-m-d H:i:s", time () );
    	foreach ( $drug_list as $drug ) {
    		
    		 if (! empty ( $drug->ndc )) {
    		$status = $drug->status;
    		if ($status != null) {
    		$new_status = $status;
    		} else {
    		$new_status = 1;
    		}
    	
    		$insert_data = array (
    				'drugName' => $drug->drugName,
    				'ndc' => $drug->ndc,
    				'description' => $drug->description,
    				'packageSize' => $drug->packageSize,
    				'manufacture' => $drug->manufacture,
    				'schedule' => $drug->schedule,
    				'barcode' => $drug->barcode,
    				'date_created' => ($drug->date_created != '' ? $drug->date_created : $date),
    				'last_modified' => ($drug->last_modified != '' ? $drug->last_modified : $date),
    				'status' => $new_status
    		);
    	
    		if ($this->drugm->count_drug_by_ndc ( $drug->ndc ) == 0) {
    		$this->drugm->insert_drug ( $insert_data );
    		$added_count ++;
    		} else {
    		$this->drugm->update_drug ( $insert_data, $drug->ndc );
    		$updated_count ++;
    		}
    		}
    			
    			
    	}
    	
    	$count = $this->input->post ( 'id' ) + 100;
    	echo $count;
    }
    
    public function upload_test() {
		$this->output->enable_profiler ( TRUE );
		$file_path = str_replace ( '\\', '/', FCPATH ) . 'csv_uploads/Drug_List.csv';
		//$file_path = str_replace ( '\\', '/', FCPATH ) . 'csv_uploads/Drug_List_Update_08302015.csv'; //Live test
		
		//echo $file_path;
		
		
		$this->load->model ( 'drugm', '', TRUE );
		$this->drugm->add_to_drug_list_temp_table ( $file_path );
		
		exit;
		
		$drug_list = $this->drugm->get_all_drug_list_temp_data ();
		$added_count = 0;
		$updated_count = 0;
		$date = date ( "Y-m-d H:i:s", time () );
		foreach ( $drug_list as $drug ) {
			/*
			if (! empty ( $drug->ndc )) {
				$status = $drug->status;
				if ($status != null) {
					$new_status = $status;
				} else {
					$new_status = 1;
				}
				
				$insert_data = array (
						'drugName' => $drug->drugName,
						'ndc' => $drug->ndc,
						'description' => $drug->description,
						'packageSize' => $drug->packageSize,
						'manufacture' => $drug->manufacture,
						'schedule' => $drug->schedule,
						'barcode' => $drug->barcode,
						'date_created' => ($drug->date_created != '' ? $drug->date_created : $date),
						'last_modified' => ($drug->last_modified != '' ? $drug->last_modified : $date),
						'status' => $new_status 
				);
				
				if ($this->drugm->count_drug_by_ndc ( $drug->ndc ) == 0) {
					$this->drugm->insert_drug ( $insert_data );
					$added_count ++;
				} else {
					$this->drugm->update_drug ( $insert_data, $drug->ndc );
					$updated_count ++;
				}
			}*/
			
			
		}
		
		echo "added: ".$added_count;
		echo "update: ". $updated_count;
    	
    	
    	/*$csv_sql = "LOAD DATA LOCAL INFILE 'D:/wamp/www/test/inventory/csv_uploads/Drug_List.csv' INTO TABLE `drug_list_temp` FIELDS ESCAPED BY '\\\' 
TERMINATED BY ',' ENCLOSED BY '\"' LINES TERMINATED BY '\r\n' (
  `drugName`,
  `ndc`,
  `description`,
  `packageSize`,
  `manufacture`,
  `schedule`,
  `barcode`
 
) ;";
    	
    	echo $csv_sql."<br/>";
    	
    	$link = mysqli_init();
    	
    	if (!mysqli_real_connect($link, $this->db->hostname, $this->db->username, $this->db->password, $this->db->database)) {
    		die('Connect Error (' . mysqli_connect_errno() . ') '
    				. mysqli_connect_error());
    	}
    	
    	$result = $link->query($csv_sql);
    	
    	if (!$result) {
    	
    		printf("%s\n", mysqli_error($link));
    	
    	}*/
    }
	
	public function bulk_upload() {
		//$this->output->enable_profiler ( TRUE );
		
		ini_set('max_execution_time', 6000);
		ini_set('memory_limit', '1024M');
		set_time_limit(0);
		
		$this->load->library ( 'form_validation' );
		$this->adminRedirect ();		
		if ($this->input->post ( 'submit' )) {
			$this->form_validation->set_rules ( '_upload_csv_file', 'CSV File', 'trim|callback__upload_csv_file' );
			
			if ($this->form_validation->run ()) {
				$this->load->library ( 'csvimport' );
				
				$file_path = str_replace ( '\\', '/', FCPATH ).'csv_uploads/' . $this->_csv_file_name;				
				
				$this->load->model ( 'drugm', '', TRUE );
				$this->drugm->add_to_drug_list_temp_table ( $file_path );
				
				redirect ( base_url () . 'admin/upload_progress' );
				
				/*if ($this->csvimport->get_array ( $file_path )) {
					$csv_array = $this->csvimport->get_array ( $file_path );
					
					$this->load->model ( 'drugm', '', TRUE );
					$date = date ( "Y-m-d H:i:s", time () );
					
					foreach ( $csv_array as $row ) {
						
						if (!empty($row['ndc'])){
							
						 $status = $row['status'];
						 if( $status != null ) { 
						 	$new_status = $status;
						 }
						 else{
							$new_status =1; 
						 }
							
							$insert_data = array(
									'drugName'=>$row['drugName'],
									'ndc'=>$row['ndc'],
									'description'=>$row['description'],
									'packageSize'=>$row['packageSize'],
									'manufacture'=>$row['manufacture'],
									'schedule'=>$row['schedule'],
									'barcode'=>$row['barcode'],
									'date_created'=>($row['date_created'] != ''? $row['date_created'] : $date),
									'last_modified'=>($row['last_modified'] != ''? $row['last_modified'] : $date),
									'status'=>$new_status,
							);
							
							if ($this->drugm->count_drug_by_ndc($row['ndc']) == 0) {
								$this->drugm->insert_drug ( $insert_data );
							}else
							{
								$this->drugm->update_drug ( $insert_data, $row['ndc'] );
							}
						}
					}
					$this->session->set_flashdata ( 'success', 'CSV Data Imported Succesfully' );
					redirect ( base_url () . 'admin/bulk_upload' );
				}*/
			}
		}
		
		$data = array ();
		
		$this->view ( '', $data );
	}
	
	public function _upload_csv_file() {
		$upconfig ['upload_path'] = "./csv_uploads/";
		$upconfig ['allowed_types'] = 'csv|xls|xsl';
		$upconfig ['max_size'] = '5120';
		$this->load->library ( 'upload', $upconfig );
		
		if (! is_dir ( './csv_uploads/' )) {
			mkdir ( './csv_uploads/', 0777, true );
		}
		
		if (! $this->upload->do_upload ( 'csv_file' )) {
			$this->form_validation->set_message ( '_upload_csv_file', $this->upload->display_errors ( '', '' ) );
			return FALSE;
		} else {
			$upload_data = $this->upload->data ();
			$this->_csv_file_name = $upload_data ['file_name'];
			return TRUE;
		}
	}
	
	public function download_csv() {
		$this->load->model ( 'drugm', '', TRUE );
		$drug_list = $this->drugm->get_drug_list_for_export();
		if (count($drug_list)) {
			$this->load->library('excel');
			
			ini_set('max_execution_time', 6000);
			ini_set('memory_limit', '1024M');
			set_time_limit(0);
			
			$this->excel->setActiveSheetIndex(0);
			$this->excel->getActiveSheet()->setTitle('Drug List');			
			
			/*$this->excel->getActiveSheet()->setCellValue('A1', 'id');
			$this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);*/
			
			$this->excel->getActiveSheet()->setCellValue('A1', 'drugName');
			$this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

			$this->excel->getActiveSheet()->setCellValue('B1', 'ndc');
			$this->excel->getActiveSheet()->getStyle('B1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
			
			$this->excel->getActiveSheet()->setCellValue('C1', 'description');
			$this->excel->getActiveSheet()->getStyle('C1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
			
			$this->excel->getActiveSheet()->setCellValue('D1', 'packageSize');
			$this->excel->getActiveSheet()->getStyle('D1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
			
			$this->excel->getActiveSheet()->setCellValue('E1', 'manufacture');
			$this->excel->getActiveSheet()->getStyle('E1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
			
			$this->excel->getActiveSheet()->setCellValue('F1', 'schedule');
			$this->excel->getActiveSheet()->getStyle('F1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
			
			$this->excel->getActiveSheet()->setCellValue('G1', 'barcode');
			$this->excel->getActiveSheet()->getStyle('G1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

			$this->excel->getActiveSheet()->setCellValue('H1', 'date_created');
			$this->excel->getActiveSheet()->getStyle('H1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
			
			$this->excel->getActiveSheet()->setCellValue('I1', 'last_modified');
			$this->excel->getActiveSheet()->getStyle('I1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

			$this->excel->getActiveSheet()->setCellValue('J1', 'status');
			$this->excel->getActiveSheet()->getStyle('J1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
			
			$i = 2;
			foreach ( $drug_list as $drug ) {
				$this->excel->getActiveSheet ()->setCellValue ( 'A' . $i, $drug->drugName )
												->setCellValue ( 'B' . $i, $drug->ndc )
												->setCellValue ( 'C' . $i, $drug->description )
												->setCellValue ( 'D' . $i, $drug->packageSize )
												->setCellValue ( 'E' . $i, $drug->manufacture )
												->setCellValue ( 'F' . $i, $drug->schedule )
												->setCellValue ( 'G' . $i, $drug->barcode )
												->setCellValue ( 'H' . $i, $drug->date_created )
												->setCellValue ( 'I' . $i, $drug->last_modified )
												->setCellValue ( 'J' . $i, $drug->status );
				
				$i++;				
			}

			$filename='Drug_List.csv'; //save our workbook as this file name
			header('Content-Type: application/csv'); //mime type
			header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
			header('Cache-Control: max-age=0'); //no cache
			
			//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
			//if you want to save it as .XLSX Excel 2007 format
			//$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
			$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'CSV');
			//force user to download the Excel file without writing it to server's HD
			$objWriter->save('php://output');
				
		}
		
	}
	
	/*public function _csv_escape($data) {
		$output = "";
		$output = strip_tags($data);
		$output = str_replace(array(chr(10)."", chr(13)."", "\n", "\r\n", "&nbsp;"), " ", $output);
		$output = str_replace(array(",", "\""), "", $output);
		return $output;
	}*/

    
/*
    public function view_page($title = 'about'){
        $data['title'] = $title;
        $content = $this->adminM->getContent();
        $data['content'] = $content[0]['a_content'];
        $this->view('', $data);
    }
*/

}