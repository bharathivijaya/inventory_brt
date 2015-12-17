<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		redirect('main/');
	}

    public function checkUsername() {

        @$username = $_GET['username'];
        @$id = $_GET['id'];

        if(!@$username)
            return;

        header('Content-Type: application/json');
        $user = $this->userM->getUserBy('username', $username);

        $isAvailable = true;

        if(!@empty($user)){
            if ($user['id'] !== $id) {
                $isAvailable = false;
            }

        }

        echo json_encode(array(
            'valid' => $isAvailable,
        ));

    }

    public function checkEmail() {

        if(!@$_GET['email'])
            return;

        header('Content-Type: application/json');
        $user = $this->userM->getUserBy('email', $_GET['email']);

        $isAvailable = true;

        //if((!@empty($user)) || ($this->blackmodel->isBlocked($_GET['email']))){
        if(!@empty($user)){
            $isAvailable = false;
        }

        echo json_encode(array(
            'valid' => $isAvailable,
        ));

    }

    public function checkNpi() {

        if(!@$_GET['npi'])
            return;

        header('Content-Type: application/json');

        $user = $this->userM->getUserBy('npi', $_GET['npi']);
        @$id = $_GET['id'];
        $isAvailable = true;

        if(!@empty($user)){
            if ($user['id'] !== $id) {
                $isAvailable = false;
            }

        }

        echo json_encode(array(
            'valid' => $isAvailable,
        ));

    }

    public function register_company($code=''){
        if ($this->isLoggedIn()){
            redirect('user/profile');
        }
        else {
            if ($code == ''){
                if (@empty($_POST)) {
                    redirect('main/');
                }
                else {
                    $cid = $this->userM->addCompany($_POST);
                    if ($cid) {
                        //$this->sendEmail();
                        $code = $this->userM->createCode($cid, $_POST['email']);
                        $link = base_url().'user/register_company/'.$code;

						$headers = 'From: donotreply@myrxpal.com' . "\r\n" .
							'Reply-To: donotreply@myrxpal.com' . "\r\n" .
							"MIME-Version: 1.0\r\n" .
							"Content-Type: text/html; charset=utf-8\r\n" .
							'X-Mailer: PHP/' . phpversion();

						$text_html = "";
						$text_html .= '
							<img src="http://myrxpal.paragraph54.com/images/logo.jpg" /> <br/> <br/>
							<p>Telephone Number</p>: 000 <br/>
							<p>Fax Number</p>: 000 <br/>
							<p>Address</p>: 000 <br/>
							Here will be your disclaimer text <br/>
							<a href="'.$link.'">Confirm your email</a>
						';

						mail($_POST['email'], 'Confirm Your MyRxPal Registration', $text_html, $headers);
						//mail($_POST['email'], 'Registration Confirm', 'Please confirm your registration by following this link: '.$link);

                        $this->view('user/email_sent');
                    }
                    else {
                        $this->view('user/error');
                    }
                }
            }
            else {
                $uid = $this->userM->urlCheck($code);
                if ($uid) {

                    $this->userM->confirmRegistration($uid);
                    $this->view('user/register_success');
                }
                else {
                    $this->view('user/invalid_code');
                }
            }
        }


    }

    public function forgot_password($code=''){
        if ($this->isLoggedIn()){
            redirect('user/profile');
        }
        if ($code == '') {
            if (@!empty($_POST)){
                $usr = $this->userM->getUserBy('email', $_POST['email']);
                if (@!empty($usr)) {
                    $confCode = $this->userM->createCode($usr['id'], $usr['email']);
                    $this->sendEmail($usr['email'], 'forgetpwd', array('#fname#', '#cLink#'), array($usr['first_name'], base_url()."user/forgot_password/".$confCode), 0, "Forgot Password?");
                }
                $this->view('user/fp_email_sent');
            } else {
                $this->view();
            }
        }
        else {
            $uid = $this->userM->urlCheck($code);
            if ($uid) {
                if (@empty($_POST)){
                    $this->view('user/newpassword');
                }
                else {
                    $this->userM->changePassword($uid, $_POST['password']);
                    $this->view('user/newpasswordconfirm');
                }
            }
            else {
                $this->view('user/invalid_code');

            }

        }


    }

    public function forgot_username(){
        if ($this->isLoggedIn()){
            redirect('user/profile');
        }

        if (@!empty($_POST)){
            $usr = $this->userM->getUserBy('email', $_POST['email']);
            if (@!empty($usr)) {
                $this->sendEmail($usr['email'], 'forget_username', array('#fname#', '#username#'), array($usr['first_name'], $usr['username']), 0, "Forgot Username?");
            }
            $this->view('user/fu_email_sent');
        } else {
            $this->view();
        }
    }

    public function login(){
        if (!$this->isLoggedIn()){
            if (@empty($_POST)){
                //$this->view();
                redirect('main/');
            }
            else {
                $ok = $this->userM->login($_POST['username'], $_POST['password']);
                if ($ok) {
                    $user = $this->userM->getUserBy('username', $_POST['username']);
                    $data = array(
                        'id' => $user['id'],
                        'username' => $_POST['username'],
                        'type' => $user['type'],
                    );
                    $this->session->set_userdata($data);
                    $data['banner']= $this->userM->getLoginBanner();
                    if (!empty($data['banner'])) {

                        $this->view('user/banner', $data);
                    }
                    else {
                        if ($this->session->userdata('type') == 'admin') {
                            redirect('admin/');
                        }
                        else {
                            redirect('user/profile');
                        }
                    }

                }
                else {
                    if (($this->session->userdata('type') == 'admin') || ($this->session->userdata('type') == 'super')) {
                        redirect('admin/');
                    }
                    else {
                        redirect('user/profile');
                    }
                }
            }
        }
        else {
                redirect('user/profile');
        }
    }

    public function logout(){
        $this->session->sess_destroy();
        redirect('main/');
    }

    public function profile(){
        if (!$this->isLoggedIn()){
            redirect('main/');
        }
        $data['user'] = $this->userM->getUserBy('id', $this->session->userdata('id'));
        if ($data['user']['type'] == 'company'){
            $this->view('', $data);
        }
        else {
            $this->view('user/view_user', $data);
        }

    }

    public function change_password(){
        if(!$this->isLoggedIn()){
            redirect('main/');
        }
        if(@empty($_POST)){
            $this->view();
        }
        else {
            $id = $this->session->userdata('id');
            $ok = $this->userM->checkPassword($id, $_POST['old_password']);
            if ($ok) {
                $this->userM->changePassword($id, $_POST['password']);
                redirect('user/profile');
            }
            else {
                $this->view('user/error');
            }

        }
    }

    public function change_email($code=''){
        if(!$this->isLoggedIn()){
            redirect('main/');
        }
        if ($code == '') {
            if (!empty($_POST)) {

                $usr = $this->userM->getUserBy('id', $this->session->userdata('id'));
                $confCode = $this->userM->createCode($usr['id'], $_POST['email']);
                $this->session->set_userdata('new_email', $_POST['email']);
                $this->sendEmail($_POST['email'], 'resetemail', array('#fname#', '#cLink#'), array($usr['first_name'], base_url()."user/change_email/".$confCode), 0, "Email change");
                $this->view('user/email_sent');
            }
            else {
                $this->view('');
            }
        }
        else {
            $id = $this->userM->urlCheck($code);
            if ($id){
                //email update?
                //print($this->session->userdata('new_email'));
                $this->userM->changeEmail($id, $this->session->userdata('new_email'));
                $this->session->unset_userdata('new_email');
                $this->view('user/email_changed');
            }
            else {
                $this->view('user/invalid_code');

            }
        }
    }

    public function edit_profile(){
        if(!$this->isLoggedIn()){
            redirect('main/');
        }
        $id = $this->session->userdata('id');
        $data['user'] = $this->userM->getUserBy('id', $id);
        if ($data['user']['type'] !== 'company'){
            redirect('main/');
        }
        if (@empty($_POST)){
            $this->view('', $data);
        }
        else {
            $this->userM->editUser($id, $_POST);
            redirect('user/profile');
        }

    }

    public function add_user($uid=''){
        if(!$this->isLoggedIn()){
            redirect('main/');
        }
        $cid = $this->session->userdata('id');
        $data['cuser'] = $this->userM->getUserBy('id', $cid);
        if ($data['cuser']['type'] !== 'company'){
            redirect('main/');
        }
        if ($uid == ''){//creation
            $data['user'] = array();
            if (!@empty($_POST)){
                $this->userM->createUser($cid, $_POST);
                redirect('user/my_users');
            }
            else {
                $this->view('', $data);
            }
        }
        else {
            $data['user'] = $this->userM->getUserBy('id', $uid);
            if ($data['user']['parent_id'] !== $cid){
                redirect('user/my_users');
            }
            if (!@empty($_POST)){
                $this->userM->editUser($uid, $_POST);
                redirect('user/my_users');
            }
            else {
                $this->view('', $data);
            }
        }
    }

    public function delete_user($uid){
        if(!$this->isLoggedIn()){
            redirect('main/');
        }
        $cid = $this->session->userdata('id');
        $user = $this->userM->getUserBy('id', $uid);
        if ($user['parent_id'] == $cid) {
            $this->userM->changeStatus($uid, 'deleted');
        }
        redirect('user/my_users');
    }

    public function my_users(){
        if(!$this->isLoggedIn()){
            redirect('main/');
        }
        $cid = $this->session->userdata('id');
        $data['user'] = $this->userM->getUserBy('id', $cid);
        if ($data['user']['type'] !== 'company'){
            redirect('main/');
        }
        $data['users'] = $this->userM->getSubUsers($cid);
        $this->view('', $data);
    }
    public function view_user($uid){
        if(!$this->isLoggedIn()){
            redirect('main/');
        }

        $cid = $this->session->userdata('id');
        $type = $this->session->userdata('type');
        /*$cuser = $this->userM->getUserBy('id', $cid);
        if ($cuser['type'] == 'user'){
            redirect('user/profile');
        }*/
        if ($type  == 'user'){
            redirect('user/profile');
        }
        $user = $this->userM->getUserBy('id', $uid);
        if ($type == 'company') {
            if ($user['parent_id'] !== $cid) {
                redirect('user/my_users');
            }
        }
        $data['user'] = $user;
        $this->view('', $data);
    }

    function subscription(){
        if(!$this->isLoggedIn()){
            redirect('main/');
        }
        $data['cid'] = $this->session->userdata('id');
        $cuser = $this->userM->getUserBy('id', $data['cid']);
        if ($cuser['type'] !== 'company'){
            redirect('user/profile');
        }
        $data['payment_expiry'] = $cuser['payment_expiry'];
        $this->view('', $data);
    }
    function my_transactions(){
        if(!$this->isLoggedIn()){
            redirect('main/');
        }
        $cid = $this->session->userdata('id');
        /*$cuser = $this->userM->getUserBy('id', $cid);
        if ($cuser['type'] == 'user'){
            redirect('user/profile');
        }*/
        if ($this->session->userdata('type') == 'user'){
            redirect('user/profile');
        }
        $data['payments'] = $this->userM->getTransactions($cid);
        $this->view('', $data);
    }



    function paypal($term = 'month'){
        if(!$this->isLoggedIn()){
            redirect('main/');
        }
        $cid = $this->session->userdata('id');
        $cuser = $this->userM->getUserBy('id', $cid);
        if ($cuser['type'] == 'user'){
            redirect('user/profile');
        }
        if ($term == 'month'){
            $amount = 9.99;
            $descr = 'Month subscription';
        }
        else {
            $amount = 99.99;
            $descr = 'Annual subscription';
        }
        $this->load->library('merchant');
        $this->merchant->load('paypal_express');

        $settings = array(
            'username' => 'payments_api1.myrxpal.com',
            'password' => 'PF8V254JQ8NG3CRW',
            'signature' => 'AU--Gl3yLXHSH.sSt2OoOhEuduHgAbOcl7tSjsY3aYYjHIUN6itW1wIF',
            'test_mode' => false);

        /*        $settings = array(
            'username' => 'kandryukovatB_api1.gmail.com',
            'password' => 'F7BSG6ZHTUSTVYZC',
            'signature' => 'Ax4mKIJNN5m6SV5VvWvcyRU5QqD2Az.zI1KBONHbUYwgxDWCDWM7LFlI',
            'test_mode' => true);*/

        $this->merchant->initialize($settings);


        $params = array(
            'description' => $descr,
            'amount' => $amount,
            'currency' => 'USD',
            'return_url' => base_url().'user/payment_return/'.$term,
            'cancel_url' => base_url().'user/payment_cancelled');

        $this->merchant->purchase($params);

    }

    function payment_return($term = 'month'){
        if(!$this->isLoggedIn()){
            redirect('main/');
        }
        $cid = $this->session->userdata('id');
        $cuser = $this->userM->getUserBy('id', $cid);
        if ($cuser['type'] == 'user'){
            redirect('user/profile');
        }
        if ($term == 'month'){
            $amount = 9.99;
            //$descr = 'Month subscription';
        }
        else {
            $amount = 99.99;
            //$descr = 'Annual subscription';
        }
        $this->load->library('merchant');
        $this->merchant->load('paypal_express');

        $settings = array(
            'username' => 'payments_api1.myrxpal.com',
            'password' => 'PF8V254JQ8NG3CRW',
            'signature' => 'AU--Gl3yLXHSH.sSt2OoOhEuduHgAbOcl7tSjsY3aYYjHIUN6itW1wIF',
            'test_mode' => false);

        $params = array(
            'amount' => $amount,
            'currency' => 'USD');

        $this->merchant->initialize($settings);
        $response = $this->merchant->purchase_return($params);

        if ($response->success())
        {
            // mark order as complete
            $this->userM->updateSubscription($cid, $term, $amount);
            $this->view('user/payment_success');
        }
        else
        {
            $message = $response->message();
            echo('Error processing payment: ' . $message);
            exit;
        }

    }

    function payment_cancelled(){
        if(!$this->isLoggedIn()){
            redirect('main/');
        }/*
        $cid = $this->session->userdata('id');
        $cuser = $this->userM->getUserBy('id', $cid);
        if ($cuser['type'] == 'user'){
            redirect('user/profile');
        }*/
        if ($this->session->userdata('type') == 'user'){
            redirect('user/profile');
        }
        $this->view();
    }
}
