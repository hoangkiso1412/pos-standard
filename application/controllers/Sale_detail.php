<?php
/**
 * Geo POS -  Accounting,  Invoicing  and CRM Application
 * Copyright (c) Rajesh Dukiya. All Rights Reserved
 * ***********************************************************************
 *
 *  Email: support@ultimatekode.com
 *  Website: https://www.ultimatekode.com
 *
 *  ************************************************************************
 *  * This software is furnished under a license and may be used and copied
 *  * only  in  accordance  with  the  terms  of such  license and with the
 *  * inclusion of the above copyright notice.
 *  * If you Purchased from Codecanyon, Please read the full License from
 *  * here- http://codecanyon.net/licenses/standard/
 * ***********************************************************************
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Sale_detail extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Sale_detail_model', 'purchase');
        $this->load->library("Aauth");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }

        if (!$this->aauth->premission(2)) {

            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');

        }
        $this->li_a = 'stock';

    }

    //invoices list
    public function index()
    {
        $head['title'] = "Sale Detail";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('sale_detail/invoices');
        $this->load->view('fixed/footer');
    }

    public function ajax_list()
    {

        $list = $this->purchase->get_datatables();
        $data = array();

        $no = $this->input->post('start');

        foreach ($list as $invoices) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = dateformat($invoices->invoicedate);
            $row[] = $invoices->stock;
            $row[] = $invoices->product_type;
            $row[] = $invoices->product_name;
            $row[] = $invoices->items;
            $row[] = $invoices->color;
            $row[] = $invoices->year;
            $row[] = $invoices->conditions_plateNumber;
            $row[] = $invoices->body_number;
            $row[] = $invoices->engine_number;
            $row[] = $invoices->buyer;
            $row[] = amountExchange($invoices->selling_price, 0, $this->aauth->get_user()->loc);
            $row[] = amountExchange($invoices->remain_amount, 0, $this->aauth->get_user()->loc);
            $row[] = amountExchange($invoices->paid_amount, 0, $this->aauth->get_user()->loc);
            $row[] = $invoices->sold_date;
            $row[] = $invoices->notes;

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->purchase->count_all(),
            "recordsFiltered" => $this->purchase->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);

    }

    public function file_handling()
    {
        if ($this->input->get('op')) {
            $name = $this->input->get('name');
            $invoice = $this->input->get('invoice');
            if ($this->purchase->meta_delete($invoice, 4, $name)) {
                echo json_encode(array('status' => 'Success'));
            }
        } else {
            $id = $this->input->get('id');
            $this->load->library("Uploadhandler_generic", array(
                'accept_file_types' => '/\.(gif|jpe?g|png|docx|docs|txt|pdf|xls)$/i', 'upload_dir' => FCPATH . 'userfiles/attach/', 'upload_url' => base_url() . 'userfiles/attach/'
            ));
            $files = (string)$this->uploadhandler_generic->filenaam();
            if ($files != '') {

                $this->purchase->meta_insert($id, 4, $files);
            }
        }
    }
}