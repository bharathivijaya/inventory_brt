<?php
/**
 * Created by PhpStorm.
 * User: Tan4ik
 * Date: 23.03.15
 * Time: 14:21
 */
class categoryM extends CI_Model {

    var $table   = 'category';

    public function getOneBy($field, $value, $cid){
        //$w = array($field => $value);
        //$this->db->where($w);
        $q = $this->db->query('Select * from '.$this->table.' where '.$field.' = ? and c_companyId = ?', array($value, $cid));
        if ($q->num_rows()) {
            $res = $q->result_array();
            return $res[0];
        }
        else {
            return array();
        }

    }

    public function getAll($cid, $status = '')
	{
        /*if ($status == '') $this->db->where(array('c_companyId' => $cid));
        else $this->db->where(array('c_companyId' => $cid, 'c_status' => $status));
        $q = $this->db->get($this->table);*/

		if ($status == '') $q = $this->db->query('SELECT с.*, (SELECT c_name FROM category WHERE с.c_mainCatId=c_id) as parent_cat_name FROM category с WHERE с.c_companyId=?', array($cid));
		else $q = $this->db->query('SELECT с.*, (SELECT c_name FROM category WHERE с.c_mainCatId=c_id) as parent_cat_name FROM category с WHERE с.c_companyId=? and c_status=?', array($cid, $status));

		/*if ($status == '') $q = $this->db->query("SELECT c.*, (SELECT c_name FROM category WHERE c.c_mainCatId=c_id) as parent_cat_name FROM category c, drug_categories WHERE c.c_id=drug_categories.drugId and c.c_companyId=?", array($cid));
		else $q = $this->db->query("SELECT c.*, (SELECT c_name FROM category WHERE c.c_mainCatId=c_id) as parent_cat_name FROM category c, drug_categories WHERE c.c_id=drug_categories.drugId and c.c_companyId=? and c.c_status=?", array($cid, $status));
		*/

		return $q->result_array();
    }

	public function getDrugCatsArray($drugId)
	{
		$q = $this->db->query("SELECT * FROM drug_categories WHERE drugId=?", array($drugId));
		$r = array();

		foreach ($q->result_array() as $rj)
			array_push($r, $rj["catId"]);

		return $r;
	}

	public function getDrugCatsNames($drugId)
	{
		$q = $this->db->query("SELECT category.* FROM drug_categories, category WHERE drug_categories.catId=category.c_id and drugId=?", array($drugId));
		return $q->result_array();
	}

	public function getOnlyMain($cid, $active = '')
	{
		if ($active == "") $q = $this->db->query('SELECT * FROM category WHERE c_companyId=? and c_mainCatId=0', array($cid));
		else $q = $this->db->query('SELECT * FROM category WHERE c_companyId=? and c_mainCatId=0 and c_status=?', array($cid, $active));
		return $q->result_array();
	}

	public function getChildrenCat($cat_id)
	{
		$q = $this->db->query('SELECT * FROM category WHERE c_mainCatId=?', array($cat_id));
		return $q->result_array();
	}

	public function removeCat($id, $cid)
	{
		$this->db->query('DELETE FROM category WHERE c_id=? and c_companyId=?', array($id, $cid));
	}

    public function addCategory($post)
    {
        if ($this->session->userdata('type') == 'user'){
            $user = $this->userM->getUserBy('id', $this->session->userdata('id'));
            $cid = $user['parent_id'];
        } else {
            $cid = $this->session->userdata('id');
        }

        //$data = $post;
        foreach ($post as $k =>$v) {
            if ($k !== 'add_new') {
                $data[$k] = strtoupper($v);
            }
        }

		/*if (@$post["c_mainCatId"])
		{
			$q = $this->db->query('SELECT * FROM category WHERE c_id=?', array($post["c_mainCatId"]));
			$res = $q->result_array();
			$res = $res[0];

			$data['c_status'] = $res["c_status"];
		}*/

        $data['c_companyId'] = $cid;

        /*
        $data['d_created'] = time();
        $data['d_modified'] = time();
        $data['d_userCreatedId'] = $this->session->userdata('id');
		*/

		$q = $this->db->query("SELECT c_localId FROM category WHERE c_companyId=? ORDER BY c_localId DESC LIMIT 0, 1", array($cid));
		$res = $q->result_array();

		if ($q->num_rows() > 0)
			$data['c_localId'] = $res[0]['c_localId'] + 1;
		else
			$data['c_localId'] = 1;

        $this->db->insert($this->table, $data);
		$lid = $this->db->insert_id();

		if (@isset($post["c_mainCatId"]))
		{
			$q = $this->db->query("SELECT COUNT(*) FROM category WHERE c_mainCatId=?", array($post["c_mainCatId"]));
			$res = $q->result_array();
			$this->db->query("UPDATE category SET c_countChildren=? WHERE c_id=?", array($res[0]["COUNT(*)"], $post["c_mainCatId"]));
		}
		
        return $lid;
    }

    public function editCategory($id, $post)
	{
        foreach ($post as $k =>$v) $data[$k] = strtoupper($v);

        $this->db->where('c_id', $id);
        $this->db->update($this->table, $data);

		if (@isset($post["c_mainCatId"]))
		{
			$q = $this->db->query("SELECT COUNT(*) FROM category WHERE c_mainCatId=?", array($post["c_mainCatId"]));
			$res = $q->result_array();
			$this->db->query("UPDATE category SET c_countChildren=? WHERE c_id=?", array($res[0]["COUNT(*)"], $post["c_mainCatId"]));
		}
    }

	/**/

    public function getDrugsOfCat($cid) {
        $this->db->where('d_catId', $cid);
        $q = $this->db->get('drug');
        return $q->result_array();
    }


}