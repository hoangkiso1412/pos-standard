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

class Purchase extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('purchase_model', 'purchase');
        $this->load->library("Aauth");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }

        if (!$this->aauth->premission(2)) {

            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');

        }
        $this->li_a = 'stock';

    }

    //create invoice
    public function create()
    {
        $this->load->library("Common");
        $data['taxlist'] = $this->common->taxlist($this->config->item('tax'));
        $this->load->model('plugins_model', 'plugins');
        $data['exchange'] = $this->plugins->universal_api(5);
        $data['currency'] = $this->purchase->currencies();
        $this->load->model('customers_model', 'customers');
        $data['customergrouplist'] = $this->customers->group_list();
        $data['lastinvoice'] = $this->purchase->lastpurchase();
        $data['terms'] = $this->purchase->billingterms();
        $head['title'] = "New Purchase";
        $head['usernm'] = $this->aauth->get_user()->username;
        $data['warehouse'] = $this->purchase->warehouses();
        $this->load->model('employee_model', 'employees');
        $data['purchaser'] = $this->employees->get_employee_all();
        $data['taxdetails'] = $this->common->taxdetail();
        $this->load->view('fixed/header', $head);
        $this->load->view('purchase/newinvoice', $data);
        $this->load->view('fixed/footer');
    }

    //edit invoice
    public function edit()
    {

        $tid = $this->input->get('id');
        $data['id'] = $tid;
        $data['title'] = "Purchase Order $tid";
        $this->load->model('customers_model', 'customers');
        $this->load->model('employee_model', 'employees');
        $data['customergrouplist'] = $this->customers->group_list();
        $data['purchaser_s'] = $this->employees->get_employee_s($tid);
        $data['purchaser'] = $this->employees->get_employee_all();
        $data['terms'] = $this->purchase->billingterms();
        $data['invoice'] = $this->purchase->purchase_details($tid);
        // $data['products'] = $this->purchase->purchase_products($tid);
        $data['products'] = $this->purchase->purchase_product_list($tid);
        $head['title'] = "Edit Invoice #$tid";
        $head['usernm'] = $this->aauth->get_user()->username;
        $data['warehouse'] = $this->purchase->warehouses();
        $data['currency'] = $this->purchase->currencies();
        $this->load->model('plugins_model', 'plugins');
        $data['exchange'] = $this->plugins->universal_api(5);
        $this->load->library("Common");
        $data['taxlist'] = $this->common->taxlist_edit($data['invoice']['taxstatus']);
        $this->load->view('fixed/header', $head);
        $this->load->view('purchase/edit', $data);
        $this->load->view('fixed/footer');

    }

    //invoices list
    public function index()
    {
        $head['title'] = "Manage Purchase Orders";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('purchase/invoices');
        $this->load->view('fixed/footer');
    }

    //action
    public function action()
    {
        
        $s_warehouse = $this->input->post("s_warehouses");
        $s_purchaser = $this->input->post("s_purchaser");
        $receive_amount = $this->input->post("receive_amount");
        $currency = $this->input->post('mcurrency');
        $customer_id = $this->input->post('customer_id');
        $invocieno = $this->input->post('invocieno');
        $invoicedate = $this->input->post('invoicedate');
        $invocieduedate = $this->input->post('invocieduedate');
        $notes = $this->input->post('notes', true);
        $tax = $this->input->post('tax_handle');
        $subtotal = rev_amountExchange_s($this->input->post('subtotal'), $currency, $this->aauth->get_user()->loc);
        $shipping = rev_amountExchange_s($this->input->post('shipping'), $currency, $this->aauth->get_user()->loc);
        $shipping_tax = rev_amountExchange_s($this->input->post('ship_tax'), $currency, $this->aauth->get_user()->loc);
        $ship_taxtype = $this->input->post('ship_taxtype');
        if ($ship_taxtype == 'incl') @$shipping = $shipping - $shipping_tax;
        $refer = $this->input->post('refer', true);
        $total = rev_amountExchange_s($this->input->post('total'), $currency, $this->aauth->get_user()->loc);
        $total_tax = 0;
        $total_discount = 0;
        $discountFormat = $this->input->post('discountFormat');
        $pterms = $this->input->post('pterms');
        $i = 0;
        if ($discountFormat == '0') {
            $discstatus = 0;
        } else {
            $discstatus = 1;
        }

        if ($customer_id == 0) {
            echo json_encode(array('status' => 'Error', 'message' =>
                "Please add a new supplier or search from a previous added!"));
            exit;
        }
        $this->db->trans_start();
        //products
        $transok = true;
        //Invoice Data
        $bill_date = datefordatabase($invoicedate);
        $bill_due_date = datefordatabase($invocieduedate);
        $data = array('tid' => $invocieno, 'invoicedate' => $bill_date, 'invoiceduedate' => $bill_due_date, 'subtotal' => $subtotal, 'shipping' => $shipping, 'ship_tax' => $shipping_tax, 'ship_tax_type' => $ship_taxtype, 'total' => $total, 'notes' => $notes, 'csd' => $customer_id, 'eid' => $this->aauth->get_user()->id, 'taxstatus' => $tax, 'discstatus' => $discstatus, 'format_discount' => $discountFormat, 'refer' => $refer, 'term' => $pterms, 'loc' => $this->aauth->get_user()->loc, 'multi' => $currency,'purchaser_id'=>$s_purchaser,'pamnt'=>$receive_amount);


        

        if ($this->db->insert('geopos_purchase', $data)) {
            $invocieno = $this->db->insert_id();

            $pid = $this->input->post('pid');
            $productlist = array();
            $stocklist = array();
            $prodindex = 0;
            $itc = 0;
            $flag = false;
            $product_id = $this->input->post('pid');
            $product_name1 = $this->input->post('product_name', true);
            // Srieng modified 24-10-2020
            $body_num= $this->input->post('body_number', true);
            $engine_num= $this->input->post('engine_number', true);
            $plate_num= $this->input->post('plate_number', true);
            $other_expense= $this->input->post('other_expense', true);
            $purchase_paidamount = $this->input->post("purchase_paid_amount");
            
            // End
            $product_qty = $this->input->post('product_qty');
            $product_price = $this->input->post('product_price');
            $product_tax = $this->input->post('product_tax');
            $product_discount = $this->input->post('product_discount');
            $product_subtotal = $this->input->post('product_subtotal');
            $ptotal_tax = $this->input->post('taxa');
            $ptotal_disc = $this->input->post('disca');
            $product_des = $this->input->post('product_description', true);
            $product_unit = $this->input->post('unit');
            $product_hsn = $this->input->post('hsn');

            foreach ($pid as $key => $value) {
              //Check validation when user not input in product name, engine number and body number
              if($product_name1[$key]=="") {
                echo json_encode(array('status' => 'Error', 'message' =>
                        "Product name require!"));
                    $transok = false;
                    exit;
              }
              if($body_num[$key]=="") {
                echo json_encode(array('status' => 'Error', 'message' =>
                        "Body number require!"));
                    $transok = false;
                    exit;
              }
              if($engine_num[$key]=="") {
                echo json_encode(array('status' => 'Error', 'message' =>
                        "Engine number require!"));
                    $transok = false;
                    exit;
              }
              
            // Check validation of product exising with engine number and body number 
              $engineno=$this->db->query("select tb_stock.engine_number from tb_stock 
                            where tb_stock.product_id=".$product_id[$key]." and tb_stock.engine_number='".$engine_num[$key]."' and tb_stock.body_number='".$body_num[$key]."'")->row()->engine_number;
                if($engineno!=""){
                        echo json_encode(array('status' => 'Error', 'message' =>
                        "This product $product_name1[$key] and body number: $body_num[$key] and engine number: $engine_num[$key] already exist!"));
                    $transok = false;
                    exit;
                }
              // Check validation of plate number exising
              if($plate_num[$key]!="") {
                  $plateno=$this->db->query("select tb_stock.plate_number from tb_stock 
                  where tb_stock.plate_number='".$plate_num[$key]."'")->row()->plate_number;
                  if($plateno!=""){
                          echo json_encode(array('status' => 'Error', 'message' =>
                          "This plate number $plate_num[$key] already exist!"));
                      $transok = false;
                      exit;
                  }
              }


                $total_discount += numberClean(@$ptotal_disc[$key]);
                $total_tax += numberClean($ptotal_tax[$key]);


                $data = array(
                    'tid' => $invocieno,
                    'pid' => $product_id[$key],
                    'product' => $product_name1[$key],
                    'code' => $product_hsn[$key],
                    'qty' => numberClean($product_qty[$key]),
                    'price' => rev_amountExchange_s($product_price[$key], $currency, $this->aauth->get_user()->loc),
                    'tax' => numberClean($product_tax[$key]),
                    'discount' => numberClean($product_discount[$key]),
                    'subtotal' => rev_amountExchange_s($product_subtotal[$key], $currency, $this->aauth->get_user()->loc),
                    'totaltax' => rev_amountExchange_s($ptotal_tax[$key], $currency, $this->aauth->get_user()->loc),
                    'totaldiscount' => rev_amountExchange_s($ptotal_disc[$key], $currency, $this->aauth->get_user()->loc),
                    'product_des' => $product_des[$key],
                    'unit' => $product_unit[$key]
                );
                // $date = DateTime::createFromFormat('d/m/Y', $invoicedate);
                $date = str_replace('/', '-', $invoicedate );
                $newDate = date("Y-m-d", strtotime($date));
                $data_stock = array(
                    'product_id' => $product_id[$key],
                    'warehouse_id' => $s_warehouse,
                    'body_number'  => $body_num[$key],
                    'engine_number' =>$engine_num[$key],
                    'plate_number' => $plate_num [$key],
                    'other_expense' => $other_expense[$key],
                    'total' => rev_amountExchange_s($product_price[$key], $currency, $this->aauth->get_user()->loc),
                    'purchase_date' => $newDate,
                    'purchase_id' => $invocieno,
                    'tax' => numberClean($product_tax[$key]),
                    'discount' => numberClean($product_discount[$key]),
                    'subtotal' => rev_amountExchange_s($product_subtotal[$key], $currency, $this->aauth->get_user()->loc),
                    'totaltax' => rev_amountExchange_s($ptotal_tax[$key], $currency, $this->aauth->get_user()->loc),
                    'totaldiscount' => rev_amountExchange_s($ptotal_disc[$key], $currency, $this->aauth->get_user()->loc),
                    'product_des' => $product_des[$key],
                    'unit' => $product_unit[$key],
                    'purchase_paid_amount' => $purchase_paidamount[$key],
                    'purchase_remain_amount' => rev_amountExchange_s($product_subtotal[$key], $currency, $this->aauth->get_user()->loc)-$purchase_paidamount[$key],
                    'purchase_qty' =>1
                    );

                $flag = true;
                $productlist[$prodindex] = $data;
                $stocklist[$prodindex] = $data_stock;
                $i++;
                $prodindex++;
                $amt = numberClean($product_qty[$key]);

                if ($product_id[$key] > 0) {
                    if ($this->input->post('update_stock') == 'yes') {

                        $this->db->set('qty', "qty+$amt", FALSE);
                        $this->db->where('pid', $product_id[$key]);
                        $this->db->update('geopos_products');
                    }
                    $itc += $amt;
                }
            }
            if ($prodindex > 0) {
                $this->db->insert_batch('geopos_purchase_items', $productlist);
                $this->db->set(array('discount' => rev_amountExchange_s(amountFormat_general($total_discount), $currency, $this->aauth->get_user()->loc), 'tax' => rev_amountExchange_s(amountFormat_general($total_tax), $currency, $this->aauth->get_user()->loc), 'items' => $itc));
                $this->db->where('id', $invocieno);
                $this->db->update('geopos_purchase');

                //print_r($stocklist);
                $this->db->insert_batch('tb_stock', $stocklist);
                //$this->db->set(array('discount' => rev_amountExchange_s(amountFormat_general($total_discount), $currency, $this->aauth->get_user()->loc), 'tax' => rev_amountExchange_s(amountFormat_general($total_tax), $currency, $this->aauth->get_user()->loc), 'items' => $itc));
                // $this->db->where('id', $invocieno);
                // $this->db->update('geopos_purchase');

            } else {
                echo json_encode(array('status' => 'Error', 'message' =>
                    "Please choose product from product list. Go to Item manager section if you have not added the products."));
                $transok = false;
            }


            echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('Purchase order success') . "<a href='view?id=$invocieno' class='btn btn-info btn-lg'><span class='fa fa-eye' aria-hidden='true'></span>" . $this->lang->line('View') . " </a>"));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
            $transok = false;
        }


        if ($transok) {
            $this->db->trans_complete();
        } else {
            $this->db->trans_rollback();
        }


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
            $row[] = $invoices->tid;
            $row[] = $invoices->name;
            $row[] = dateformat($invoices->invoicedate);
            $row[] = amountExchange($invoices->total, 0, $this->aauth->get_user()->loc);
            $row[] = '<span class="st-' . $invoices->status . '">' . $this->lang->line(ucwords($invoices->status)) . '</span>';
            $row[] = '<a href="' . base_url("purchase/view?id=$invoices->id") . '" class="btn btn-success btn-xs"><i class="fa fa-eye"></i> ' . $this->lang->line('View') . '</a> &nbsp; <a href="' . base_url("purchase/printinvoice?id=$invoices->id") . '&d=1" class="btn btn-info btn-xs"  title="Download"><span class="fa fa-download"></span></a>&nbsp; &nbsp;<a href="#" data-object-id="' . $invoices->id . '" class="btn btn-danger btn-xs delete-object"><span class="fa fa-trash"></span></a>';

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

    public function view()
    {
        $this->load->model('accounts_model');
        $data['acclist'] = $this->accounts_model->accountslist((integer)$this->aauth->get_user()->loc);
        $tid = intval($this->input->get('id'));
        $data['id'] = $tid;
        $head['title'] = "Purchase $tid";
        $data['invoice'] = $this->purchase->purchase_details($tid);
        // $data['products'] = $this->purchase->purchase_products($tid);
        $data['products'] = $this->purchase->purchase_product_list($tid);
        $data['activity'] = $this->purchase->purchase_transactions($tid);
        $data['attach'] = $this->purchase->attach($tid);
        $data['employee'] = $this->purchase->employee($data['invoice']['eid']);
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        if ($data['invoice']['tid']) $this->load->view('purchase/view', $data);
        $this->load->view('fixed/footer');

    }


    public function printinvoice()
    {

        $tid = $this->input->get('id');

        $data['id'] = $tid;
        $data['title'] = "Purchase $tid";
        $data['invoice'] = $this->purchase->purchase_details($tid);
        $data['products'] = $this->purchase->purchase_products($tid);
        $data['employee'] = $this->purchase->employee($data['invoice']['eid']);
        $data['invoice']['multi'] = 0;

        $data['general'] = array('title' => $this->lang->line('Purchase Order'), 'person' => $this->lang->line('Supplier'), 'prefix' => prefix(2), 't_type' => 0);


        ini_set('memory_limit', '64M');

        if ($data['invoice']['taxstatus'] == 'cgst' || $data['invoice']['taxstatus'] == 'igst') {
            $html = $this->load->view('print_files/invoice-a4-gst_v' . INVV, $data, true);
        } else {
            $html = $this->load->view('print_files/invoice-a4_v' . INVV, $data, true);
        }

        //PDF Rendering
        $this->load->library('pdf');
        if (INVV == 1) {
            $header = $this->load->view('print_files/invoice-header_v' . INVV, $data, true);
            $pdf = $this->pdf->load_split(array('margin_top' => 40));
            $pdf->SetHTMLHeader($header);
        }
        if (INVV == 2) {
            $pdf = $this->pdf->load_split(array('margin_top' => 5));
        }
        $pdf->SetHTMLFooter('<div style="text-align: right;font-family: serif; font-size: 8pt; color: #5C5C5C; font-style: italic;margin-top:-6pt;">{PAGENO}/{nbpg} #' . $data['invoice']['tid'] . '</div>');

        $pdf->WriteHTML($html);

        if ($this->input->get('d')) {

            $pdf->Output('Purchase_#' . $data['invoice']['tid'] . '.pdf', 'D');
        } else {
            $pdf->Output('Purchase_#' . $data['invoice']['tid'] . '.pdf', 'I');
        }


    }

    public function delete_i()
    {
        $id = $this->input->post('deleteid');

        if ($this->purchase->purchase_delete($id)) {
            echo json_encode(array('status' => 'Success', 'message' =>
                "Purchase Order #$id has been deleted successfully!"));

        } else {

            echo json_encode(array('status' => 'Error', 'message' =>
                "There is an error! Purchase has not deleted."));
        }

    }
    // Srieng modified save to data to tb_stock 26-10-2020
    public function editaction()
    {
        $s_purchaser = $this->input->post("s_purchaser");
        $receive_amount = $this->input->post("receive_amount");
        $s_warehouse = $this->input->post("s_warehouses");
        $currency = $this->input->post('mcurrency');
        $customer_id = $this->input->post('customer_id');
        $invocieno = $this->input->post('iid');
        $invoicedate = $this->input->post('invoicedate');
        $invocieduedate = $this->input->post('invocieduedate');
        $notes = $this->input->post('notes', true);
        $tax = $this->input->post('tax_handle');
        $refer = $this->input->post('refer', true);
        $total = rev_amountExchange_s($this->input->post('total'), $currency, $this->aauth->get_user()->loc);
        $total_tax = 0;
        $total_discount = 0;
        $discountFormat = $this->input->post('discountFormat');
        $pterms = $this->input->post('pterms');
        $ship_taxtype = $this->input->post('ship_taxtype');
        $subtotal = rev_amountExchange_s($this->input->post('subtotal'), $currency, $this->aauth->get_user()->loc);
        $shipping = rev_amountExchange_s($this->input->post('shipping'), $currency, $this->aauth->get_user()->loc);
        $shipping_tax = rev_amountExchange_s($this->input->post('ship_tax'), $currency, $this->aauth->get_user()->loc);
        $product_id = $this->input->post('pid');
        $product_name1 = $this->input->post('product_name', true);
        // Srieng modified 26-10-2020
        $purchase_id= $this->input->post('purchase_id');
        $body_num= $this->input->post('body_number', true);
        $engine_num= $this->input->post('engine_number', true);
        $plate_num= $this->input->post('plate_number', true);
        $other_expense= $this->input->post('other_expense', true);
        $purchase_paidamount = $this->input->post("purchase_paid_amount");
        // End
        if ($ship_taxtype == 'incl') $shipping = $shipping - $shipping_tax;

        $itc = 0;
        if ($discountFormat == '0') {
            $discstatus = 0;
        } else {
            $discstatus = 1;
        }

        if ($customer_id == 0) {
            echo json_encode(array('status' => 'Error', 'message' =>
                "Please add a new supplier or search from a previous added!"));
            exit();
        }

        $this->db->trans_start();
        $flag = false;
        $transok = true;


        //Product Data
        $pid = $this->input->post('pid');
        $productlist = array();

        $prodindex = 0;
        $stock_old_index =0;
        $stock_new_index =0;
        //Check validation
        foreach ($pid as $key => $value) {
          //Check validation when user not input in product name, engine number and body number
          if($product_name1[$key]=="") {
            echo json_encode(array('status' => 'Error', 'message' =>
                    "Product name require!"));
                $transok = false;
                exit;
          }
          if($body_num[$key]=="") {
            echo json_encode(array('status' => 'Error', 'message' =>
                    "Body number require!"));
                $transok = false;
                exit;
          }
          if($engine_num[$key]=="") {
            echo json_encode(array('status' => 'Error', 'message' =>
                    "Engine number require!"));
                $transok = false;
                exit;
          }
          
        // Check validation of product exising with engine number and body number 
          $engineno=$this->db->query("select tb_stock.engine_number from tb_stock 
                        where tb_stock.product_id<>".$product_id[$key]." and tb_stock.engine_number='".$engine_num[$key]."' and tb_stock.body_number='".$body_num[$key]."'")->row()->engine_number;
            if($engineno!=""){
                    echo json_encode(array('status' => 'Error', 'message' =>
                    "This product $product_name1[$key] and body number: $body_num[$key] and engine number: $engine_num[$key] already exist!"));
                $transok = false;
                exit;
            }
          // Check validation of plate number exising
          if($plate_num[$key]!="") {
              $plateno=$this->db->query("select tb_stock.plate_number from tb_stock 
              where tb_stock.product_id<>".$product_id[$key]." and tb_stock.plate_number='".$plate_num[$key]."'")->row()->plate_number;
              if($plateno!=""){
                      echo json_encode(array('status' => 'Error', 'message' =>
                      "This plate number $plate_num[$key] already exist!"));
                  $transok = false;
                  exit;
              }
          }
        }

        $this->db->delete('geopos_purchase_items', array('tid' => $invocieno));
        $this->db->delete('tb_stock', array('purchase_id' => $invocieno));
        
        $product_id = $this->input->post('pid');
        $old_product_id = $this->input->post('old_product_id');
        $product_name1 = $this->input->post('product_name', true);
        
        $product_qty = $this->input->post('product_qty');
        $old_product_qty = $this->input->post('old_product_qty');
        if ($old_product_qty == '') $old_product_qty = 0;
        $product_price = $this->input->post('product_price');
        $product_tax = $this->input->post('product_tax');
        $product_discount = $this->input->post('product_discount');
        $product_subtotal = $this->input->post('product_subtotal');
        $ptotal_tax = $this->input->post('taxa');
        $ptotal_disc = $this->input->post('disca');
        $product_des = $this->input->post('product_description', true);
        $product_unit = $this->input->post('unit');
        $product_hsn = $this->input->post('hsn');
        $purchase_paidamount = $this->input->post("purchase_paid_amount");

        // $purchaseno=array();
        foreach ($pid as $key => $value) {
            $total_discount += numberClean(@$ptotal_disc[$key]);
            $total_tax += numberClean($ptotal_tax[$key]);
            $data = array(
                'tid' => $invocieno,
                'pid' => $product_id[$key]=="" ? $old_product_id[$key] : $product_id[$key],
                'product' => $product_name1[$key],
                'code' => $product_hsn[$key],
                'qty' => numberClean($product_qty[$key]),
                'price' => rev_amountExchange_s($product_price[$key], $currency, $this->aauth->get_user()->loc),
                'tax' => numberClean($product_tax[$key]),
                'discount' => numberClean($product_discount[$key]),
                'subtotal' => rev_amountExchange_s($product_subtotal[$key], $currency, $this->aauth->get_user()->loc),
                'totaltax' => rev_amountExchange_s($ptotal_tax[$key], $currency, $this->aauth->get_user()->loc),
                'totaldiscount' => rev_amountExchange_s($ptotal_disc[$key], $currency, $this->aauth->get_user()->loc),
                'product_des' => $product_des[$key],
                'unit' => $product_unit[$key]
            );


            //save data to tb_stock
            $date = str_replace('/', '-', $invoicedate );
            $newDate = date("Y-m-d", strtotime($date));
            //if($purchase_id[$key]==0) {
              $data_stock_new = array(
                'product_id' => $product_id[$key],
                'warehouse_id' => $s_warehouse,
                'body_number'  => $body_num[$key],
                'engine_number' =>$engine_num[$key],
                'plate_number' => $plate_num [$key],
                'other_expense' => $other_expense[$key],
                'total' => rev_amountExchange_s($product_price[$key], $currency, $this->aauth->get_user()->loc),
                'purchase_date' => $newDate,
                'purchase_id' => $invocieno,
                'tax' => numberClean($product_tax[$key]),
                'discount' => numberClean($product_discount[$key]),
                'subtotal' => rev_amountExchange_s($product_subtotal[$key], $currency, $this->aauth->get_user()->loc),
                'totaltax' => rev_amountExchange_s($ptotal_tax[$key], $currency, $this->aauth->get_user()->loc),
                'totaldiscount' => rev_amountExchange_s($ptotal_disc[$key], $currency, $this->aauth->get_user()->loc),
                'product_des' => $product_des[$key],
                'unit' => $product_unit[$key],
                'purchase_remain_amount' => rev_amountExchange_s($product_subtotal[$key], $currency, $this->aauth->get_user()->loc)-$purchase_paidamount[$key],
                'purchase_paid_amount' => $purchase_paidamount[$key],
              );
              // $stock_new_index++;
              $stocklist_new[$stock_new_index] = $data_stock_new;
              
            // } else {
            //     $data_stock_edit = array(
            //     'id' => $purchase_id[$key],
            //     'product_id' => $old_product_id[$key],
            //     'warehouse_id' => $s_warehouse,
            //     'body_number'  => $body_num[$key],
            //     'engine_number' =>$engine_num[$key],
            //     'plate_number' => $plate_num [$key],
            //     'other_expense' => $other_expense[$key],
            //     'total' => rev_amountExchange_s($product_price[$key]+$other_expense[$key], $currency, $this->aauth->get_user()->loc),
            //     'purchase_date' => $newDate,
            //     'purchase_id' => $invocieno,
            //     'tax' => numberClean($product_tax[$key]),
            //     'discount' => numberClean($product_discount[$key]),
            //     'subtotal' => rev_amountExchange_s($product_subtotal[$key], $currency, $this->aauth->get_user()->loc),
            //     'totaltax' => rev_amountExchange_s($ptotal_tax[$key], $currency, $this->aauth->get_user()->loc),
            //     'totaldiscount' => rev_amountExchange_s($ptotal_disc[$key], $currency, $this->aauth->get_user()->loc),
            //     'product_des' => $product_des[$key],
            //     'unit' => $product_unit[$key]
            //   );
            //   $stocklist_update[$stock_old_index] = $data_stock_edit;
            //   $stock_old_index++;
            //   print_r($data_stock_edit);
            // }
            // print_r($purchase_id[$key]);
            // if($purchase_id[$key]==0) {
            //   print_r("ok");
            //   $data_stock_new = array(
            //     'product_id' => $product_id[$key],
            //     'warehouse_id' => $s_warehouse,
            //     'body_number'  => $body_num[$key],
            //     'engine_number' =>$engine_num[$key],
            //     'plate_number' => $plate_num [$key],
            //     'other_expense' => $other_expense[$key],
            //     'total' => rev_amountExchange_s($product_price[$key]+$other_expense[$key], $currency, $this->aauth->get_user()->loc),
            //     'purchase_date' => $newDate,
            //     'purchase_id' => $invocieno
            //   );
            //   $stock_new_index ++;
            //   print_r($data_stock_new);
            // } else {
            //   $data_stock_edit = array(
            //     'id' => $purchase_id[$key],
            //     'product_id' => $old_product_id[$key],
            //     'warehouse_id' => $s_warehouse,
            //     'body_number'  => $body_num[$key],
            //     'engine_number' =>$engine_num[$key],
            //     'plate_number' => $plate_num [$key],
            //     'other_expense' => $other_expense[$key],
            //     'total' => rev_amountExchange_s($product_price[$key]+$other_expense[$key], $currency, $this->aauth->get_user()->loc),
            //     'purchase_date' => $newDate,
            //     'purchase_id' => $invocieno
            //   );
            //   $stock_old_index++;
            // }
            


            $productlist[$prodindex] = $data;
            // $stocklist_update[$stock_old_index] = $data_stock_edit;
            
            // print_r("stock new index $stock_new_index");

            $prodindex++;
            $stock_new_index++;
            $amt = numberClean($product_qty[$key]);
            $itc += $amt;

            if ($this->input->post('update_stock') == 'yes') {
                $amt = numberClean(@$product_qty[$key]) - numberClean(@$old_product_qty[$key]);
                $this->db->set('qty', "qty+$amt", FALSE);
                $this->db->where('pid', $product_id[$key]);
                $this->db->update('geopos_products');
                
            }
            $flag = true;
        }

        $bill_date = datefordatabase($invoicedate);
        $bill_due_date = datefordatabase($invocieduedate);
        $total_discount = rev_amountExchange_s(amountFormat_general($total_discount), $currency, $this->aauth->get_user()->loc);
        $total_tax = rev_amountExchange_s(amountFormat_general($total_tax), $currency, $this->aauth->get_user()->loc);

        $data = array('invoicedate' => $bill_date, 'invoiceduedate' => $bill_due_date, 'subtotal' => $subtotal, 'shipping' => $shipping, 'ship_tax' => $shipping_tax, 'ship_tax_type' => $ship_taxtype, 'discount' => $total_discount, 'tax' => $total_tax, 'total' => $total, 'notes' => $notes, 'csd' => $customer_id, 'items' => $itc, 'taxstatus' => $tax, 'discstatus' => $discstatus, 'format_discount' => $discountFormat, 'refer' => $refer, 'term' => $pterms, 'multi' => $currency,'purchaser_id'=>$s_purchaser, 'pamnt'=>$receive_amount);
        $this->db->set($data);
        $this->db->where('id', $invocieno);
        // print_r("stock new");
        if ($flag) {
            if ($this->db->update('geopos_purchase', $data)) {
                $this->db->insert_batch('geopos_purchase_items', $productlist);
                //$this->db->update_batch('tb_stock',$stocklist_update,'id');
                // print_r($stocklist_new);
                $this->db->insert_batch('tb_stock', $stocklist_new);
                // print_r($purchaseno);
                // print_r("count: ".count($purchaseno));
                // for($i=0;$i<=count($purchaseno);$i++) {
                //   echo $purchaseno[$i]."<br/>";
                // }
                //$this->db->insert_batch('tb_stock', $stocklist);
                // $this->db->where('purchase_id', $invocieno);
                echo json_encode(array('status' => 'Success', 'message' =>
                    "Purchase order has  been updated successfully! <a href='view?id=$invocieno' class='btn btn-info btn-lg'><span class='fa fa-eye' aria-hidden='true'></span> View </a> "));
            } else {
                echo json_encode(array('status' => 'Error', 'message' =>
                    "There is a missing field!"));
                $transok = false;
            }
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                "Please add atleast one product in order!"));
            $transok = false;
        }

        if ($this->input->post('update_stock') == 'yes') {
            if ($this->input->post('restock')) {
                foreach ($this->input->post('restock') as $key => $value) {
                    $myArray = explode('-', $value);
                    $prid = $myArray[0];
                    $dqty = numberClean($myArray[1]);
                    if ($prid > 0) {

                        $this->db->set('qty', "qty-$dqty", FALSE);
                        $this->db->where('pid', $prid);
                        $this->db->update('geopos_products');
                    }
                }

            }
        }


        if ($transok) {
            $this->db->trans_complete();
        } else {
            $this->db->trans_rollback();
        }
    }

    // public function editaction()
    // {
    //     $currency = $this->input->post('mcurrency');
    //     $customer_id = $this->input->post('customer_id');
    //     $invocieno = $this->input->post('iid');
    //     $invoicedate = $this->input->post('invoicedate');
    //     $invocieduedate = $this->input->post('invocieduedate');
    //     $notes = $this->input->post('notes', true);
    //     $tax = $this->input->post('tax_handle');
    //     $refer = $this->input->post('refer', true);
    //     $total = rev_amountExchange_s($this->input->post('total'), $currency, $this->aauth->get_user()->loc);
    //     $total_tax = 0;
    //     $total_discount = 0;
    //     $discountFormat = $this->input->post('discountFormat');
    //     $pterms = $this->input->post('pterms');
    //     $ship_taxtype = $this->input->post('ship_taxtype');
    //     $subtotal = rev_amountExchange_s($this->input->post('subtotal'), $currency, $this->aauth->get_user()->loc);
    //     $shipping = rev_amountExchange_s($this->input->post('shipping'), $currency, $this->aauth->get_user()->loc);
    //     $shipping_tax = rev_amountExchange_s($this->input->post('ship_tax'), $currency, $this->aauth->get_user()->loc);
    //     if ($ship_taxtype == 'incl') $shipping = $shipping - $shipping_tax;

    //     $itc = 0;
    //     if ($discountFormat == '0') {
    //         $discstatus = 0;
    //     } else {
    //         $discstatus = 1;
    //     }

    //     if ($customer_id == 0) {
    //         echo json_encode(array('status' => 'Error', 'message' =>
    //             "Please add a new supplier or search from a previous added!"));
    //         exit();
    //     }

    //     $this->db->trans_start();
    //     $flag = false;
    //     $transok = true;


    //     //Product Data
    //     $pid = $this->input->post('pid');
    //     $productlist = array();

    //     $prodindex = 0;

    //     $this->db->delete('geopos_purchase_items', array('tid' => $invocieno));
    //     $product_id = $this->input->post('pid');
    //     $product_name1 = $this->input->post('product_name', true);
    //     $product_qty = $this->input->post('product_qty');
    //     $old_product_qty = $this->input->post('old_product_qty');
    //     if ($old_product_qty == '') $old_product_qty = 0;
    //     $product_price = $this->input->post('product_price');
    //     $product_tax = $this->input->post('product_tax');
    //     $product_discount = $this->input->post('product_discount');
    //     $product_subtotal = $this->input->post('product_subtotal');
    //     $ptotal_tax = $this->input->post('taxa');
    //     $ptotal_disc = $this->input->post('disca');
    //     $product_des = $this->input->post('product_description', true);
    //     $product_unit = $this->input->post('unit');
    //     $product_hsn = $this->input->post('hsn');

    //     foreach ($pid as $key => $value) {
    //         $total_discount += numberClean(@$ptotal_disc[$key]);
    //         $total_tax += numberClean($ptotal_tax[$key]);
    //         $data = array(
    //             'tid' => $invocieno,
    //             'pid' => $product_id[$key],
    //             'product' => $product_name1[$key],
    //             'code' => $product_hsn[$key],
    //             'qty' => numberClean($product_qty[$key]),
    //             'price' => rev_amountExchange_s($product_price[$key], $currency, $this->aauth->get_user()->loc),
    //             'tax' => numberClean($product_tax[$key]),
    //             'discount' => numberClean($product_discount[$key]),
    //             'subtotal' => rev_amountExchange_s($product_subtotal[$key], $currency, $this->aauth->get_user()->loc),
    //             'totaltax' => rev_amountExchange_s($ptotal_tax[$key], $currency, $this->aauth->get_user()->loc),
    //             'totaldiscount' => rev_amountExchange_s($ptotal_disc[$key], $currency, $this->aauth->get_user()->loc),
    //             'product_des' => $product_des[$key],
    //             'unit' => $product_unit[$key]
    //         );


    //         $productlist[$prodindex] = $data;

    //         $prodindex++;
    //         $amt = numberClean($product_qty[$key]);
    //         $itc += $amt;

    //         if ($this->input->post('update_stock') == 'yes') {
    //             $amt = numberClean(@$product_qty[$key]) - numberClean(@$old_product_qty[$key]);
    //             $this->db->set('qty', "qty+$amt", FALSE);
    //             $this->db->where('pid', $product_id[$key]);
    //             $this->db->update('geopos_products');
    //         }
    //         $flag = true;
    //     }

    //     $bill_date = datefordatabase($invoicedate);
    //     $bill_due_date = datefordatabase($invocieduedate);
    //     $total_discount = rev_amountExchange_s(amountFormat_general($total_discount), $currency, $this->aauth->get_user()->loc);
    //     $total_tax = rev_amountExchange_s(amountFormat_general($total_tax), $currency, $this->aauth->get_user()->loc);

    //     $data = array('invoicedate' => $bill_date, 'invoiceduedate' => $bill_due_date, 'subtotal' => $subtotal, 'shipping' => $shipping, 'ship_tax' => $shipping_tax, 'ship_tax_type' => $ship_taxtype, 'discount' => $total_discount, 'tax' => $total_tax, 'total' => $total, 'notes' => $notes, 'csd' => $customer_id, 'items' => $itc, 'taxstatus' => $tax, 'discstatus' => $discstatus, 'format_discount' => $discountFormat, 'refer' => $refer, 'term' => $pterms, 'multi' => $currency);
    //     $this->db->set($data);
    //     $this->db->where('id', $invocieno);

    //     if ($flag) {

    //         if ($this->db->update('geopos_purchase', $data)) {
    //             $this->db->insert_batch('geopos_purchase_items', $productlist);
    //             echo json_encode(array('status' => 'Success', 'message' =>
    //                 "Purchase order has  been updated successfully! <a href='view?id=$invocieno' class='btn btn-info btn-lg'><span class='fa fa-eye' aria-hidden='true'></span> View </a> "));
    //         } else {
    //             echo json_encode(array('status' => 'Error', 'message' =>
    //                 "There is a missing field!"));
    //             $transok = false;
    //         }


    //     } else {
    //         echo json_encode(array('status' => 'Error', 'message' =>
    //             "Please add atleast one product in order!"));
    //         $transok = false;
    //     }

    //     if ($this->input->post('update_stock') == 'yes') {
    //         if ($this->input->post('restock')) {
    //             foreach ($this->input->post('restock') as $key => $value) {
    //                 $myArray = explode('-', $value);
    //                 $prid = $myArray[0];
    //                 $dqty = numberClean($myArray[1]);
    //                 if ($prid > 0) {

    //                     $this->db->set('qty', "qty-$dqty", FALSE);
    //                     $this->db->where('pid', $prid);
    //                     $this->db->update('geopos_products');
    //                 }
    //             }

    //         }
    //     }


    //     if ($transok) {
    //         $this->db->trans_complete();
    //     } else {
    //         $this->db->trans_rollback();
    //     }
    // }

    public function update_status()
    {
        $tid = $this->input->post('tid');
        $status = $this->input->post('status');


        $this->db->set('status', $status);
        $this->db->where('id', $tid);
        $this->db->update('geopos_purchase');

        echo json_encode(array('status' => 'Success', 'message' =>
            'Purchase Order Status updated successfully!', 'pstatus' => $status));
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