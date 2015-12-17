<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Vendor extends CI_Controller {

    public function index()
    {
        $cuser = $this->PaymentRedirect();
        $data['vendors'] = $this->vendorM->getAll($cuser['id']);
        $this->view('', $data);
    }

    public function view_vendor($id){
        $cuser = $this->PaymentRedirect();
        $data['vendor'] = $this->vendorM->getOneBy('v_id', $id, $cuser['id']);
        $this->view('', $data);
    }

    public function add_vendor($id=''){

        $cuser = $this->PaymentRedirect();
        if(!@empty($_POST)){
            if ($id == ''){//create
                $id = $this->vendorM->addVendor($_POST);
                $data['text'] = 'Vendor added';
            }
            else {
                $this->vendorM->editVendor($id, $_POST);
                $data['text'] = 'Vendor changed';
            }
            $this->view('success', $data);
            //redirect('vendor/view_vendor/'.$id);
        }
        else {
            $data['vendor'] = array();
            if ($id !== ''){
                $data['vendor'] = $this->vendorM->getOneBy('v_id', $id, $cuser['id']);
            }
            $this->view('', $data);
        }
    }

    public function search(){
        $cuser = $this->PaymentRedirect();
        $data['vendors'] = $this->vendorM->search($_POST, $cuser['id']);
        //$data['condition'] = $_POST;
        $this->view('', $data);
    }

    public function checkDea() {
        $cuser = $this->PaymentRedirect();
        @$dea = $_GET['v_dea'];

        if(!@$dea)
            return;

        header('Content-Type: application/json');
        $vendor = $this->vendorM->getOneBy('v_dea', $dea, $cuser['id']);

        $isAvailable = true;

        if(!@empty($vendor)){
            $isAvailable = false;
        }
        else {
            $isAvailable = $this->vendorM->checkDea($dea);
        }

        echo json_encode(array(
            'valid' => $isAvailable,
        ));

    }



}