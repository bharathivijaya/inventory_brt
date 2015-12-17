<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Edit_transaction extends CI_Controller {

    function __construct()
	{
		parent::__construct();
		$this->load->library('pagination');
	}

	public function index()
    {
		$this->view('edit_transaction_view');
    }

	public function search_transaction()
	{
	
        $cuser = $this->ReportRedirect();
		$data['labels'] = array(
                'e_date' => 'Date Entered',
				'e_type' => 'Transaction Type',
				'e_rx' => 'Rx / Trans #',
				'e_invoice' => 'Invoice #',
				'd_code' => 'NDC',
				'd_name' => 'Name',
				'v_name' => 'Vendor',
				'qty_in' => 'Quantity In','e_out' => 'Quantity Out',
                'e_lot' => 'Lot #','e_expiration' => 'Exp Date',,'action' => 'Action','e_deleteddate'=>'Deleted Date','e_status'=>'Status','e_last_edit_date' => 'Last Edited','username' => 'Username');
		
		$from_date = '';$to_date = ''; $search_query = ''; 	
		$from_date 				 = strtotime($this->input->post('fromDate'));
		$to_date   				 = strtotime($this->input->post('toDate'))+ 24*60*60;	
		$search_query 			 = $this->input->post('search_transaction'); 
					
		if($from_date != '' && $to_date == '')
		$to_date = 	$from_date +  24*60*60;		
		$data['entries'] = $this->Edit_transactionm->search_transaction($from_date,$to_date,$search_query,$cuser['id']);
					
		$this->view('edit_transaction_view',$data);
    }
	
	function edit_entry_in($transaction_id = '')
	{	  
	  $transaction_ids = str_replace('-',',',$transaction_id);
	  $result_array = $this->Edit_transactionm->edit_transaction($transaction_ids);
	  $data['original_transaction']  = $result_array['original_transaction'];
	  $data['transaction_history']   = $result_array['transaction_history'];
	  $data['selected_transaction']  = $result_array['selected_transaction'];
	  	  
	  
	  $cuser 		= $this->ReportRedirect();
	  
	  $data['vendors'] 	= $this->vendorM->getAll($cuser['id'], 'active');
	  
	  $data['all_drugs']    = $this->Edit_transactionm->get_transation_details_by_id($transaction_ids);
	  $data['drug'] 		= $data['all_drugs'];
	  
	  
	  $data['lots_data'] 	= $this->logbookM->getActiveLots();
	  $data['lots'] 		= $this->lotM->getlotsbylotsIds(@$data['selected_transaction'][0]->total_lots,$data['selected_transaction'][0]->e_drugId);
	  
	  	 
	  $drugids_array = array_unique(explode(',',$data['original_transaction'][0]->drug_ids));
	  $data['drug_ids'] = $drugids_array;
	  
	  //print_r($data['lots']);die();
	  
	  $data['parent_id'] 		= str_replace('-',',',$data['original_transaction'][0]->total_entry_ids);
	  $data['transaction_id'] 	= $transaction_id;
	  $this->view('edit_entry_in',$data);
	  
	  
	}
	
	function edit_entry_out($transaction_id = '')
	{
	  $transaction_ids = str_replace('-',',',$transaction_id);
	  $result_array = $this->Edit_transactionm->edit_transaction($transaction_ids);
	  $data['original_transaction']  = $result_array['original_transaction'];
	  $data['transaction_history']   = $result_array['transaction_history'];
	  $data['selected_transaction']  = $result_array['selected_transaction'];
	  	  
	  
	  $cuser 		= $this->ReportRedirect();
	  
	  $data['all_drugs']    = $this->Edit_transactionm->get_transation_details_by_id($transaction_ids);
	  $data['drug'] 		= $this->Edit_transactionm->get_transation_details_by_id1($transaction_ids);
	  
	  
	  $data['lots_data'] 	= $this->logbookM->getActiveLots();
	  $data['lots'] 		= $this->lotM->getlotsbylotsIds(@$data['selected_transaction'][0]->total_lots,$data['selected_transaction'][0]->e_drugId);
	  
	  	 
	  $drugids_array = array_unique(explode(',',$data['original_transaction'][0]->drug_ids));
	  $data['drug_ids'] = $drugids_array;
	  
	  if(count($drugids_array)>1)
	  $data['multiple_ndc_drugs'] 		= $this->drugM->getdrugsByIds($drugids_array);
	  //print_r($data['drug']);die();
	  
	  	    
	  $data['parent_id'] 		= str_replace('-',',',$data['original_transaction'][0]->total_entry_ids);
	  $data['transaction_id'] 	= $transaction_id;
	  $this->view('edit_entry_out',$data);
	  
	}
	
	
	 public function edit_entry($transaction_id)
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
	  $cuser 		= $this->ReportRedirect();
	  $transaction_ids = str_replace('-',',',$transaction_id);
	  $data['drugs'] = $this->Edit_transactionm->get_transation_details_by_id($transaction_ids,$cuser['id']); 
	  //print_r($data['drug']);die();	
	  $data['transaction_id'] 	= $transaction_id;
	  $this->view('transaction_details',$data);
	}
	
	
	function reverse_transaction($transaction_id = '')
	{
		$transaction_ids = str_replace('-',',',$transaction_id);
		$result_array = $this->Edit_transactionm->reverse_transaction($transaction_ids);
		
		
		foreach($result_array as $key => $entry)
		{
		 $this->lotM->reverseLotData($entry->e_lot,$entry->e_drugId,$entry->e_out,'out');
		 $this->Edit_transactionm->reverse_entry($entry->e_id);
		 $this->drugM->reverseDrugData($entry->e_drugId,$entry->e_out,'out'); 
		}
		$this->session->set_flashdata('transaction_reversed_message', 'Transaction has been reversed');
		redirect('edit_transaction/search_transaction');
	  
	}
	
	function reverse_in_transaction($transaction_id = '')
	{
		$transaction_ids = str_replace('-',',',$transaction_id);
		$result_array = $this->Edit_transactionm->reverse_transaction($transaction_ids);
		
		
		foreach($result_array as $key => $entry)
		{
		$quantity = $entry->e_new - $entry->e_old;
		$this->lotM->reverseLotData($entry->e_lot,$entry->e_drugId,$quantity,'new');
		
		$this->Edit_transactionm->reverse_entry($entry->e_id);
		$this->drugM->reverseDrugData($entry->e_drugId,$quantity ,'new'); 
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