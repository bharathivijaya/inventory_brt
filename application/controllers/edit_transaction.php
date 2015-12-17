<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Edit_transaction extends CI_Controller {

    function __construct()
	{
		parent::__construct();
		$this->load->library('pagination');
	}

	public function index() //function edited by bharathi from iqbal's code
    {
			$cuser = $this->ReportRedirect();
		$data['labels'] = array(
                'e_date' => 'Date Entered',
				'e_type' => 'Transaction Type',
				'e_rx' => 'Rx / Trans / Invoice #',
				'd_code' => 'NDC',
				'd_name' => 'Name',
				'v_name' => 'Vendor',
				'qty_in' => 'Quantity In','e_out' => 'Quantity Out',
                'e_lot' => 'Lot #','e_expiration' => 'Exp Date','e_last_edit_date' => 'Last Edited','username' => 'Username','e_deleteddate'=>'Deleted Date',
			'e_status'=>'Status','action' => 'Action',);
		$search_query 	= $this->session->userdata('search_query');
		$from_date 		= $this->session->userdata('from_date');
		$to_date 		= $this->session->userdata('to_date');
		if($from_date != '' && $to_date == '')
		$to_date = 	$from_date +  24*60*60;		
		if($from_date != '' && $to_date == '' || $search_query !='')
		$data['entries'] = $this->Edit_transactionm->search_transaction($from_date,$to_date,$search_query,$cuser['id']);
			
		$this->view('edit_transaction_view',$data);
    }

	public function search_transaction() //function edited by bharathi from iqbal's code
	{
	
        $cuser = $this->ReportRedirect();
		$data['labels'] = array(
                'e_date' => 'Date Entered',
				'e_type' => 'Transaction Type',
				'e_rx' => 'Rx / Trans / Invoice #',
				'd_code' => 'NDC',
				'd_name' => 'Name',
				'v_name' => 'Vendor',
				'qty_in' => 'Quantity In','e_out' => 'Quantity Out',
                'e_lot' => 'Lot #','e_expiration' => 'Exp Date','e_last_edit_date' => 'Last Edited','username' => 'Username','e_deleteddate'=>'Deleted Date',
			'e_status'=>'Status','action' => 'Action',);
		
		
		$from_date = '';$to_date = ''; $search_query = ''; 	
		$from_date 				 = strtotime($this->input->post('fromDate'));
		$to_date   				 = strtotime($this->input->post('toDate'))+ 24*60*60;	
		$search_query 			 = $this->input->post('search_transaction'); 

			$this->session->set_userdata('search_query',$search_query);
		$this->session->set_userdata('from_date',$from_date);
		$this->session->set_userdata('to_date',$to_date);		
		if($from_date != '' && $to_date == '')
		$to_date = 	$from_date +  24*60*60;		
		$data['entries'] = $this->Edit_transactionm->search_transaction($from_date,$to_date,$search_query,$cuser['id']);
					
		$this->view('edit_transaction_view',$data);
    }
	
	function edit_entry_in($transaction_id = '')//function edited by bharathi from iqbal's code
	{
		// $cuser 		= $this->ReportRedirect();
	 // $data['drug'] = $this->Edit_transactionm->get_transation_details_by_id($transaction_id,$cuser['id']); 
	 // $data["lots_data"] = $this->logbookM->getActiveLots();
	  
	  //$data["transation_history"] = $this->Edit_transactionm->transaction_history($data['drug']['d_code'],$cuser['id']); 
	//  $data["transaction_id"] = $transaction_id;
	//  $this->view('edit_entry_in',$data);

 $transaction_ids = str_replace('-',',',$transaction_id);
	  $result_array = $this->Edit_transactionm->edit_transaction($transaction_ids);
	  $data['original_transaction']  = $result_array['original_transaction'];
	  $data['transaction_history']   = $result_array['transaction_history'];
	  $data['selected_transaction']  = $result_array['selected_transaction'];
	  	  
	  
	  $cuser 		= $this->ReportRedirect();
	  $data['vendors'] 	= $this->vendorM->getAll($cuser['id'], 'active');
	  $orignal_trans_ids    = str_replace('-',',',$data['original_transaction'][0]->total_entry_ids);
	  $result_array 		= $this->Edit_transactionm->get_transation_details_by_id($orignal_trans_ids); 
	   
	  $data['all_drugs']    = $result_array['drug_details'];
	  $data['drug'] 		= $this->Edit_transactionm->get_transation_details_by_id1($transaction_ids);
	  
	  $drug_ids_comma_seprated = $data['selected_transaction'][0]->drug_ids;
	  $data['lots_data'] 	= $this->logbookM->getActiveLots();
	    $data['lots'] 		= $this->lotM->getlotsbylotsIds(@$data['selected_transaction'][0]->total_lots,$data['selected_transaction'][0]->drug_ids,
	  $data['selected_transaction'][0]->total_e_expiration);
	  
	  	 
	  $drugids_array = array_unique(explode(',',$data['original_transaction'][0]->drug_ids));
	  $data['drug_ids'] = $drugids_array;
	  
	  
	  if(count($drugids_array)>1)
	  $data['multiple_ndc_drugs'] 		= $this->drugM->getdrugsByIds($data['original_transaction'][0]->drug_ids);
	  //print_r($data['original_transaction'][0]->drug_ids).'<br/>';
	  //print_r($data['lots']);die();
	  
	  	    
	  $data['parent_id'] 		= str_replace('-',',',$data['original_transaction'][0]->total_entry_ids);
	  $data['transaction_id'] 	= $transaction_id;
	  $this->view('edit_entry_in',$data);


	  
	}
	function db_edit_entry_in($transaction_id = '')//function edited by bharathi from iqbal's code
	{
		// $cuser 		= $this->ReportRedirect();
	 // $data['drug'] = $this->Edit_transactionm->get_transation_details_by_id($transaction_id,$cuser['id']); 
	 // $data["lots_data"] = $this->logbookM->getActiveLots();
	  
	  //$data["transation_history"] = $this->Edit_transactionm->transaction_history($data['drug']['d_code'],$cuser['id']); 
	//  $data["transaction_id"] = $transaction_id;
	//  $this->view('edit_entry_in',$data);

 $transaction_ids = str_replace('-',',',$transaction_id);
	  $result_array = $this->Edit_transactionm->edit_transaction($transaction_ids);
	  $data['original_transaction']  = $result_array['original_transaction'];
	  $data['transaction_history']   = $result_array['transaction_history'];
	  $data['selected_transaction']  = $result_array['selected_transaction'];
	  	  
	  
	  $cuser 		= $this->ReportRedirect();
	  $data['vendors'] 	= $this->vendorM->getAll($cuser['id'], 'active');
	  $orignal_trans_ids    = str_replace('-',',',$data['original_transaction'][0]->total_entry_ids);
	  $result_array 		= $this->Edit_transactionm->get_transation_details_by_id($orignal_trans_ids); 
	   
	  $data['all_drugs']    = $result_array['drug_details'];
	  $data['drug'] 		= $this->Edit_transactionm->get_transation_details_by_id1($transaction_ids);
	  
	  $drug_ids_comma_seprated = $data['selected_transaction'][0]->drug_ids;
	  $data['lots_data'] 	= $this->logbookM->getActiveLots();
	    $data['lots'] 		= $this->lotM->getlotsbylotsIds(@$data['selected_transaction'][0]->total_lots,$data['selected_transaction'][0]->drug_ids,
	  $data['selected_transaction'][0]->total_e_expiration);
	  
	  	 
	  $drugids_array = array_unique(explode(',',$data['original_transaction'][0]->drug_ids));
	  $data['drug_ids'] = $drugids_array;
	  
	  
	  if(count($drugids_array)>1)
	  $data['multiple_ndc_drugs'] 		= $this->drugM->getdrugsByIds($data['original_transaction'][0]->drug_ids);
	  //print_r($data['original_transaction'][0]->drug_ids).'<br/>';
	  //print_r($data['lots']);die();
	  
	  	    
	  $data['parent_id'] 		= str_replace('-',',',$data['original_transaction'][0]->total_entry_ids);
	  $data['transaction_id'] 	= $transaction_id;
	  $this->view('db_edit_entry_in',$data);


	  
	}
	
	function edit_entry_out($transaction_id = '') //function edited by bharathi from iqbal's code
	{
	
	  //$data['all_drugs']    = $this->Edit_transactionm->get_transation_details_by_id($transaction_ids);
	 // $data['drug'] 		= $data['all_drugs'][0];  	  
	 // $data['lots_data'] 	= $this->logbookM->getActiveLots();
	  //$data['lots'] 		= $this->lotM->getlotsbylotsIds(@$data['selected_transaction'][0]->total_lots);
	 
	  //$drugids_array = array_unique(explode(',',$data['original_transaction'][0]->drug_ids));
	  //$data['drug_ids'] = $drugids_array;
	  	    
	 // $data['parent_id'] 		= str_replace('-',',',$data['original_transaction'][0]->total_entry_ids);
	//  $data['transaction_id'] 	= $transaction_id;
	//  $this->view('edit_entry_out',$data);




	  $transaction_ids = str_replace('-',',',$transaction_id);
	  $result_array = $this->Edit_transactionm->edit_transaction($transaction_ids);
	  $data['original_transaction']  = $result_array['original_transaction'];
	  $data['transaction_history']   = $result_array['transaction_history'];
	  $data['selected_transaction']  = $result_array['selected_transaction'];
	  	  
	  $cuser 				= $this->ReportRedirect();
	  $orignal_trans_ids    = str_replace('-',',',$data['original_transaction'][0]->total_entry_ids);
	  $result_array 		= $this->Edit_transactionm->get_transation_details_by_id($orignal_trans_ids); 
	  $data['all_drugs']    = $result_array['drug_details'];
	  $data['drug'] 		= $this->Edit_transactionm->get_transation_details_by_id1($transaction_ids);
	  
	  $drug_ids_comma_seprated = $data['selected_transaction'][0]->drug_ids;
	  $data['lots_data'] 	= $this->logbookM->getActiveLots();
	    
	  
	  $data['lots'] 		= $this->lotM->getlotsbylotsIds(@$data['selected_transaction'][0]->total_lots,$data['selected_transaction'][0]->drug_ids,
	  $data['selected_transaction'][0]->total_e_expiration);
	  
	  
	  	 
	  $drugids_array = array_unique(explode(',',$data['original_transaction'][0]->drug_ids));
	  $data['drug_ids'] = $drugids_array;
	  
	  
	  if(count($drugids_array)>1)
	  $data['multiple_ndc_drugs'] 		= $this->drugM->getdrugsByIds($data['original_transaction'][0]->drug_ids);
	  //print_r($data['original_transaction'][0]->total_entry_ids).'<br/>';
	   //print_r($data['original_transaction'][0]->total_entry_ids);die();
	  
	  	    
	  $data['parent_id'] 		= str_replace('-',',',$data['original_transaction'][0]->total_entry_ids);
	  $data['transaction_id'] 	= $transaction_id;
	  $this->view('edit_entry_out',$data);
	  
	}
	
	
	 public function edit_entry($transaction_id) //function edited by bharathi from iqbal's code
	{
		  $cuser 		= $this->PaymentRedirect();
        $uid 		= $this->session->userdata('id');
		$isNewAudit = false;
		if (!empty($_POST))
		{
			if($_POST['e_type'] == 'new_mul')
			$status = $this->logbookM->editEntryIn($cuser['id'], $uid, $_POST,$transaction_id);
			else
			$status = $this->logbookM->editEntry($cuser['id'], $uid, $_POST,$transaction_id);

			if ($status == -1)
			{
				$data['text'] = 'Lot not found!';
				$this->view('fail', $data);
				return;
			}
		
            $data['text'] = 'Entry saved';
            $this->view('success', $data);
        }
       /* $cuser 		= $this->PaymentRedirect();
        $uid 		= $this->session->userdata('id');
		$isNewAudit = false;
		if (!empty($_POST))
		{
			
			$status = $this->logbookM->editEntry($cuser['id'], $uid, $_POST,$transaction_id);

			if ($status == -1)
			{
				$data['text'] = 'Lot not found!';
				$this->view('fail', $data);
				return;
			}
		}

		// if save & new pressed
		if ($isNewAudit)
			redirect("/logbook/add_entry_audit");

		if (@isset($_POST['add_another_in']))
			redirect("/logbook/add_entry_in");

		if (@isset($_POST['add_another_out']))
			redirect("/logbook/add_entry_out");

		if (@$_POST['add_new'] == 1) {
            if (($_POST['e_type'] == 'out') || ($_POST['e_type'] == 'multi')) {
                redirect('logbook/add_entry_out');
            } else if (($_POST['e_type'] == 'new') || ($_POST['e_type'] == 'return')) {
                redirect('logbook/add_entry_in');
            }
        } else {
            $data['text'] = 'Entry saved';
            $this->view('success', $data);
        }*/
    }
	
	public function save($transaction_id)
	{
        $cuser = $this->PaymentRedirect();
        $uid = $this->session->userdata('id');
		if (!@empty($_POST))
		{
			
			$status = $this->Edit_transactionm->saveEntry($cuser['id'], $uid, $_POST,$transaction_id);
			
			if ($status == -1)
			{
				$data['text'] = 'Lot not found!';
				$this->view('fail', $data);
				return;
			}
		}
			$data['text'] = 'Entry saved';
			redirect("/edit_transaction/edit/".$transaction_id);
		    
        
    }

	function transaction_details($transaction_id = '')
	{
		 $transaction_ids = str_replace('-',',',$transaction_id);
	  $result_array = $this->Edit_transactionm->edit_transaction($transaction_ids);
	  $data['original_transaction']  = $result_array['original_transaction'];
 $cuser 				= $this->ReportRedirect();
	  $orignal_trans_ids    = str_replace('-',',',$data['original_transaction'][0]->total_entry_ids);
	  $result_array 		= $this->Edit_transactionm->get_transation_details_by_id($orignal_trans_ids); 
	  $data['all_drugs']    = $result_array['drug_details'];
	  $data['drug'] 		= $this->Edit_transactionm->get_transation_details_by_id1($transaction_ids);
	  
	  //echo "transaction id:".$transaction_id;
	  $result_array  = $this->Edit_transactionm->get_transation_details_by_id($transaction_id,$cuser['id']); 	
	  $data['drug_details']=$result_array['drug_details'];
		  $data['transaction_details']=$result_array['transaction_details'];
	  $data['transaction_id'] 	= $transaction_id;

	  $this->view('transaction_details',$data);
	}



	function deletedtransaction_details($transaction_id = '')
	{
		 $transaction_ids = str_replace('-',',',$transaction_id);
	  $result_array = $this->Edit_transactionm->edit_deletedtransaction($transaction_ids);
	  $data['original_transaction']  = $result_array['original_transaction'];
	  	  $data['transaction_history']=$result_array['transaction_history'];
 $cuser 				= $this->ReportRedirect();
	  $orignal_trans_ids    = str_replace('-',',',$data['original_transaction'][0]->total_entry_ids);
	  $result_array 		= $this->Edit_transactionm->get_transation_details_by_id($orignal_trans_ids); 
	  $data['all_drugs']    = $result_array['drug_details'];
	  $data['drug'] 		= $this->Edit_transactionm->get_transation_details_by_id1($transaction_ids);
	  
	  //echo "transaction id:".$transaction_id;
	  $result_array  = $this->Edit_transactionm->get_transation_details_by_id($transaction_id,$cuser['id']); 	
	  $data['drug_details']=$result_array['drug_details'];
		  $data['transaction_details']=$result_array['transaction_details'];
	
	  $data['transaction_id'] 	= $transaction_id;

	  $this->view('deletedtransaction_details',$data);
	}
	
	function reverse_transaction($transaction_id = '') //function edited by bharathi from iqbal's code
	{
			$transaction_ids = str_replace('-',',',$transaction_id);
		$result_array = $this->Edit_transactionm->reverse_transaction($transaction_ids);
		
		
		foreach($result_array as $key => $entry)
		{
		 if($entry->e_lot !='')
		 $this->lotM->reverseLotData($entry->e_lot,$entry->e_drugId,$entry->e_out,$entry->e_out == 0 ? 'new' : 'out');
		 $this->Edit_transactionm->reverse_entry($entry->e_id);
		 $this->drugM->reverseDrugData($entry->e_drugId,$entry->e_out,$entry->e_out == 0 ? 'new' : 'out'); 
		}
		$this->session->set_flashdata('transaction_reversed_message', 'Transaction has been reversed');
		redirect('edit_transaction/search_transaction');


		/*$transaction_ids = str_replace('-',',',$transaction_id);
		$result_array = $this->Edit_transactionm->reverse_transaction($transaction_ids);
		
		
		foreach($result_array as $key => $entry)
		{
		$this->lotM->reverseLotData($entry->e_lot,$entry->e_drugId,$entry->e_out);
		
		$this->Edit_transactionm->reverse_entry($entry->e_id);
		$this->drugM->reverseDrugData($entry->e_drugId,$entry->e_out); 
		}
		$this->session->set_flashdata('transaction_reversed_message', 'Transaction has been reversed');
		redirect('edit_transaction/search_transaction');*/
	  
	}
	
	
	function reverse_in_transaction($transaction_id = '')  //new function implemented in iqbal's code
	{
		$transaction_ids = str_replace('-',',',$transaction_id);
		$result_array = $this->Edit_transactionm->reverse_transaction($transaction_ids);
		
		
		foreach($result_array as $key => $entry)
		{
		$quantity = $entry->e_new - $entry->e_old;
		$this->lotM->reverseLotData($entry->e_lot,$entry->e_drugId,$quantity,$entry->e_out == 0 ? 'new' : 'out');
		
		$this->Edit_transactionm->reverse_entry($entry->e_id);
		$this->drugM->reverseDrugData($entry->e_drugId,$quantity ,$entry->e_out == 0 ? 'new' : 'out'); 
		}
		$this->session->set_flashdata('transaction_reversed_message', 'Transaction has been reversed');
		redirect('edit_transaction/search_transaction');
	  
	}
	
   function ReportRedirect(){
        $cuser = $this->PaymentRedirect();
        $user = $this->userM->getUserBy('id', $this->session->userdata('id'));
        if ($user['reports'] == 'Off') {
            redirect('main/');
        }
        return $cuser;
    }
	
	
}