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

class Purchase_model_master_detail extends CI_Model
{
    var $table = 'v_purchase_detail';
    var $column_order = array(null,'invoicedate', 'title','product_type','product_name','conditions_plateNumber','body_number','engine_number','notes', null);
    var $column_search = array('invoicedate','title','product_type','product_name','conditions_plateNumber','body_number','engine_number','notes','color','year');
    //var $order = array('geopos_purchase.tid' => 'desc');

    public function __construct()
    {
        parent::__construct();
    }

    private function _get_datatables_query()
    {
        $this->db->select('v_purchase_detail.invoicedate,v_purchase_detail.title,v_purchase_detail.product_type,v_purchase_detail.product_name,v_purchase_detail.items,v_purchase_detail.color,v_purchase_detail.year,v_purchase_detail.conditions_plateNumber,v_purchase_detail.body_number,v_purchase_detail.engine_number,v_purchase_detail.Seller,v_purchase_detail.total,v_purchase_detail.remain_amount,v_purchase_detail.paid_amount,v_purchase_detail.notes');
        $this->db->from($this->table);
        
            if ($this->aauth->get_user()->loc) {
            $this->db->where('v_purchase_detail.loc', $this->aauth->get_user()->loc);
        }
        elseif(!BDATA) { $this->db->where('v_purchase_detail.loc', 0); }
                    if ($this->input->post('start_date') && $this->input->post('end_date')) // if datatable send POST for search
        {
            $this->db->where('DATE(v_purchase_detail.invoicedate) >=', datefordatabase($this->input->post('start_date')));
            $this->db->where('DATE(v_purchase_detail.invoicedate) <=', datefordatabase($this->input->post('end_date')));
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