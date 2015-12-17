<?php
	class alertM extends CI_Model
	{
		public function addAsInventory($alertId, $alertStatus, $reorderPoint, $drugList, $expAlert, $expAlertDays, $dontAllowDays, $compId)
		{
			if ($alertId == 0) {
				$this->db->query(
					"INSERT INTO alerts SET alertType='Inventory', alertStatus=?, reOrderQty=?, drugList=?, productExpirationAlert=?, daysBeforeProductExpires=?, dontAllowUseDays=?, compId=?",
					array($alertStatus, $reorderPoint, $drugList, $expAlert, $expAlertDays, $dontAllowDays, $compId)
				);
			} else {
				$this->db->query(
					"UPDATE alerts SET alertStatus=?, reOrderQty=?, drugList=?, productExpirationAlert=?, daysBeforeProductExpires=?, dontAllowUseDays=? WHERE compId=? and alertType='Inventory' and id=?",
					array($alertStatus, $reorderPoint, $drugList, $expAlert, $expAlertDays, $dontAllowDays, $compId, $alertId)
				);
			}
		}

		public function addAsAudit($alertId, $alertStatus, $startDate, $endDate, $freq, $drugList, $force, $reschedule, $isNegative, $less, $greater, $quanLimit, $audittime, $compId)
		{
			$last_insert_id = '';
			
			if (isset($isNegative)) $isNegative = "On";
			else $isNegative = "Off";

			if (isset($quanLimit)) $quanLimit = "On";
			else $quanLimit = "Off";

			if ($alertId == 0) {
				$q = $this->db->query(
					"INSERT INTO alerts SET alertType='Audit', alertStatus=?, auditStartDate=?, auditEndDate=?, auditFrequency=?, drugList=?, forceAudit=?, rescheduleAuditAfterLastAudit=?, negativeInventory=?, lessThan=?, greaterThan=?, quantityLimit=?, auditTime=?, compId=?",
					array(
						//strtotime($startDate),
						$alertStatus,
						strtotime($startDate),
						strtotime($endDate),
						intval($freq),
						$drugList,
						$force,
						$reschedule,
						$isNegative,
						$less,
						$greater,
						$quanLimit,
						$audittime,
						$compId
					)
				);

				// add alert audit options
				$currentAlertId = $this->db->insert_id();
				$last_insert_id = $currentAlertId;
				$drugs = explode(",", $drugList);
				for ($i = 0; $i < count($drugs); $i++)
				{
				    $this->db->query("INSERT INTO alert_audit_drugs SET alert_id=?, drug_id=?, start_audit=?", array(
						$currentAlertId,
						intval($drugs[$i]),
						strtotime($startDate)
					));
				}
				return $last_insert_id;
			} else {
				/* get previous date */
				$q = $this->db->query("SELECT * FROM alerts WHERE id=?", array($alertId));
				$r = $q->result_array();

				/* update alert */
				$this->db->query(
					"UPDATE alerts SET alertStatus=?, auditStartDate=?, auditEndDate=?, auditFrequency=?, drugList=?, forceAudit=?, rescheduleAuditAfterLastAudit=?, negativeInventory=?, lessThan=?, greaterThan=?, quantityLimit=?, auditTime=? WHERE alertType='Audit' and compId=? and id=?",
					array(
						$alertStatus,
						strtotime($startDate),
						strtotime($endDate),
						intval($freq),
						$drugList,
						$force,
						$reschedule,
						$isNegative,
						$less,
						$greater,
						$quanLimit,
						$audittime,
						$compId,
						$alertId
					)
				);

				/* the date has been changed */
				if (strtotime($startDate) != $r[0]["auditStartDate"])
					$this->db->query("UPDATE alert_audit_drugs SET start_audit=?, last_audit=0 WHERE alert_id=?", array(strtotime($startDate), $alertId));

				/* update alert-drugs option */
				$drugs = explode(",", $drugList);
				for ($i = 0; $i < count($drugs); $i++) $drugs[$i] = intval($drugs[$i]);
				$this->db->query("DELETE FROM alert_audit_drugs WHERE alert_id=? and drug_id NOT IN (".implode(",", $drugs).")", array($alertId));

				$q = $this->db->query("SELECT * FROM alert_audit_drugs WHERE alert_id=?", array($alertId));
				$indb_drug = array();
				foreach ($q->result_array() as $drug) array_push($indb_drug, $drug["drug_id"]);

				for ($i = 0; $i < count($drugs); $i++)
				{
				    if (!in_array($drugs[$i], $indb_drug))
					{
						$this->db->query("INSERT INTO alert_audit_drugs SET alert_id=?, drug_id=?, start_audit=?", array(
							$alertId,
							intval($drugs[$i]),
							strtotime($startDate)
						));
					}
				}
				/* ------------- */
			}
		}

		public function getById($alertId)
		{
			$q = $this->db->query("SELECT * FROM alerts WHERE id=?", array($alertId));
			$res = $q->result_array();
			return $res[0];
		}

		public function getHistoryByDrugId($drugId)
		{
			$q = $this->db->query("
				SELECT alert_history.*, alerts.alertType, alerts.id as alert_id, alerts.reOrderQty
				FROM alert_history, alerts
				WHERE drug_id=? and alert_history.alert_id=alerts.id",
				array($drugId)
			);

			return $q->result_array();
		}
		public function delete_alert($alert_id, $customer_id) {
			$this->db->where ( 'id', $alert_id );
			$this->db->where ( 'compId', $customer_id );
			$this->db->limit ( 1 );
			$this->db->delete ( 'alerts' );
		}
		public function delete_from_alert_tmp($alert_id) {
			$this->db->where ( 'alert_id', $alert_id );
			$this->db->delete ( 'alert_tmp' );
		}
		public function delete_from_alert_history($alert_id) {
			$this->db->where ( 'alert_id', $alert_id );
			$this->db->delete ( 'alert_history' );
		}
		public function delete_from_alert_audit_drugs($alert_id) {
			$this->db->where ( 'alert_id', $alert_id );
			$this->db->delete ( 'alert_audit_drugs' );
		}
		public function delete_from_alert_drugs($alert_id) {
			$this->db->where ( 'alert_id', $alert_id );
			$this->db->delete ( 'alert_drugs' );
		}
		public function get_alert_data($alert_id) {
			$this->db->select ( '*' );
			$this->db->from ( 'alerts' );
			$this->db->where ( 'id', $alert_id );
			$query = $this->db->get ();
			return $query->result ();
		}
		public function check_drug_exist_on_alerts($drug_id, $alert_type, $customer_id, $alert_id = '') {
			$this->db->from ( 'alerts' );
			$this->db->where ( " FIND_IN_SET('" . $drug_id . "', `drugList`) ", '', FALSE );
			$this->db->where ( 'alertType', $alert_type );
			$this->db->where ( 'compId', $customer_id );
			if ($alert_id != '') { // Edit
				$this->db->where ( 'id !=', $alert_id );
			}
			
			return $this->db->count_all_results ();
		}
		public function get_my_drug_name_by_id($drug_id) {
			$this->db->select ( 'd_name' );
			$this->db->from ( 'drug' );
			$this->db->where ( 'd_id', $drug_id );
			$query = $this->db->get ();
			
			$results = $query->result ();
			$drug_name = "";
			foreach ( $results as $result ) {
				$drug_name = $result->d_name;
			}
			
			return $drug_name;
		}
		public function add_alert_drug($alert_id, $drug_id) {
			$data = array (
					'alert_id' => $alert_id,
					'drug_id' => $drug_id 
			);
			
			$this->db->insert ( 'alert_drugs', $data );
		}
		
		public function get_user_alert_list($user_id) {
			//  SELECT * FROM alerts LEFT JOIN `alert_drugs` ON `alert_drugs`.`alert_id` = `alerts`.`id` WHERE alerts.compId = '19' ;			
			$this->db->select ( '*' );
			$this->db->where ( 'alerts.compId', $user_id );
			$this->db->join ( 'alert_drugs', 'alert_drugs.alert_id = alerts.id', 'left' );
			$this->db->from ( 'alerts' );
			$query = $this->db->get ();
			return $query->result ();
		}
		
		public function get_my_drug_details_from_id($drug_id) {
			$this->db->select ( 'd_name,d_code,d_onHand' );
			$this->db->from ( 'drug' );
			$this->db->where ( 'd_id', $drug_id );
			$query = $this->db->get ();
			return $query->result ();
		}
		
		public function get_alert_drug_count($alert_id) {
			$this->db->select ( 'alert_id' );
			$this->db->where ( 'alert_id', $alert_id );
			$this->db->from ( 'alert_drugs' );
			$query = $this->db->get ();
			return $query->num_rows ();
		}
		
		public function delete_alert_drug($alert_id, $drug_id) {
			$this->db->where ( 'alert_id', $alert_id );
			$this->db->where ( 'drug_id', $drug_id );
			$this->db->delete ( 'alert_drugs' );
		}
		
		public function get_alert_drug_list($alert_id) {
			$this->db->select ( 'drug_id' );
			$this->db->where ( 'alert_id', $alert_id );
			$this->db->from ( 'alert_drugs' );
			$query = $this->db->get ();
			return $query->result ();
		}
		
		public function update_alert_drug_string($alert_id, $list_string) {
			$data = array ('drugList' => $list_string);			
		
			$this->db->where ( 'id', $alert_id );
			$this->db->update ( 'alerts', $data );
		}
	}
?>