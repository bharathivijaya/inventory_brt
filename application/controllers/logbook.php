<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Logbook extends CI_Controller {

    public function index()
    {
        $this->PaymentRedirect();
		$data = array();
		$data['user'] = $this->userM->getUserBy('id', $this->session->userdata("id"));
        $this->view('', $data);
    }

   
 public function dashboard()
    {
		$cuser = $this->PaymentRedirect();

      //  $data['last'] = $this->logbookM->getLast(10, $cuser['id']);
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
		$to_date   				 = strtotime($this->input->post('toDate'));	
		$search_query 			 = $this->input->post('search_transaction'); 

			$this->session->set_userdata('search_query',$search_query);
		if($from_date != '' && $to_date == '')
		$to_date = 	$from_date +  24*60*60;		
		if($from_date=="")  { $to_date= time();
		$from_date=time() - 7*24*60*60;
		}
		$this->session->set_userdata('from_date',$from_date);
		$this->session->set_userdata('to_date',$to_date);		
		
$searchto_date=$to_date+24*60*60;

			$dfrom_date = '';$dto_date = ''; $dsearch_query = ''; 	
		$dfrom_date 				 = strtotime($this->input->post('ddate1'));
		$dto_date   				 = strtotime($this->input->post('ddate2'));	
		
		if($dfrom_date != '' && $dto_date == '')
		$dto_date = 	$dfrom_date +  24*60*60;		
		if($dfrom_date=="")  { $dto_date= time();
		$dfrom_date=time() - 7*24*60*60;
		}
		$this->session->set_userdata('ddate1',$dfrom_date);
		$this->session->set_userdata('ddate2',$dto_date);		

		$searchdto_date=$dto_date+24*60*60;
		$data['entries'] = $this->Edit_transactionm->search_transaction($from_date,$searchto_date,$search_query,$cuser['id']);
					

						$from_date1 = '';$to_date1 = ''; $auditsearch_query = ''; 	
		$from_date1 				 = strtotime($this->input->post('date1'));
		$to_date1   				 = strtotime($this->input->post('date2'));	
		
		if($from_date1 != '' && $to_date1 == '')
		$to_date1 = 	$from_date1 +  24*60*60;		
		if($from_date1=="")  { $to_date1= time();
		$from_date1=time() - 7*24*60*60;
		}
		$this->session->set_userdata('date1',$from_date1);
		$this->session->set_userdata('date2',$to_date1);		

		$searchdto_date1=$to_date1+24*60*60;


	//	$this->view('edit_transaction_view',$data);
        $data['audits'] = $this->logbookM->getAudits(5, $cuser['id']);
        $data['alerts'] = $this->logbookM->getRealAlerts($cuser['id']);
        $data['deletedtrans'] = $this->reportM->deleted_transaction_report($dfrom_date,$searchdto_date,$search_query,$cuser['id']);

        $this->view('', $data);
    }
	 public function viewlots($drugid='')
    {
		$cuser = $this->PaymentRedirect();
//echo "drugid:".$drugid;
        $data['lots'] = $this->lotM->getLotsByDrugIdbrt($drugid);
       
        $this->view('viewlots', $data);
    }
    public function new_entry(){
        $this->PaymentRedirect();

        if (!@empty($_POST)){
            redirect('logbook/add_entry_'.$_POST['type']);
        }
        else {
            redirect('logbook/index');
        }
    }

    public function add_entry_out() {
        $cuser = $this->PaymentRedirect();
        if (!empty($_POST)) {
            $data['drug'] = $this->drugM->getOneBy('d_code', $_POST['ndc'], $cuser['id']);
            $data['first'] = false;

			$forceAudit = $this->logbookM->ifHadAuditForceByNDC($cuser['id'], $_POST['ndc']);
			$data['auditForce'] = $forceAudit;

			if ($forceAudit)
			{
				unset($data['drug']);
				$data['first'] = true;
			}
        } else {
            $data['drug'] = array();
            $data['first'] = true;
        }

		$data["lots_data"] = $this->logbookM->getActiveLots();

        $this->view('', $data);
    }
 public function upload()
	{
        $cuser = $this->PaymentRedirect();

        if (!@empty($_FILES))
		{
            $arr = $this->logbookM->bulkuploadqtyin($_FILES, $cuser['id']);

            if ($arr['answer'] == 'ok')
			{
                if (empty($arr['updatedlotnos']) && empty($arr['newlotnos']))
				{
                    $data['text'] = 'File has been successfully uploaded.<br>';
                   // $this->view('success', $data);
                } else {
                    $data['text'] = 'Following lot nos are updated as existing entries are present.<br>';
                    foreach ($arr['updatedlotnos'] as $one) {
                        $data['text'] .= $one.'<br>';
                    }
					  if (empty($arr['newlotnos']) )
				{
                    $data['text'] .= 'No new lots uploaded.<br>';
                   // $this->view('success', $data);
                } else {
                    $data['text'] .= 'Following new lots are added.<br>';
                    foreach ($arr['newlotnos'] as $one) {
                        $data['text'] .= $one.'<br>';
                    }
				}
 if (empty($arr['newrx']) )
				{
                    $data['text'] .= 'No new rx uploaded.<br>';
                    //$this->view('success', $data);
                } else {
                    $data['text'] .= 'Following new rxs are added.<br>';
                    foreach ($arr['newrx'] as $one) {
                        $data['text'] .= $one.'<br>';
                    }
				}
					/* if (empty($arr['oldrx']) )
				{
                    $data['text'] .= 'No existing rx found.<br>';
                   // $this->view('success', $data);
                } else {
                    $data['text'] .= 'Following rx are already existing.<br>';
                    foreach ($arr['newlotnos'] as $one) {
                        $data['text'] .= $one.'<br>';
                    }
				}*/


 if (empty($arr['errentries']) )
				{
                    $data['text'] .= 'No Errors.<br>';
                    //$this->view('success', $data);
                } else {
					$data['errentries']="<br>";
                    $data['text'] .= 'Errors found in the following data.<br>';
					$i=0;
                    foreach ($arr['errentries'] as $one) {
                        $data['errentries'] .= $one;
						if($i%2==0) $data['errentries'].='<br>';
						else $data['errentries'].="--";
						$i++;
                    }
				}





                    $this->view('success_IN', $data);
                }
            } else {
                $data['text'] = 'Uploading failed: '.$arr['answer'];
                $this->view('fail', $data);
            }
        } else {
            $this->view();
        }
    }
    public function add_entry_in($ndc = '')
	{
        $cuser = $this->PaymentRedirect();
        $data['vendors'] 	= $this->vendorM->getAll($cuser['id'], 'active');
        $data['lots_data'] 	= $this->logbookM->getActiveLots();
$data['multi_e_date'] = "";
	$data['multi_e_rx'] = "";
	$data['multi_v_name']="";
	$data['ndctype']="";
		if (!@empty($_POST))
		{
			$ndctype=$_POST['ndctype'];
			//echo "post not empty";
            $data['first'] = false;
            $data['drug'] = $this->drugM->getOneBy('d_code', $_POST['ndc'], $cuser['id']);
			$forceAudit = $this->logbookM->ifHadAuditForceByNDC($cuser['id'], $_POST['ndc']);
			$data['auditForce'] = $forceAudit;
				$data['ndctype']=$_POST['ndctype'];
		if($ndctype=="multi")
			{
			$data['multi_e_date']=$_POST['multiDiv_e_date'];
			$data['multi_e_rx']=$_POST['multiDiv_e_rx'];
			$data['multi_v_name']=$_POST['multiDiv_v_name'];
			//echo "multi edate:".$data['multi_e_date'];
		
			}
			if ($forceAudit)
			{
				unset($data['drug']);
				$data['first'] = true;
			}
        } else {
            $data['first'] = true;
            $data['drug']  = array();
        }
		if (!empty($ndc))
		{
			//echo "ndc not empty".$ndc;
			$data['drug'] 		= $this->drugM->getOneBy('d_code', $ndc, $cuser['id']);

			$forceAudit		 	= $this->logbookM->ifHadAuditForceByNDC($cuser['id'], $ndc);
			$data['auditForce'] = $forceAudit;
			if ($forceAudit)
			{
				unset($data['drug']);
				$data['first'] = true;
			}
		}
		
        $this->view('', $data);
    }

    public function add_entry_audit($ndc = '')
	{
        $cuser = $this->PaymentRedirect();
		$data = array();

        if (!@empty($_POST))
		{
            $data['first'] = false;
            $data['drug'] = $this->drugM->getOneBy('d_code', $_POST['ndc'], $cuser['id']);
			$data["lots"] = $this->lotM->getActiveLotsByDrugId(@$data['drug']["d_id"]);
        } else {
            $data['first'] = true;
            $data['drug'] = array();
        }

		if (!empty($ndc))
		{
			$data['drug'] = $this->drugM->getOneBy('d_code', $ndc, $cuser['id']);
			$data["lots"] = $this->lotM->getActiveLotsByDrugId($data['drug']["d_id"]);
		}

        $this->view('', $data);
    }
	
	public function add_entry_edit($ndc = '')
	{
        $cuser = $this->PaymentRedirect();
		$data = array();

        if (!empty($_POST))
		{
            $data['first'] = false;
            $data['drug'] = $this->drugM->getOneBy('d_code', $_POST['ndc'], $cuser['id']);
			$data["lots"] = $this->lotM->getActiveLotsByDrugId(@$data['drug']["d_id"]);
        } else {
            $data['first'] = true;
            $data['drug'] = array();
        }

		if (!empty($ndc))
		{
			$data['drug'] = $this->drugM->getOneBy('d_code', $ndc, $cuser['id']);
			$data["lots"] = $this->lotM->getActiveLotsByDrugId($data['drug']["d_id"]);
		}

        $this->view('', $data);
    }
	

	public function checkLotExpires()
	{
		$cuser = $this->PaymentRedirect();

		$alertExpires = $this->logbookM->ifHasDontAllowDrug($cuser["id"], @$_POST['e_drugId'], @$_POST['e_lot']);

		if ($alertExpires) echo "true";
		else echo "false";
	}

	public function isLotExistM()
	{
		$value = "";

		foreach (@$_POST['e_lot'] as $key => $one)
		{
			$value = $_POST['e_lot'][$key];
		}

		if ($this->drugM->checkLotExists($value)) $isAvailable = true;
		else $isAvailable = false;

		echo json_encode(array(
			'valid' => $isAvailable
		));
	}

	public function checkActiveLot()
	{
		if ($this->logbookM->getActiveLot(@$_POST["e_lot"], 1)) echo "active";
		if ($this->logbookM->getActiveLot(@$_POST["e_lot"], 0)) echo "notactive";
	}

	public function checkLotRXCode()  //code edited by bharathi from iqbal's code
	{
		if ($this->logbookM->checkLotRXCode(@$_POST["e_code"])) echo "true";
		else echo "false";
		
		/*$rxcode=$this->logbookM->checkLotRXCode(@$_POST["e_code"]);

		 header('Content-Type: application/json');

        echo(json_encode($rxcode));*/
	}
	public function checkLotNumber()  //code edited by bharathi from iqbal's code
	{
		if ($this->logbookM->checkLotNumber(@$_POST["e_code"])) echo "true";
		else echo "false";
		
		/*$rxcode=$this->logbookM->checkLotRXCode(@$_POST["e_code"]);

		 header('Content-Type: application/json');

        echo(json_encode($rxcode));*/
	}
	public function checkInvoice()
	{
		if ($this->logbookM->checkLotInvoice(@$_POST["e_code"])) echo "true";
		else echo "false";
	}

	public function isLotExist()
	{
		if ($this->drugM->checkLotExists(@$_POST['e_lot'])) $isAvailable = true;
		else $isAvailable = false;

		echo json_encode(array(
			'valid' => $isAvailable,
		));
	}

    public function save()
	{
        $cuser = $this->PaymentRedirect();
        $uid = $this->session->userdata('id');
		$isNewAudit = false;

		if (!empty($_POST))
		{
			if (isset($_POST["confirm_new"]))
			{
				$isNewAudit = true;
				unset($_POST["confirm_new"]);
			}

			$status = $this->logbookM->saveEntry($cuser['id'], $uid, $_POST);

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
        }
    }
	
	
	 public function edit_entry($transaction_id)
	{
        $cuser 		= $this->PaymentRedirect();
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
        }
    }
	

	public function getJSON_lots($param = "")
	{
		if (@$_GET["drugId"]) $lots = $this->logbookM->getActiveLotsByDrugIDEditTransaction(intval($_GET["drugId"]));
		else $lots = $this->logbookM->getActiveLotsByNameEditTransaction(@$_GET["q"]);

		$rlots = array();

		foreach ($lots as $key => $value) {
			if ($param == "") $rlots[] = $value["lotName"];
			if ($param == "with_date") $rlots[] = $value["lotName"]." - ".date("m/d/Y", $value["expirationDate"]);
			if ($param == "with_date_and_count")  {
				if($value["count"] > 0) { $rlots[] = $value["lotName"]." - ".date("m/d/Y", $value["expirationDate"])." - ".$value["count"];}
		}
		}

		echo json_encode($rlots);
	}
	
	public function getJSON_lots_brt($param = "")
	{
		 $lots = $this->logbookM->getActiveLotsByName(@$_GET["lotcode"]);

		$rlots = array();

		foreach ($lots as $key => $value) {
		
			if ($param == "with_date_and_count") $rlots[] = $value["lotName"]." - ".date("m/d/Y", $value["expirationDate"])." - ".$value["count"];
		}

		echo json_encode($rlots);
	}
	
		
   function ReportRedirect(){
        $cuser = $this->PaymentRedirect();
        $user = $this->userM->getUserBy('id', $this->session->userdata('id'));
        if ($user['reports'] == 'Off') {
            redirect('main/');
        }
        return $cuser;
    }
	/*if (@$_GET["drugId"]) $lots = $this->logbookM->getActiveLotsByDrugID(intval($_GET["drugId"]));
		else $lots = $this->logbookM->getActiveLotsByName(@$_GET["q"]);

		$rlots = array();

		foreach ($lots as $key => $value) {
			if ($param == "") $rlots[] = $value["lotName"];
			if ($param == "with_date") $rlots[] = $value["lotName"]." - ".date("m/d/Y", $value["expirationDate"]);
			if ($param == "with_date_and_count") $rlots[] = $value["lotName"]." - ".date("m/d/Y", $value["expirationDate"])." - ".$value["count"];
		}

		echo json_encode($rlots);*/
	}
