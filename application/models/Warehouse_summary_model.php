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

class Warehouse_summary_model extends CI_Model
{
    var $table = 'tb_stock';
    var $column_order = array(null,'geopos_warehouse.id','geopos_product_cat.title','geopos_products.product_name','geopos_products.year', null);
    var $column_search = array('geopos_product_cat.title','geopos_products.product_name','geopos_products.color','geopos_products.year','geopos_warehouse.title','if(tb_stock.plate_number="","ថ្មី","មានស្លាកលេខ")');
   // var $order = array('geopos_warehouse.id' => 'desc');

    public function __construct()
    {
        parent::__construct();
    }

    private function _get_datatables_query()
    {
        $this->db->select('geopos_product_cat.title AS category,geopos_products.product_name,geopos_products.color,geopos_products.year,geopos_warehouse.title AS warehouse
        ,sum(tb_stock.purchase_qty) AS qty,geopos_product_cat.id AS cat_id,geopos_products.pid,if(tb_stock.plate_number="","ថ្មី","មានស្លាកលេខ") AS plate_number,geopos_warehouse.id AS warehouse_id,
        geopos_product_cat.id as category_id');

        $this->db->from($this->table);
        $this->db->where('tb_stock.status', "in-stock");  
        $this->db->group_by(array("geopos_product_cat.title", "geopos_products.color","geopos_products.year","geopos_warehouse.id","if(tb_stock.plate_number='','New','Old')"));           
        $this->db->order_by('geopos_warehouse.id ASC,geopos_product_cat.title ASC,geopos_products.product_name ASC');
        
        $this->db->join('geopos_warehouse', '`geopos_warehouse`.`id`=`tb_stock`.`warehouse_id`', 'left');
        $this->db->join('geopos_products', '`tb_stock`.`product_id`=`geopos_products`.`pid`', 'left');
        $this->db->join('geopos_product_cat', '`geopos_product_cat`.`id`= `geopos_products`.`pcat`', 'left');
 
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
            $this->db->where('tb_stock.status', 'in-stock');
        }
        elseif(!BDATA) { $this->db->where('tb_stock.status', 'in-stock'); }
        return $this->db->count_all_results();
    }
}