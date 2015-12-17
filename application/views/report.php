<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Report extends CI_Controller {

    function ReportRedirect(){
        $cuser = $this->PaymentRedirect();
        $user = $this->userM->getUserBy('id', $this->session->userdata('id'));
        if ($user['reports'] == 'Off') {
            redirect('main/');
        }
        return $cuser;
    }

    public function index()
    {
		$cuser = $this->ReportRedirect();

		$data = array();
		//$data["catlist"] = $this->categoryM->getAll($cuser["id"]);
		$data["catlist"] = $this->createCategoryTree(0, $this->categoryM->getAll($cuser['id'], 'Active'));

        $this->view('', $data);

		if (!@empty($_POST)){
           // print_r($_POST);
        }
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

    public function generate()
	{
		$cuser = $this->ReportRedirect();

        if (!@empty($_POST['parameters']))
		{
            $data['labels'] = array(
                'e_date' => 'Date Entered',
                'd_code' => 'NDC',
                'd_name' => 'Name',
                'd_descr' => 'Description',
                'e_rx' => 'Rx / Trans #',
                'd_size' => 'Package Size',
                'd_manufacturer' => 'Manufacturer',
                'd_onHand' => 'QOH',
                'variance' => 'Variance',
                'd_schedule' => 'Schedule',
                'e_note' => 'Notes',
                'e_costPack' => 'Cost / Pack',
                'costUnit' => 'Cost / Unit',
                'e_lot' => 'Lot #',
                'e_expiration' => 'Exp Date',
                'd_modified' => 'Last Modified',
                'username' => 'Username',
                'e_invoice' => 'Invoice #',
                'v_name' => 'Vendor',
                'd_status' => 'Drug Status',
                'd_barcode' => 'Barcode',
                'd_created' => 'Date Created',
                'd_start' => 'Starting Inventory',
                'v_address' => 'Address',
                'v_city' => 'City',
                'v_state' => 'State',
                'v_zip' => 'Zipcode',
                'v_tel' => 'Tel',
                'v_fax' => 'Fax',
                'v_email' => 'Email',
                'v_license' => 'License Number',
                'v_dea' => 'DEA',
                'v_cname' => 'Contact Name',
                'v_status' => 'Status',
                'in' => 'Inventory In',
                'out' => 'Inventory Out',
                'audit' => 'Inventory Audit',
                'drug' => 'Drug Catalog',
                'vendor' => 'Vendor Catalog',
                'e_old' => 'Expected QOH',
                'e_new' => 'Actual QOH',
                'e_out' => 'Quantity Out',
                'qty_in' => 'Quantity In',
                'a_status' => 'Active Status',
                'in_status' => 'Inactive Status',
                'e_type' => 'Transaction Type',
                'all' => 'All Transactions',
                'c_name' => 'Category',
                'cat' => 'Category',
                'ndc' => 'NDC',
                'dname' => 'Drug Name',
            );

            $data['dates'] = array('e_date', 'e_expiration', 'd_modified', 'd_created', 'd_modified');

            //$data['e_type'] = $_POST['e_type'];

            if (isset($_POST['date1']))
			{
                $date1 = $_POST['date1'];

                if (isset($_POST['date2']))
				{
                    $date2 = $_POST['date2'];
                } else {
                    $date2 = $date1;
                }

                $data['date_range'] = array($date1, $date2);
            } else {
                $data['date_range'] = array();
            }

            $data['type'] = $_POST['type'];
            $data['fields'] = $_POST['parameters'];
            $i = 0;
            $data['ndc_num'] = $i;

            foreach ($_POST['parameters'] as $k => $v)
			{
                if ($v == 'd_code')
				{
                    $data['ndc_num'] = $i;
                }

				$i++;
            }
            //$data['ndc_num'] = $i;

			
            if ($_POST['type'] == 'drug') {
                $data['entries'] = $this->reportM->drugReport($_POST, $cuser['id']);
            } else if ($_POST['type'] == 'vendor') {
                $data['entries'] = $this->reportM->vendorReport($cuser['id']);
            } else {
                $data['entries'] = $this->reportM->entryReport($_POST, $cuser['id']);
            }

            $this->view('report/generate', $data);
        }
	}


    public function create_pdf(){
        $cuser = $this->ReportRedirect();
        $_POST['html'] = preg_replace('/[\r\n\t]+/i', '', $_POST['html']);
        preg_match('/Search:<input type="search" class="" placeholder="" aria-controls="myTable"><\/label>(.*)Showing/', $_POST['html'], $match);

        if ($_POST['pb'] == 'no') {
            $content = $match[1];

        }
        else if ($_POST['pb'] == 'ndc') {
            $rows = explode("</tr>", $match[1]);
            $tail = array_pop($rows);
            $entries = array();
            foreach ($rows as $row) {
                $row1 = preg_replace('/[\r\n\t]+/i', '', $row);
                preg_match('#([0-9]{5}\-[0-9]{4}\-[0-9]{2})#', $row1, $ndc_match);
                preg_match('#([0-9]{2}\-[0-9]{2}\-[0-9]{4})#', $row1, $date_match);
                if (!empty($ndc_match)) {
                    $entries[$ndc_match[1]][strtotime(str_replace('-', '/', $date_match[1]))][] = $row.'</tr>';
                }
            }
            ksort($entries, SORT_NUMERIC);
            foreach ($entries as $k=>$v) {
                ksort($entries[$k], SORT_NUMERIC);
                foreach ($entries[$k] as $key=>$val) {
                    $entries[$k][$key] = implode('', $val);
                }
                 $entries[$k] = implode('', $entries[$k]);
            }
            $string = implode('</table><pagebreak />'.$rows[0].'</thead><tbody>', $entries);
            $content = $rows[0].$string.$tail;
            //echo $content;
        }
        else if ($_POST['pb'] == 'cat') {
            $rows = explode("</tr>", $match[1]);
            $rows0 = array_shift($rows);
            $tail = array_pop($rows);
            $cells = explode('<td', $rows0);
            $i = 0; $num = 0;
            foreach ($cells as $one) {
                if (strpos($one, 'Category')) {
                    $num = $i;
                    break;
                }
                $i++;
            }

            $entries = array();
            foreach ($rows as $row) {

                $row1 = preg_replace('/[\r\n\t]+/i', '', $row);
                $row1cells = explode('<td', $row1);
                preg_match('#>(.{1,})$#', $row1cells[$num], $cat_match);
                /*if ($cat_match[1] == '</td> ') {
                    $cat_match[1] = 'No_cat</td> ';
                }*/
                preg_match('#([0-9]{2}\-[0-9]{2}\-[0-9]{4})#', $row1, $date_match);
                //print_r( $cat_match);
                if (!empty($cat_match)) {
                    $entries[$cat_match[1]][strtotime(str_replace('-', '/', $date_match[1]))][] = $row.'</tr>';
                }
            }
            ksort($entries, SORT_NUMERIC);
            foreach ($entries as $k=>$v) {
                ksort($entries[$k], SORT_NUMERIC);
                foreach ($entries[$k] as $key=>$val) {
                    $entries[$k][$key] = implode('', $val);
                }
                $entries[$k] = implode('', $entries[$k]);
            }
            $string = implode('</table><pagebreak />'.$rows0.'</thead><tbody>', $entries);
            $content = $rows0.$string.$tail;
            //echo $content;
        }


                                $html = '
                                    <htmlpageheader name="MyHeader1" style="">
                                        <div style="position:relative; width: 100%; ">
                                            <table width="100%">
                                                <tr>
                                                    <td width="33%">
                                                        '.$cuser["cname"].'
                                                    </td>
                                                    <td style="text-align:center"  width="33%">
                                                       <strong>'.$_POST['title'].'</strong>
                                                    </td>
                                                    <td width="33%">&nbsp;
                                                        
                                                    </td>
                                                </tr>
                                            </table>
                                            <div style="width: 100%;text-align:center;">'.$_POST['date_range'].'</div>
                                            <div style="text-align: right">'.date('m-d-Y H:m', time()).'</div>
                                        </div>
                                    </htmlpageheader>
                                    <htmlpagefooter name="MyFooter1">
                                        <table width="100%">
                                            <tr>
                                                <td width="33%"></td>
                                                <td style="text-align:center" width="33%">
                                                    {PAGENO}
                                                </td>
                                                <td style="text-align:right" width="33%">
                                                   <div ><img src="'.base_url().'images/logo.jpg" style="width: 100px"></div>
                                                </td>
                                            </tr>
                                        </table>
                                    </htmlpagefooter>
                                    <sethtmlpageheader name="MyHeader1" value="on" show-this-page="1" />
                                    <sethtmlpagefooter name="MyFooter1" value="on" show-this-page="2"/>
                                    <div style="margin-top:40px">'.$content.'</div>';
                                require_once("assets/mpdf60/mpdf.php");

                                $mpdf = new mPDF('utf-8', 'A4-L', '8', '', 10, 10, 7, 7, 10, 10);

                                $mpdf->setAutoTopMargin = 'stretch';
                                $mpdf->setAutoBottomMargin = 'stretch';
                                $stylesheet = file_get_contents('assets/css/style.css');

                                $mpdf->WriteHTML($stylesheet, 1);

                                $mpdf->list_indent_first_level = 0;
                                $mpdf->WriteHTML($html, 2);
                                $mpdf->Output('mpdf.pdf', 'I');
                  /*       */
    }


    /*
    public function view_pdf() {
        $cuser = $this->ReportRedirect();
        $_POST['html'] = preg_replace('/[\r\n\t]+/i', '', $_POST['html']);
        preg_match('/Search:<input type="search" class="" placeholder="" aria-controls="myTable"><\/label>(.*)Showing/', $_POST['html'], $match);

        $html = '<div style="float: left;width:33%">'.$cuser["cname"].'</div>
        <div style="float: left;width:33%;text-align:center;"><strong>'.$_POST['title'].'</strong></div>
        <div style="clear:both"></div>
        <div style="width: 100%;text-align:center;">'.$_POST['date_range'].'</div>
        <div style="clear:both"></div>
        <div style="text-align: right">'.date('m-d-Y H:m', time()).'</div>
        '.$match[1].'
        <img src="'.base_url().'images/logo.jpg" style="width: 125px">';

        echo $html;
    }
*/
    /*
        public function create_pdf(){
            $cuser = $this->ReportRedirect();
            $_POST['html'] = preg_replace('/[\r\n\t]+/i', '', $_POST['html']);
            preg_match('/Search:<input type="search" class="" placeholder="" aria-controls="myTable"><\/label>(.*)Showing/', $_POST['html'], $match);

            //$html = '<div style="float: left">'.$cuser["cname"].'</div><div style="right: 0">'.date('m-d-Y H:m', time()).'</div>'.$match[1].'<br>';
            $html = '


            <div style="position:absolute;left:50%;margin-left:-70px;text-align:center"><strong>'.$_POST['title'].'</strong></div>

            <div style="width: 100%">'.$cuser["cname"].'</div>

            <div style="clear:both"></div>
            <div style="width: 100%;text-align:center;">'.$_POST['date_range'].'</div>
            <div style="clear:both"></div>
            <div style="text-align: right">'.date('m-d-Y H:m', time()).'</div>
            '.$match[1].'
            <div style="position:absolute;right:0"><img src="'.base_url().'images/logo.jpg" style="width: 125px"></div>
            <script type="text/php">
            if ( isset($pdf) ) {

              $font = Font_Metrics::get_font("helvetica", "bold");

              $pdf->page_text(450, 520, "page: {PAGE_NUM} of {PAGE_COUNT}", $font, 10, array(0,0,0));

                // Open the object: all drawing commands will
                  // go to the object instead of the current page
                  $footer = $pdf->open_object();

                  $w = $pdf->get_width();
                  $h = $pdf->get_height();

                  // Draw a line along the bottom
                  $y = $h/2;
                  $pdf->line(16, $y, $w - 16, $y, $color, 1);

                  // Add an initals box
                  $font = Font_Metrics::get_font("helvetica", "bold");
                  $text = "Initials:";
                  $width = Font_Metrics::get_text_width($text, $font, $size);
                  $pdf->text($w/2, $y, $text, $font, $size, $color);


                  // Add a logo
                  $img_w = 2 * 72; // 2 inches, in points
                  $img_h = 1 * 72; // 1 inch, in points -- change these as required
                  $pdf->image("/images/logo.jpg", "jpg", $w/3, $y/3, $img_w, $img_h);

                  // Close the object (stop capture)
                  $pdf->close_object();

                  // Add the object to every page. You can
                  // also specify "odd" or "even"
                  $pdf->add_object($footer, "all");
            }

            </script>
            ';

            require_once("assets/dompdf/dompdf_config.inc.php");

            $dompdf = new DOMPDF();
            $dompdf->load_html($html);
            $dompdf->set_paper('a4', 'landscape');
            $dompdf->render();

            $dompdf->stream("report.pdf");
        }*/

}