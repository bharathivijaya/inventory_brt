<?php
	if (!defined('BASEPATH')) exit('No direct script access allowed');

	class Alert extends CI_Controller
	{
		public function index()
		{
			$this->load->model ( 'alertm', '', TRUE );
			//$this->output->enable_profiler ( TRUE );
            $cuser = $this->PaymentRedirect();
			$user = $this->userM->getUserBy('id', $this->session->userdata("id"));
			if ($user["alerts"] == "Off") redirect("/logbook/dashboard");

			$data = array();

			$data['alerts'] = $this->logbookM->getAlerts($cuser['id']);
			$data['alert_list'] = $this->alertm->get_user_alert_list($cuser['id']);
			$this->view('', $data);
		}

		public function edit($id)
		{
			//$this->output->enable_profiler ( TRUE );
			
			$user = $this->userM->getUserBy('id', $this->session->userdata("id"));
			if ($user["alerts"] == "Off") redirect("/logbook/dashboard");

			$data = array();
			$cuser = $this->PaymentRedirect();
			$data["alert"] = $this->alertM->getById(intval($id));
			$data["drugs_list"] = $this->drugM->getAllShortInfo($cuser["id"]);
			$form_errors = '';
			
			if (@$_POST)
			{
				// -------- Check drug excist on another alert with same type -----------
				
				if ($_POST["alertRealType"] == "Inventory") {
					$selected_drugs = $this->input->post ( 'productListInventory' );
				}else if ($_POST["alertRealType"] == "Audit") {
					$selected_drugs = $this->input->post ( 'productListInventoryAudit' );
				}
				
				$selected_array = explode ( ',', $selected_drugs );
				$this->load->model ( 'alertm', '', TRUE );
					
				foreach ( $selected_array as $drug_id ) {
					$drug_count = $this->alertm->check_drug_exist_on_alerts ( $drug_id, $this->input->post ( 'alertRealType' ), $this->session->userdata ( "id" ), $id ) ;
					if ($drug_count > 0) {
						$drug_name = $this->alertm->get_my_drug_name_by_id ( $drug_id );
						$form_errors .= "Drug '".$drug_name."' already added to another same type alert<br/>";
					}
				}
				if ($form_errors == '') {
					if ($_POST["alertRealType"] == "Inventory")
						$this->alertM->addAsInventory(intval($_POST["alertRealId"]), intval($_POST["alertStatus"]), intval($_POST["reoderQtyPoint"]), $_POST["productListInventory"], $_POST["productExpirationAlert"], intval($_POST["auditExpirationAlertSettings"]), intval($_POST["dontAllowUseDays"]), $cuser["id"]);
	
					if ($_POST["alertRealType"] == "Audit")
						$this->alertM->addAsAudit(intval($_POST["alertRealId"]), intval($_POST["alertStatus"]), @$_POST["auditStartDate"], @$_POST["auditEndDate"],
							@$_POST["auditFrequency"], @$_POST["productListInventoryAudit"], @$_POST["auditForce"], @$_POST["auditReschedule"],
							@$_POST["auditNegativeInventory"], @$_POST["lessThen"] * 1, @$_POST["greaterThen"] * 1, @$_POST["quantityLimit"], @$_POST["auditTime"], $cuser["id"]);
	
					$this->alertm->delete_from_alert_drugs($id);
					foreach ( $selected_array as $drug_id ) {						
						$this->alertm->add_alert_drug($id, $drug_id);
					}
					
					
					redirect("/alert/");
				}
			}

			$data ['form_errors'] = $form_errors;
			$this->view('alert/add', $data);
			
			/*$this->load->library ( 'form_validation' );
			$this->load->model ( 'alertm', '', TRUE );
			$this->load->model ( 'drugm', '', TRUE );
			
			if ($this->input->post ( 'save' )) {
				$this->form_validation->set_rules ( 'movie_name', 'Movie Name', 'trim|required' );
				if ($this->form_validation->run ()) {
					
				}
			}
			
			$data["alert_data"] = $this->alertM->get_alert_data($id);			
			$data["drugs_list"] = $this->drugM->getAllShortInfo($this->session->userdata("id"));			
			$this->view('alert/edit_alert', $data);*/
		}

		public function add()
		{
			//$this->output->enable_profiler ( TRUE );
			$user = $this->userM->getUserBy('id', $this->session->userdata("id"));
			if ($user["alerts"] == "Off") redirect("/logbook/dashboard");

			$data = array();
			$cuser = $this->PaymentRedirect();
			$data["drugs_list"] = $this->drugM->getAllShortInfo($cuser["id"]);
			
			$form_errors = "";

			if (@$_POST)
				{
					// -------- Check drug excist on another alert with same type -----------
					if ($_POST["alertRealType"] == "Inventory") {
						$selected_drugs = $this->input->post ( 'productListInventory' );
					}else if ($_POST["alertRealType"] == "Audit") {
						$selected_drugs = $this->input->post ( 'productListInventoryAudit' );
					}					
					
					$selected_array = explode ( ',', $selected_drugs );
					$this->load->model ( 'alertm', '', TRUE );
					
					foreach ( $selected_array as $drug_id ) {
						$drug_count = $this->alertm->check_drug_exist_on_alerts ( $drug_id, $this->input->post ( 'alertRealType' ), $this->session->userdata ( "id" ) ) ;
						if ($drug_count > 0) {
							$drug_name = $this->alertm->get_my_drug_name_by_id ( $drug_id );
							$form_errors .= "Drug '".$drug_name."' already added to another same type alert.<br/>";
						}
					}
					
					if ($form_errors == '') {
						if ($_POST["alertRealType"] == "Inventory")
							$this->alertM->addAsInventory(intval($_POST["alertRealId"]), intval($_POST["alertStatus"]), intval($_POST["reoderQtyPoint"]), $_POST["productListInventory"], $_POST["productExpirationAlert"], intval($_POST["auditExpirationAlertSettings"]), intval($_POST["dontAllowUseDays"]), $cuser["id"]);
							$alert_id = $this->db->insert_id();
						if ($_POST["alertRealType"] == "Audit")
							$alert_id = $this->alertM->addAsAudit(intval($_POST["alertRealId"]), intval($_POST["alertStatus"]), @$_POST["auditStartDate"], @$_POST["auditEndDate"],
									@$_POST["auditFrequency"], @$_POST["productListInventoryAudit"], @$_POST["auditForce"], @$_POST["auditReschedule"],
									@$_POST["auditNegativeInventory"], @$_POST["lessThen"] * 1, @$_POST["greaterThen"] * 1, @$_POST["quantityLimit"], @$_POST["auditTime"], $cuser["id"]);
						
						foreach ( $selected_array as $drug_id ) {
							$this->alertm->add_alert_drug($alert_id, $drug_id);
						}
						
						
						if (@$_POST["save_new"]) redirect("/alert/add");
						if (@$_POST["save_success"]) redirect("/alert");
					}					

			}

			$data ['form_errors'] = $form_errors;
			
			$this->view('', $data);
		}
		
		public function delete($alert_id = '', $drug_id ='') {
			$this->load->model ( 'alertm', '', TRUE );
			
			//
			$drug_count = $this->alertm->get_alert_drug_count($alert_id);
			if ($drug_count == 1) {
				$this->alertm->delete_alert($alert_id, $this->session->userdata("id"));
				
				if ($this->db->affected_rows() == '1') {
					$this->alertm->delete_from_alert_tmp($alert_id);
					$this->alertm->delete_from_alert_history($alert_id);
					$this->alertm->delete_from_alert_audit_drugs($alert_id);
					$this->alertm->delete_from_alert_drugs($alert_id);
				}
			}else
			{
				$this->alertm->delete_alert_drug($alert_id, $drug_id);
				$drug_list = $this->alertm->get_alert_drug_list($alert_id);
				
				$dlist = '';
				foreach ($drug_list as $drug) {
					$dlist .= $drug->drug_id.",";
				}
				
				$dlist = rtrim($dlist, ",");		
				 $this->alertm->update_alert_drug_string($alert_id, $dlist);
				
			}
			
			
			
			$this->session->set_flashdata ( 'success', 'Alert deleted successfully.' );
			redirect ( base_url () . 'alert' );
		}
	}
?>