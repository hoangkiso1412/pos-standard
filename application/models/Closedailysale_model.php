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

class Closedailysale_model extends CI_Model
{
    var $table = 'geopos_register';
    //var $column_order = array(null,'tb_stock.purchase_date', '`geopos_warehouse`.`title`','`geopos_products`.`product_name`','`geopos_products`.`color`','`tb_stock`.`body_number`','`tb_stock`.`engine_number`','`geopos_products`.`year`', null);
    //var $column_search = array('tb_stock.purchase_date','`geopos_warehouse`.`title`','`geopos_products`.`product_name`','`geopos_products`.`color`','`geopos_products`.`year`','`tb_stock`.`body_number`','`tb_stock`.`engine_number`','`tb_stock`.`plate_number`');
   // var $order = array('tb_stock.id' => 'desc');

    public function __construct()
    {
        parent::__construct();
    }

    private function _get_datatables_query()
    {
        $this->db->select('geopos_register.o_date, geopos_register.c_date,geopos_register.cash,geopos_register.in_amount,geopos_register.out_amount');
        $this->db->from($this->table);

        if ($this->aauth->get_user()->loc) {
            $this->db->where('geopos_purchase.loc', $this->aauth->get_user()->loc);
        }
        elseif(!BDATA) { $this->db->where('geopos_purchase.loc', 0); }
            if ($this->input->post('start_date') && $this->input->post('end_date')) // if datatable send POST for search
        {
            $this->db->where('DATE(tb_stock.purchase_date) >=', datefordatabase($this->input->post('start_date')));
            $this->db->where('DATE(tb_stock.purchase_date) <=', datefordatabase($this->input->post('end_date')));
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
            $this->db->where('geopos_purchase.loc', $this->aauth->get_user()->loc);
        }
        elseif(!BDATA) { $this->db->where('geopos_purchase.loc', 0); }
        return $this->db->count_all_results();
    }
}