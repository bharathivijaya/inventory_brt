<?php
/**
 * Created by PhpStorm.
 * User: Tan4ik
 * Date: 23.03.15
 * Time: 14:21
 */
class userM extends CI_Model {

    var $table   = 'user';

    public function getUserBy($field, $value){
        $w = array($field => $value);
        $this->db->where($w);
        $q = $this->db->get($this->table);
        if ($q->num_rows()) {
            $res = $q->result_array();
            return $res[0];
        }
        else {
            return array();
        }

    }

	public function setOnline()
	{
		@session_start();

		if (!isset($_SESSION["i_was_visited"]))
		{
			$q = $this->db->query("SELECT * FROM visits WHERE created=?", array(date("Y-m-d")));

			if ($q->num_rows() > 0) $this->db->query("UPDATE visits SET visits=visits+1 WHERE created=?", array(date("Y-m-d")));
			else $this->db->query("INSERT INTO visits SET visits=1, created=?", array(date("Y-m-d")));

			$_SESSION["i_was_visited"] = true;
		}

		$user_id = $this->session->userdata('id');

		if (isset($user_id)) {
			$this->db->query("UPDATE user SET online_status = 'Online', online_last = ? WHERE id=?", array(time(), $user_id));
			$this->db->query("UPDATE user SET online_status = 'Offline' WHERE online_last + 600 < ?", array(time()));
		}
	}

	public function getVisitStatistic($from, $to)
	{
		$q = $this->db->query("SELECT SUM(visits) FROM visits WHERE created>=? and created<=?", array($from, $to));
		$res = $q->result_array();
		return $res[0]["SUM(visits)"];
	}

	public function getOnlineUsers()
	{
		$q = $this->db->query("SELECT COUNT(*) FROM user WHERE online_status='Online'", array());
		$res = $q->result_array();
		return $res[0]["COUNT(*)"];
	}

    public function addCompany($post, $status = 'new')
    {
        $data = array(
            'cname' => $post['cname'],
            'first_name' => $post['first_name'],
            'last_name' => $post['last_name'],
            'email' => $post['email'],
            'username' => $post['username'],
            'password' => md5($post['password']),
            'npi' => $post['npi'],
            'type' => 'company',
            'status' => $status,
            'date_registered' => time()
        );

        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function confirmRegistration($id)
    {

        $data = array(
            'status' => 'email_confirmed'
        );
        $this->db->where('id', $id);
        $this->db->update($this->table, $data);

    }

    public function createCode($id, $email){
        $code = md5(time().microtime().$email);
        $data = array(
            'code' => $code
        );
        $this->db->where('id', $id);
        $this->db->update($this->table, $data);

        return $code;
    }

    public function urlCheck($code){
        $w = array(
            'code' => $code
        );
        $this->db->where($w);
        $q = $this->db->get($this->table);
        $res = $q->result_array();
        if (!empty($res)){
            return $res[0]['id'];
        } else {
            return false;
        }
    }

    public function login($login, $pass){
        if (!empty($login) && !empty($pass)) {

            $w = array(
                'username' => $login,
                'password' => md5($pass),
            );
            $this->db->where($w);
            $q = $this->db->get($this->table);
            $res = $q->result_array();
            if(!empty($res)){
                $user = $res[0];
                if ($user['type'] == 'user'){
                    if ($user['status'] == 'deleted'){
                        return false;
                    }
                    else {
                        return true;
                    }
                }
                else if ($user['type'] == 'company'){
                    if (($user['status'] == 'deleted') || ($user['status'] == 'new')){
                        return false;
                    }
                    else {
                        return true;
                    }
                }
                else {//admin
                    if ($user['status'] == 'deleted'){
                        return false;
                    }
                    else {
                        return true;
                    }
                }

            }

        } else {
            return false;
        }

    }

    public function changePassword($uid, $password){
        $data = array(
            'password' => md5($password),
        );
        $this->db->where('id', $uid);
        $q = $this->db->update($this->table, $data);

    }

    public function checkPassword($id, $pass){
        $user = $this->getUserBy('id', $id);
        if ($user['password'] == md5($pass)){
            return true;
        }
        else {
            return false;
        }
    }

    public function changeEmail($id, $email){
        $data = array(
            'email' => $email,
        );
        $this->db->where('id', $id);
        $this->db->update($this->table, $data);

    }

    public function editUser($id, $post){
        $data = $post;
        $data['date_registered'] = strtotime($post['date_registered']);
        if (@$data['license_expiry']){
            $data['license_expiry'] =  strtotime($post['license_expiry']);
        }
        $this->db->where('id', $id);
        $this->db->update($this->table, $data);
    }

    public function createUser($cid, $post){
        $data = array(
            'first_name' => $post['first_name'],
            'last_name' => $post['last_name'],
            'role' => $post['role'],
            'license_number' => $post['license_number'],
            'license_expiry' => strtotime($post['license_expiry']),
            'username' => $post['username'],
            'email' => $post['email'],
            'password' => md5($post['password']),
            'reports' => $post['reports'],
            'type' => 'user',
            'parent_id' => $cid
        );
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }
/*
    public function deleteUser($id){
        $data = array(
            'status' => 'deleted'
        );
        $this->db->where('id', $id);
        $this->db->update($this->table, $data);
    }
*/
    public function changeStatus($id, $status) {
        $data = array(
            'status' => $status
        );
        $this->db->where('id', $id);
        $this->db->update($this->table, $data);
    }

    public function getSubUsers($cid){
        /*$w = array(
            //'type' => 'user',
            'parent_id' => $cid
        );
        $this->db->where($w);
        $q = $this->db->get($this->table);*/
        $q = $this->db->query(
            "SELECT * from `user` WHERE parent_id = ? AND status != ?", array($cid, 'deleted')
        );
        $res = $q->result_array();
        return $res;
    }
/*
    public function updateSubscription($cid, $term, $amount){
        if ($term == 'month'){
            $num = 1;
        }
        else {
            $num = 12;
        }
        $data = array(
            'payment_expiry' => time()+30*86400*$num
        );
        $this->db->where('id', $cid);
        $this->db->update($this->table, $data);
        $data2 = array(
            'p_userId' => $cid,
            'p_amount' => $amount,
            'p_date' => time()
        );
        $this->db->insert('payment', $data2);
    }
*/
    public function subscribe($cid, $subscr_id, $type) {
        $data = array(
            'payment_expiry' => $type,
            'subscr_id' => $subscr_id
        );
        $this->db->where('id', $cid);
        $this->db->update($this->table, $data);

        if ($type == 1) {
            $p_type = 'Annual';
        }
        else if ($type == 2) {
            $p_type = 'Monthly';
        }
        $data2 = array(
            'p_userId' => $cid,
            'p_amount' => 0.00,
            'p_type'  => $p_type,
            'p_date' => time()
        );
        $this->db->insert('payment', $data2);

    }
    public function unsubscribe($subscr_id) {
        $data = array(
            'payment_expiry' => 0
        );
        $this->db->where('subscr_id', $subscr_id);
        $this->db->update($this->table, $data);
        /*
        $data2 = array(
            'p_userId' => $cid,
            'p_amount' => $amount,
            'p_date' => time()
        );
        $this->db->insert('payment', $data2);
        */
    }

    public function getTransactions($cid){
        $this->db->where('p_userId', $cid);
        $q = $this->db->get('payment');
        if ($q->num_rows() > 0){
            $res = $q->result_array();
        }
        else {
            $res =  array();
        }
        return $res;

    }

    public function getCompanies(){
        $this->db->where(array('type' => 'company'));
        $q = $this->db->get($this->table);
        return $q->result_array();
    }

    public function getLoginBanner() {
        $w = array(
            'b_location' => 'login',
            'b_status' => 'Active'
        );
        $this->db->where($w);
        $q = $this->db->get('banner');
        if ($q->num_rows() > 0){
            $res = $q->result_array();
            $banner = $res[0];
            if ($banner['b_layout'] == 'large') {
                $banner['size']['w'] = 720;
                $banner['size']['h'] = 300;
            }
            else if ($banner['b_layout'] == 'half') {
                $banner['size']['w'] = 300;
                $banner['size']['h'] = 600;
            }
            else if ($banner['b_layout'] == 'popup') {
                $banner['size']['w'] = 500;
                $banner['size']['h'] = 350;
            }
        }
        else {
            $banner =  array();
        }
        return $banner;
    }
}