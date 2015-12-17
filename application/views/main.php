<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller {

    public function index()
    {
        if ($this->isLoggedIn()) {
            $user = $this->userM->getUserBy('id', $this->session->userdata('id'));
            if ($user['type'] == 'user'){
                $cuser = $this->userM->getUserBy('id', $user['parent_id']);
            } else if($user['type'] == 'company'){
                $cuser = $user;
            }
            if ($cuser['payment_expiry'] > time()){
                redirect('logbook/dashboard');
            }
            else {
                redirect('user/subscription');
            }

        }
        $this->view();
    }

    function paypalTest(){
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, 'http://myrxpal.com/main/subtest');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_decode('{"amount1":"0.00","amount3":"9.99","address_status":"confirmed","subscr_date":"10:17:00 Jun 05, 2015 PDT","payer_id":"MJG88EHUTHY5L","address_street":"5003 Ritchie Highway","mc_amount1":"0.00","mc_amount3":"9.99","charset":"windows-1252","address_zip":"21225","first_name":"Ajay","reattempt":"1","address_country_code":"US","address_name":"Ajay Khanna","notify_version":"3.8","subscr_id":"I-XGM0L72MHP9T","custom":"30","payer_status":"verified","business":"payments@myrxpal.com","address_country":"United States","address_city":"Brooklyn","verify_sign":"A2UvLyyTiDSSYReNtyr0qyDet6JRAqXVObnLGzMd3VldD5dfiZbg4cnr","payer_email":"ajaykhannarx@gmail.com","btn_id":"96274524","last_name":"Khanna","address_state":"MD","receiver_email":"payments@myrxpal.com","recurring":"1","txn_type":"subscr_signup","item_name":"FREE Trial for 90 Days Then $9.99 a month","mc_currency":"USD","item_number":"Free90Monthly","residence_country":"US","period1":"3 M","period3":"1 M","ipn_track_id":"90f4f2bdc1315"}', true));
        $out = curl_exec($curl);
        echo $out;
        curl_close($curl);
    }

    function subtest(){
        require_once "application/libraries/ipnlistener.php";
        $listener = new IpnListener();
        file_put_contents('text.txt', $_POST['custom'].' - subtest - = '.json_encode($_POST)."\r\n---\r\n".json_encode($_GET)."\r\n-----------\r\n", FILE_APPEND);

        //$_POST = $_REQUEST = json_decode('{"amount1":"0.00","amount3":"9.99","address_status":"confirmed","subscr_date":"10:17:00 Jun 05, 2015 PDT","payer_id":"MJG88EHUTHY5L","address_street":"5003 Ritchie Highway","mc_amount1":"0.00","mc_amount3":"9.99","charset":"windows-1252","address_zip":"21225","first_name":"Ajay","reattempt":"1","address_country_code":"US","address_name":"Ajay Khanna","notify_version":"3.8","subscr_id":"I-XGM0L72MHP9T","custom":"30","payer_status":"verified","business":"payments@myrxpal.com","address_country":"United States","address_city":"Brooklyn","verify_sign":"A2UvLyyTiDSSYReNtyr0qyDet6JRAqXVObnLGzMd3VldD5dfiZbg4cnr","payer_email":"ajaykhannarx@gmail.com","btn_id":"96274524","last_name":"Khanna","address_state":"MD","receiver_email":"payments@myrxpal.com","recurring":"1","txn_type":"subscr_signup","item_name":"FREE Trial for 90 Days Then $9.99 a month","mc_currency":"USD","item_number":"Free90Monthly","residence_country":"US","period1":"3 M","period3":"1 M","ipn_track_id":"90f4f2bdc1315"}', true);

        try {
            $listener->requirePostMethod();
            $verified = $listener->processIpn();
        } catch (Exception $e) {
            error_log($e->getMessage());
            // //echo $e->getMessage();
            exit(0);

        }//echo $listener->getResponse();
        //var_dump($verified);
       // echo $_POST['custom']." = ". $_POST['subscr_id']." ".$type;
        if ($verified){
            //file_put_contents('text.txt', "Verified\r\n====\r\n", FILE_APPEND);

            if($_POST['txn_type'] == 'subscr_signup'){

                if(@$_POST['amount3'] == '99.99')
                    $type = 1;
                else
                    $type = 2;


                $this->userM->subscribe($_POST['custom'], $_POST['subscr_id'], $type);
            }


            if($_POST['txn_type'] == 'subscr_cancel')
                $this->userM->unsubscribe( $_POST['subscr_id']);
        }
        /*
        else
            file_put_contents('text.txt', "Failed\r\n====\r\n", FILE_APPEND);
        */
    }



    public function psuccess() {
        $data['text'] = 'Congratulations!<br> Your payment has been processed and your membership has been activated!';
        $this->view('success', $data);
    }

    public function pcancel() {
        $data['text'] = 'Your payment has been canceled.';
        $this->view('fail', $data);
    }

    public function contact(){
        if (!@empty($_POST)) {
           // $this->sendEmail($usr['email'], 'contact', array('#fname#', '#cLink#'), array(), 0, "New message from Contact Us page");
            $message ="Name: ".htmlspecialchars($_POST['name'])."\r\nBusiness Name: ".htmlspecialchars($_POST['bname'])."\r\nEmail: ".htmlspecialchars($_POST['email'])."\r\nContact Type: ".htmlspecialchars($_POST['type'])."\r\nComment: ".htmlspecialchars($_POST['msg']);
            mail('feedback@myrxpal.com', 'New inquiry from Contact Us page', $message);
            $data['text'] = 'Thank you!<br>Your inquiry was successfully sent.';
            $this->view('success', $data);
        }
        else {
            $data['page'] = $this->adminM->getPage(2);
            $this->view('', $data);
        }

    }

    public function about(){
        $data['page'] = $this->adminM->getPage(1);
        $this->view('', $data);
    }

    public function faq(){
        $data['page'] = $this->adminM->getPage(3);
        $this->view('', $data);
    }
    public function policies(){
        $data['page'] = $this->adminM->getPage(4);
        $this->view('', $data);
    }
    public function pricing(){
        $data['page'] = $this->adminM->getPage(5);
        $this->view('', $data);
    }

}