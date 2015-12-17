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

        $data['last'] = $this->logbookM->getLast(10, $cuser['id']);
        $data['audits'] = $this->logbookM->getAudits(5, $cuser['id']);
        $data['alerts'] = $this->logbookM->getRealAlerts($cuser['id']);

        $this->view('', $data);
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

    public function add_entry_in($ndc = '')
	{
        $cuser = $this->PaymentRedirect();
        $data['vendors'] 	= $this->vendorM->getAll($cuser['id'], 'active');
        $data['lots_data'] 	= $this->logbookM->getActiveLots();

		if (!@empty($_POST))
		{
            $data['first'] = false;
            $data['drug'] = $this->drugM->getOneBy('d_code', $_POST['ndc'], $cuser['id']);

			$forceAudit = $this->logbookM->ifHadAuditForceByNDC($cuser['id'], $_POST['ndc']);
			$data['auditForce'] = $forceAudit;

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

	public function checkLotRXCode()
	{
		if ($this->logbookM->checkLotRXCode(@$_POST["e_code"])) echo "true";
		else echo "false";
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
		if (@$_GET["drugId"]) $lots = $this->logbookM->getActiveLotsByDrugID(intval($_GET["drugId"]));
		else $lots = $this->logbookM->getActiveLotsByName(@$_GET["q"]);

		$rlots = array();

		foreach ($lots as $key => $value) {
			if ($param == "") $rlots[] = $value["lotName"];
			if ($param == "with_date") $rlots[] = $value["lotName"]." - ".date("m/d/Y", $value["expirationDate"]);
			if ($param == "with_date_and_count") $rlots[] = $value["lotName"]." - ".date("m/d/Y", $value["expirationDate"])." - ".$value["count"];
		}

		echo json_encode($rlots);
	}
}