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

class Sale_detail_model extends CI_Model
{
    var $table = 'tb_stock';
    var $column_order = array(null,'tb_stock.purchase_date', '`geopos_warehouse`.`title`','`geopos_products`.`product_name`','`geopos_products`.`color`','`tb_stock`.`body_number`','`tb_stock`.`engine_number`','tb_stock.subtotal','tb_stock.purchase_remain_amount','tb_stock.purchase_paid_amount','`geopos_products`.`year`', null);
    var $column_search = array('geopos_invoices.customer_info','tb_stock.purchase_date','`geopos_warehouse`.`title`','`geopos_products`.`product_name`','`geopos_products`.`color`','`geopos_products`.`year`','`tb_stock`.`body_number`','`tb_stock`.`engine_number`','`tb_stock`.`plate_number`');
    var $order = array('geopos_invoices.id' => 'desc');

    public function __construct()
    {
        parent::__construct();
    }

    private function _get_datatables_query()
    {
        $this->db->select('DATE_FORMAT(tb_stock.sold_date,"%d-%m-%Y") AS `invoicedate`,
        `geopos_warehouse`.`title` AS `stock`,`geopos_product_cat`.`title` AS `product_type`,
        `geopos_products`.`product_name` AS `product_name`,tb_stock.purchase_qty AS `items`,`geopos_products`.`color` AS `color`,
       `geopos_products`.`year` AS `year`, IF((`tb_stock`.`plate_number` = ""),"ថ្មី",`tb_stock`.`plate_number`) AS `conditions_plateNumber`,`tb_stock`.`body_number` AS `body_number`,
       `tb_stock`.`engine_number` AS `engine_number`,tb_stock.selling_price,tb_stock.paid_amount,tb_stock.remain_amount,
       tb_stock.sold_date,geopos_invoices.notes,geopos_product_cat.id as cat_id,
       DATE_FORMAT(tb_stock.sold_date,"%d-%m-%Y") as sold_date,tb_stock.sale_detail_id,SUBSTRING_INDEX(geopos_invoices.customer_info, "*:", 1) buyer,geopos_warehouse.id,(SELECT geopos_transactions.date from geopos_transactions WHERE geopos_transactions.other_id = tb_stock.id  ORDER BY geopos_transactions.date DESC LIMIT 1 ) AS paid_date,geopos_invoices.id as invid,IF((tb_stock.status = "sold-out"),(tb_stock.selling_price - tb_stock.total),"0.00") AS income,tb_stock.total as purchase_price,tb_stock.id as stock_id,if(ifnull(profit_amount,0)=0,IF((tb_stock.status = "sold-out"),(tb_stock.selling_price - tb_stock.total),"0.00"),ifnull(profit_amount,0)) as profit_amount');
        $this->db->from($this->table);
       
        
        if ($this->input->post('start_date') && $this->input->post('end_date') && $this->input->post('stock')) // if datatable send POST for search
        {
            $this->db->where('DATE(tb_stock.sold_date) >=', datefordatabase($this->input->post('start_date')));
            $this->db->where('DATE(tb_stock.sold_date) <=', datefordatabase($this->input->post('end_date')));
            $this->db->where('`geopos_warehouse`.`id` = ', $this->input->post('stock'));

        }elseif($this->input->post('start_date') && $this->input->post('end_date')){
            $this->db->where('DATE(tb_stock.sold_date) >=', datefordatabase($this->input->post('start_date')));
            $this->db->where('DATE(tb_stock.sold_date) <=', datefordatabase($this->input->post('end_date')));
            
        }        
        $this->db->join('geopos_warehouse', '`geopos_warehouse`.`id`=`tb_stock`.`warehouse_id`', 'left');
        $this->db->join('geopos_products', '`tb_stock`.`product_id`=`geopos_products`.`pid`', 'left');
        $this->db->join('geopos_product_cat', '`geopos_product_cat`.`id`= `geopos_products`.`pcat`', 'left');
        $this->db->join('geopos_invoice_items', 'geopos_invoice_items.id = tb_stock.sale_detail_id', 'inner');
        $this->db->join('geopos_invoices', 'geopos_invoices.id = geopos_invoice_items.tid', 'inner');



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
            $this->db->where('geopos_purchase.loc', $this->aauth->get_user()->loc);
        }
        elseif(!BDATA) { $this->db->where('geopos_purchase.loc', 0); }
        return $this->db->count_all_results();
    }
	
}