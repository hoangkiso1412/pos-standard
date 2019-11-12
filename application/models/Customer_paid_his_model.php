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

class Customer_paid_his_model extends CI_Model
{
    var $table = 'geopos_transactions';
   // var $column_order = array(null,'geopos_transactions.date','payer', null);
    var $column_search = array('geopos_transactions.date','payer','`geopos_warehouse`.`title`','`geopos_product_cat`.`title`',' `geopos_products`.`product_name`','`tb_stock`.`engine_number`','`tb_stock`.`body_number`');

    public function __construct()
    {
        parent::__construct();
    }

    private function _get_datatables_query()
    {
        $this->db->select('tb_stock.id,tb_stock.sold_date AS invoicedate,
        DATE_FORMAT(geopos_transactions.date,"%d-%m-%Y") AS `trans_date`,
         `geopos_warehouse`.`title` AS `stock`,geopos_transactions.payer,`geopos_product_cat`.`title` AS `product_type`,
         `geopos_products`.`product_name` AS `product_name`,tb_stock.purchase_qty AS `qty`,`geopos_products`.`color` AS `color`,
         `geopos_products`.`year` AS `year`, IF((`tb_stock`.`plate_number` = ""),"ថ្មី",`tb_stock`.`plate_number`) AS `conditions_plateNumber`,`tb_stock`.`body_number` AS `body_number`,
         `tb_stock`.`engine_number` AS `engine_number`,tb_stock.selling_price,geopos_transactions.credit AS paid_amount, geopos_transactions.remain_amount,
         geopos_transactions.note,geopos_product_cat.id AS cat_id, 
        tb_stock.sale_detail_id,geopos_warehouse.id,geopos_invoices.id as invid,geopos_transactions.id');

        $this->db->from($this->table);
        
        $this->db->where('geopos_transactions.`type` =', 'Income');
        $this->db->where('geopos_transactions.cat =', 'Sales');

        $this->db->join('tb_stock', 'geopos_transactions.other_id=tb_stock.id', 'inner');
        $this->db->join('geopos_warehouse', '`geopos_warehouse`.`id`=`tb_stock`.`warehouse_id`', 'inner');
        $this->db->join('geopos_products', '`tb_stock`.`product_id`=`geopos_products`.`pid`', 'inner');
        $this->db->join('geopos_product_cat', '`geopos_product_cat`.`id`= `geopos_products`.`pcat`', 'inner');
        $this->db->join('geopos_invoice_items', 'geopos_invoice_items.id = tb_stock.sale_detail_id', 'inner');
        $this->db->join('geopos_invoices', 'geopos_invoices.id = geopos_invoice_items.tid', 'inner');
       
        $this->db->order_by('geopos_transactions.id', 'DESC');

            if ($this->aauth->get_user()->loc) {
            $this->db->where('geopos_purchase.loc', $this->aauth->get_user()->loc);
        }
        elseif(!BDATA) { $this->db->where('geopos_purchase.loc', 0); }
                    if ($this->input->post('start_date') && $this->input->post('end_date') && $this->input->post('customer')) // if datatable send POST for search
        {
            $this->db->where('DATE(geopos_transactions.date) >=', datefordatabase($this->input->post('start_date')));
            $this->db->where('DATE(geopos_transactions.date) <=', datefordatabase($this->input->post('end_date')));
            $this->db->where('geopos_transactions.payer = ', $this->input->post('customer'));

        }elseif($this->input->post('start_date') && $this->input->post('end_date')){
            $this->db->where('DATE(geopos_transactions.date) >=', datefordatabase($this->input->post('start_date')));
            $this->db->where('DATE(geopos_transactions.date) <=', datefordatabase($this->input->post('end_date')));
            
        }
        



        $i = 0;
        foreach ($this->column_search as $item) // loop column
        {
            if ($this->input->post('search')['value']) // if datatable send POST for search
            {

                if ($i === 0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $this->input->post('search')['value']);
                } else {
                    $this->db->or_like($item, $this->input->post('search')['value']);
                }

                if (count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables()
    {
        $this->_get_datatables_query();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all()
    {
        $this->db->from($this->table);
           if ($this->aauth->get_user()->loc) {
            $this->db->where('geopos_transactions.`type` =', 'Income');
            $this->db->where('geopos_transactions.cat =', 'Sales');
        }
        elseif(!BDATA) {  $this->db->where('geopos_transactions.`type` =', 'Income');
            $this->db->where('geopos_transactions.cat =', 'Sales'); }
        return $this->db->count_all_results();
    }
}