<?php
/**
 * Created by PhpStorm.
 * User: Tan4ik
 * Date: 31.03.15
 * Time: 14:21
 */
class vendorM extends CI_Model {

    var $table   = 'vendor';

    public function getOneBy($field, $value, $cid){
        $q = $this->db->query('Select * from '.$this->table.' where '.$field.' = ? and v_companyId = ?', array($value, $cid));
        if ($q->num_rows()) {
            $res = $q->result_array();
            return $res[0];
        }
        else {
            return array();
        }

    }

    public function getAll($cid, $status=''){
        if ($status == ''){
            $this->db->where('v_companyId', $cid);
        }
        else {
            $this->db->where(array('v_companyId' => $cid, 'v_status' => $status));
        }

        $q = $this->db->get($this->table);
        return $q->result_array();
    }

    public function checkDea($dea){
        //BJ6125341 must work
        $l1 = $dea[0];
        $l2 = $dea[1];
        if (!preg_match("/^[a-zA-Z]{2}$/",$l1.$l2)){
            return false;
        }
        $n1 = $dea[2];
        $n2 = $dea[3];
        $n3 = $dea[4];
        $n4 = $dea[5];
        $n5 = $dea[6];
        $n6 = $dea[7];
        $n7 = $dea[8];
        if (!preg_match("/^[0-9]{7}$/",$n1.$n2.$n3.$n4.$n5.$n6.$n7)){
            return false;
        }
        $sum1 = $n1+$n3+$n5;
        $sum2 = $n2+$n4+$n6;
        $sum3 = $sum1+$sum2*2;
        if (strval($sum3) == $n7) {
            return true;
        }
        else return false;
    }


    public function addVendor($post)
    {
        if ($this->session->userdata('type') == 'user'){
            $user = $this->userM->getUserBy('id', $this->session->userdata('id'));
            $cid = $user['parent_id'];
        }
        else {
            $cid = $this->session->userdata('id');
        }
        //$data = $post;
        foreach ($post as $k =>$v) {
            if ($k == 'v_state') {
                $data[$k] = $v;
            }
            else {
                $data[$k] = strtoupper($v);
            }
        }
        $data['v_companyId'] = $cid;


        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }


    public function editVendor($id, $post){
        //$data = $post;
        foreach ($post as $k =>$v) {
            if ($k == 'v_state') {
                $data[$k] = $v;
            }
            else {
                $data[$k] = strtoupper($v);
            }
        }
        $this->db->where('v_id', $id);
        $this->db->update($this->table, $data);
    }

    public function search($post, $cid){
        $q = $this->db->query('
        SELECT * from `vendor` WHERE '.$post['criterion'].' = ? AND v_companyId = ?
        ', array($post['value'], $cid));
        $res = $q->result_array();
        return $res;
    }

}