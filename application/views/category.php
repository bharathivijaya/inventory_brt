<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Category extends CI_Controller {

    public function index()
    {
        $cuser = $this->PaymentRedirect();
        $data['cats'] = $this->categoryM->getAll($cuser['id']);
        $this->view('', $data);
    }

    public function view_category($id){
        $cuser = $this->PaymentRedirect();
        $data['cat'] = $this->categoryM->getOneBy('c_id', $id, $cuser['id']);
        $data['drugs'] = $this->categoryM->getDrugsOfCat($id);
        $this->view('', $data);
    }

	public function remove_subcat()
	{
		$cuser = $this->PaymentRedirect();
		$this->categoryM->removeCat(@$_POST["c_id"], $cuser['id']);
	}

	public function save_subcats($id)
	{
		foreach ($_POST['c_id'] as $key => $value)
		{
			// update
			if (!empty($value))
			{
				$data = array();
				$data["c_name"] = $_POST['c_name'][$key];
				$data["c_descr"] = $_POST['c_descr'][$key];
				$this->categoryM->editCategory($value * 1, $data);
			} else { //insert
				$data = array();
				$data["c_name"] = $_POST['c_name'][$key];
				$data["c_descr"] = $_POST['c_descr'][$key];
				$data["c_mainCatId"] = $id;
				$this->categoryM->addCategory($data);
			}
		}

		redirect("/category/add_category/" . $id);
	}

	public function add_category_by_js()
	{
		$cuser = $this->PaymentRedirect();

		if(!@empty($_POST))
		{
			$data2 = array();
			$data2["c_name"] = $_POST['c_name'];
			$data2["c_descr"] = $_POST['c_descr'];
			$data2["c_status"] = $_POST["c_status"];
			$data2["c_mainCatId"] = $_POST["c_mainCatId"];
			$id = $this->categoryM->addCategory($data2);

			if ($id) echo "ok";
			else echo "error";
		}
	}

    public function add_category($id = '')
	{
        $cuser = $this->PaymentRedirect();

        if(!@empty($_POST))
		{
            if ($id == '')
			{ //create
				$data2 = array();
				$data2["c_name"] = $_POST['c_name'];
				$data2["c_descr"] = $_POST['c_descr'];
				$data2["c_status"] = $_POST["c_status"];
				$data2["c_mainCatId"] = $_POST["c_mainCatId"];
                $id = $this->categoryM->addCategory($data2);

				// if has sub cats
				/*if (@$_POST['cc_id']) foreach ($_POST['cc_id'] as $key => $value)
				{
					$data2 = array();
					$data2["c_name"] = $_POST['cc_name'][$key];
					$data2["c_descr"] = $_POST['cc_descr'][$key];
					$data2["c_mainCatId"] = $id;
					$data2["c_status"] = $_POST["c_status"];
					$this->categoryM->addCategory($data2);
				}*/

                if ($id)
					$data['text'] = 'Category Added!';

            } else {
                $category = $this->categoryM->getOneBy('c_id', $id, $cuser['id']);

                if (!@empty($category))
				{
					$data2 = array();
					$data2["c_name"] = $_POST['c_name'];
					$data2["c_descr"] = $_POST['c_descr'];
					$data2["c_status"] = $_POST["c_status"];
					$data2["c_mainCatId"] = $_POST["c_mainCatId"];
                    $this->categoryM->editCategory($id, $data2);

					/*if (@$_POST['cc_id']) foreach ($_POST['cc_id'] as $key => $value)
					{
						// update
						if (!empty($value))
						{
							$data2 = array();
							$data2["c_name"] = $_POST['cc_name'][$key];
							$data2["c_descr"] = $_POST['cc_descr'][$key];
							$data2["c_status"] = $_POST["c_status"];
							$this->categoryM->editCategory($value * 1, $data2);
						}
					}*/

                    $data['text'] = 'Category Changed!';
                }
            }

            $this->view('success', $data);
        } else {
            $data = array();

            if ($id !== '')
			{
                $data['cat'] = $this->categoryM->getOneBy('c_id', $id, $cuser['id']);
				// $data["catlist"] = $this->categoryM->getChildrenCat($id);

                if (@empty($data['cat']))
					redirect('category/');
            }

			$data["catlist"] = $this->categoryM->getOnlyMain($cuser['id']);

            $this->view('', $data);
        }
    }

	public function merge()
	{
		/*$r = $this->logbookM->mergeTables();

		$this->view('success', array("text" => $r));*/
	}

	public function add_drug_category($id)
	{
		$cuser = $this->PaymentRedirect();
		$data = array();
		$data["drug"] = $this->drugM->getOneBy('d_id', $id, $cuser['id']);

		if (!@empty($_POST)) {
			unset($_POST["c_drugId"]);

			$data2 = array();
			$data2["c_name"] = $_POST['c_name'];
			$data2["c_descr"] = $_POST['c_descr'];
			$data2["c_status"] = $_POST["c_status"];
			$data2["c_mainCatId"] = $_POST["c_mainCatId"];
			$c_id = $this->categoryM->addCategory($data2);

			// if has sub cats
			/*if (@$_POST['cc_id']) foreach ($_POST['cc_id'] as $key => $value)
			{
				$data2 = array();
				$data2["c_name"] = $_POST['cc_name'][$key];
				$data2["c_descr"] = $_POST['cc_descr'][$key];
				$data2["c_mainCatId"] = $c_id;
				$data2["c_status"] = $_POST["c_status"];
				$this->categoryM->addCategory($data2);
			}*/

			//$c_id = $this->categoryM->addCategory($_POST);
			$this->drugM->editDrug($id, array("d_catId" => $c_id));

			if ($id)
				$data['text'] = 'Category Added!';

			$this->view('success', $data);
		} else {
			$data["d_id"] = $id;
			$data["catlist"] = $this->categoryM->getOnlyMain($cuser['id']);

			$this->view('', $data);
		}
	}
}