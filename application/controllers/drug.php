<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Drug extends CI_Controller {

    public function index()
    {
        /*
        if(!$this->isLoggedIn()){
            redirect('main/');
        }
        $id = $this->session->userdata('id');
        if ($this->session->userdata('type') == 'user'){
            $user = $this->userM->getUserBy('id', $id);
            $cid = $user['parent_id'];
        }
        else {
            $cid = $id;
        }
        $data['drugs'] = $this->drugM->getAll($cid);
        */
        $cuser = $this->PaymentRedirect();
        $data['drugs'] = $this->drugM->getAll($cuser['id']);
        $this->view('', $data);
    }

	public function adminRedirect()
	{
		if ((!$this->isLoggedIn()) || (($this->session->userdata('type') !== 'admin') && ($this->session->userdata('type') !== 'super')))
			redirect('main/');
	}

    public function view_drug($id)
	{
        $cuser = $this->PaymentRedirect();
        $data['drug'] = $this->drugM->getOneBy('d_id', $id, $cuser['id']);
		$data['drugCats'] = $this->categoryM->getDrugCatsNames($id);

		if (empty($data['drug']))
			redirect("/drug");

        $this->view('', $data);
    }

	public function inventory_in($id)
	{
		$cuser = $this->PaymentRedirect();
		$data['drug'] = $this->drugM->getOneBy('d_id', $id, $cuser['id']);
		$data['inventory_in'] = $this->drugM->selectAllInventoryIn($id);
		$this->view('', $data);
	}

	public function inventory_out($id)
	{
		$cuser = $this->PaymentRedirect();
		$data['drug'] = $this->drugM->getOneBy('d_id', $id, $cuser['id']);
		$data['inventory_out'] = $this->drugM->selectAllInventoryOut($id);
		$this->view('', $data);
	}

	public function inventory_audit($id)
	{
		$cuser = $this->PaymentRedirect();
		$data['drug'] = $this->drugM->getOneBy('d_id', $id, $cuser['id']);
		$data['inventory_audit'] = $this->drugM->selectAllInventoryAudit($id);
		$this->view('', $data);
	}

	public function alerts($id)
	{
		$cuser = $this->PaymentRedirect();
		$data = array();
		$data['drug'] = $this->drugM->getOneBy('d_id', $id, $cuser['id']);
		$data['alerts_history'] = $this->alertM->getHistoryByDrugId($id);
		$this->view('', $data);
	}
	
	public function add_alert($id) {
		// $this->output->enable_profiler ( TRUE );
		$cuser = $this->PaymentRedirect ();
		
		$this->load->model ( 'drugm', '', TRUE );
		
		$alert_count = $this->drugm->get_drug_alert_count ( $id, $cuser ['id'] );
		if ($alert_count > 0) {
			redirect ( 'drug/view_alert/' . $id );
		}
		
		$data = array ();
		$data ['drug'] = $this->drugM->getOneBy ( 'd_id', $id, $cuser ['id'] );
		$this->view ( '', $data );
	}
	
	public function view_alert($drug_id = '') {
		$cuser = $this->PaymentRedirect ();
		$this->load->model ( 'drugm', '', TRUE );
		$data ['alert_data'] = $this->drugm->get_drug_alert_data ( $drug_id, $cuser ['id'] );
		$data ['drug_data'] = $this->drugm->get_drug_data ( $drug_id, $cuser ['id'] );
		$this->view ( 'alert/view_alert', $data );
	}

	public function lots($id)
	{
		$cuser = $this->PaymentRedirect();
		$data = array();
		$data['drug'] = $this->drugM->getOneBy('d_id', $id, $cuser['id']);
		$data['lots'] = $this->lotM->getLotsByDrugId($id);
		$this->view('', $data);
	}

	public function drug_catalog()
	{
		$cuser = $this->PaymentRedirect();

		$data = array();
		$this->view('', $data);
	}

	public function swapLotStatus()
	{
		$this->lotM->swapLotStatus(@$_POST["lot_id"] );
	}

	public function setLotTracking()
	{
		$this->drugM->setLotTracking($_POST["drug_id"], $_POST["status"]);
	}

	public function removeMasterDrugFileByID($id)
	{
		$this->adminRedirect();
		$this->drugM->removeMasterFileByID($id);
		redirect("/admin/master_file");
	}

	public function save_many_drugs()
	{
		$cuser = $this->PaymentRedirect();

		foreach ($_POST["d_name"] as $key => $value)
		{
			$data = array(
				"d_name" => $_POST["d_name"][$key],
				"d_code" => $_POST["d_code"][$key],
				"d_descr" => $_POST["d_descr"][$key],
				"d_size" => $_POST["d_size"][$key],
				"d_manufacturer" => $_POST["d_manufacturer"][$key],
				"d_start" => $_POST["d_start"][$key],
				"d_schedule" => $_POST["d_schedule"][$key],
				"d_barcode" => $_POST["d_barcode"][$key],
				"d_status" => $_POST["d_status"][$key],
				"d_catId" => $_POST["d_catId"][$key]
			);

			$this->drugM->addDrug($data);
		}

		redirect("/drug/");
	}

	public function add_many_drugs()
	{
		$cuser = $this->PaymentRedirect();

		$data = array();

		// get list drugs
		$idList = explode(",", $_POST["drug_list"]);

		// sql safe
		for ($i = 0; $i < count($idList); $i++)
			$idList[$i] = intval($idList[$i]);

		// load drug list
		$data["drugs"] = $this->drugM->getMasterFilesDrugByIdList($idList);
		$data["cats"] = $this->categoryM->getAll($cuser["id"]);

		$this->view("", $data);
	}

	public function add_master_drug($id = '')
	{
		$this->load->library ( 'form_validation' );
		$this->adminRedirect();
		$data = array();
		$pattern = "";

		if(!@empty($_POST))
		{
			if ($id)
			{
				$this->drugM->updateMasterFile($id, $_POST);
				$data['text'] = 'The drug has been successfully edited!';
				$pattern = "success";
			} else {
				$this->drugM->addMasterFile($_POST);
				$data['text'] = 'The drug has been successfully added!';
				$pattern = "success";
			}
		} else {
			if ($id)
			{
				$data["drug"] = $this->drugM->getMasterFileDrugByID($id * 1);
			}
		}

		$this->view($pattern, $data);
	}

	public function getChildrenCategoryJSON($id)
	{
		$r = $this->categoryM->getChildrenCat($id);
		$arr = array();

		foreach ($r as $one)
			array_push($arr, $one);

		echo json_encode($arr);
	}

    public function add_drug($id = '')
	{
        /*
        if(!$this->isLoggedIn()){
            redirect('main/');
        }*/
        $cuser = $this->PaymentRedirect();

        if(!@empty($_POST))
		{
            if ($id == '') { //create
                $id = $this->drugM->addDrug($_POST);
                if ($id)
					$data['text'] = 'Medication Added!';
            } else {
                $drug = $this->drugM->getOneBy('d_id', $id, $cuser['id']);

				if (!@empty($drug))
				{
                    $this->drugM->editDrug($id, $_POST);
                    $data['text'] = 'Medication Changed!';
                }
            }

			if ($_POST['add_new'] == 0)
				$this->view('success', $data);
            else if ($_POST['add_new'] == 1)
				redirect('drug/add_drug');
        } else {
            //$data['cats'] = $this->categoryM->getAll($cuser['id'], 'Active');

			if ($id !== '')
			{
                $data['drug'] = $this->drugM->getOneBy('d_id', $id, $cuser['id']);
				// $data['cats'] = $this->createCategoryTree($data['drug']["d_catId"], $this->categoryM->getAll($cuser['id'], 'Active'));
				$data['cats'] = $this->createCategoryTree($this->categoryM->getDrugCatsArray($id), $this->categoryM->getAll($cuser['id'], 'Active'));

				if (@empty($data['drug']))
					redirect('drug/');
            } else {
				$data['cats'] = $this->createCategoryTree(0, $this->categoryM->getAll($cuser['id'], 'Active'));
			}

			$data["parentCats"] = $this->categoryM->getOnlyMain($cuser['id']);

            $this->view('', $data);
        }
    }

	public function loadDrugCatsJSON()
	{
		$cuser = $this->PaymentRedirect();
		$cats = $this->createCategoryTree(0, $this->categoryM->getAll($cuser['id'], 'Active'));
		echo json_encode($cats);
	}

	public function createCategoryTree($catIds, $cats)
	{
		$catlist = array();

		// first cycle
		foreach ($cats as $cat) {
			$tmp_data = array(
				"id" => intval($cat["c_id"]),
				"text" => $cat["c_name"],
				"state" => array(
					"opened" => false,
					"disabled" => false,
					"selected" => false
				),
				"children" => array()
			);

			//if ($catId == $tmp_data["id"]) $tmp_data["state"]["selected"] = true;
			if ($catIds && in_array($tmp_data["id"], $catIds)) $tmp_data["state"]["selected"] = true;
			if ($cat["c_mainCatId"] == 0) $catlist[$cat["c_id"]] = $tmp_data;
		}

		// second cycle
		foreach ($cats as $cat) {
			$tmp_data = array(
				"id" => intval($cat["c_id"]),
				"text" => $cat["c_name"],
				"state" => array(
					"opened" => false,
					"disabled" => false,
					"selected" => false
				)
			);

			//if ($catId == $tmp_data["id"]) $tmp_data["state"]["selected"] = true;
			if ($catIds && in_array($tmp_data["id"], $catIds)) $tmp_data["state"]["selected"] = true;
			if ($cat["c_mainCatId"] != 0) array_push($catlist[$cat["c_mainCatId"]]["children"], $tmp_data);
		}

		// final cycle

		$ncatlist = array();

		foreach ($catlist as $cat) {
			array_push($ncatlist, $cat);
		}

		return $ncatlist;
	}

    public function search(){
		//echo "cri:".$post['criterion'];
		//break;
        $cuser = $this->PaymentRedirect();
        $data['drugs'] = $this->drugM->search($_POST, $cuser['id']);
        //$data['condition'] = $_POST;
        $this->view('', $data);
    }

    public function get_drugs(){
        $cuser = $this->PaymentRedirect();
        $post['criterion'] = 'd_code';
        $post['value'] = $_POST['ndc'];
        $drugs = $this->drugM->search($post, $cuser['id']);

        header('Content-Type: application/json');

        echo(json_encode($drugs));

    }

    public function get_drug(){//ajax
        $cuser = $this->PaymentRedirect();

        $drug = $this->drugM->getOneBy('d_id', $_POST['d_id'], $cuser['id']);

        header('Content-Type: application/json');

        echo(json_encode($drug));

    }

    public function check_ndc(){
        $cuser = $this->PaymentRedirect();

        if(!@$_GET['d_code'])
            return;
        @$id = $_GET['d_id'];
        header('Content-Type: application/json');

        $drug = $this->drugM->getOneBy('d_code', $_GET['d_code'], $cuser['id']);

        $isAvailable = true;

        if(!@empty($drug)){
            if ($drug['d_id'] !== $id) {
                $isAvailable = false;
            }
        }

        echo json_encode(array(
            'valid' => $isAvailable,
        ));
    }


    public function upload()
	{
        $cuser = $this->PaymentRedirect();

        if (!@empty($_FILES))
		{
            $arr = $this->drugM->upload($_FILES, $cuser['id']);

            if ($arr['answer'] == 'ok')
			{
                if (empty($arr['codes']))
				{
                    $data['text'] = 'File has been successfully uploaded.<br>';
                    $this->view('success', $data);
                } else {
                    $data['text'] = 'Following medications can not be added to the database because of repeating NDC numbers:<br>';
                    foreach ($arr['codes'] as $one) {
                        $data['text'] .= $one.'<br>';
                    }
                    $data['text'] .= 'The other ones have been successfully added.';
                    $this->view('success', $data);
                }
            } else {
                $data['text'] = 'Uploading failed: '.$arr['answer'];
                $this->view('fail', $data);
            }
        } else {
            $this->view();
        }
    }

	public function getMasterFileData($aswho = '')
	{
		$data = $this->drugM->getMasterFileDrugs($aswho, @$_GET["start"] * 1, @$_GET["length"] * 1, @$_GET["search"]["value"]);
		echo json_encode($data);
	}

	public function getJSON()
	{
		$cuser = $this->PaymentRedirect();

		if (@isset($_GET["ids"]))
		{
			$arr = array();
			$r = $this->drugM->getListByIds($cuser['id'], @$_GET["ids"]);

			foreach ($r as $key => $value)
				array_push($arr, $value["d_code"]." - ".$value["d_name"]);

			echo json_encode($arr);
			die("");
		}

		$arr = array();
		$r = $this->drugM->searchAdvanced($cuser['id'], @$_GET["q"]);

		foreach ($r as $key => $value) {
			if (@!isset($_GET["type"])) array_push($arr, $value["d_code"]." - ".$value["d_name"]);
			if (@$_GET["type"] == "drugName") array_push($arr, $value["d_name"]);
			if (@$_GET["type"] == "report") array_push($arr, $value["d_name"]." - ".$value["d_code"]." - ".$value["d_manufacturer"]." - ".$value["d_size"]);
			if (@$_GET["type"] == "full") array_push($arr, $value["d_code"]." - ".$value["d_name"]." - ".$value["d_manufacturer"]." - ".$value["d_size"]);
		}

		echo json_encode($arr);
	}

}