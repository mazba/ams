<?php
class Dashboard_helper
{
    // get_recent_ticket_issue
    public static function get_recent_ticket_issue()
    {
        $CI = & get_instance();
        $CI->db->from($CI->config->item('table_ticket_issue').' ticket_issue');
        $CI->db->limit(10);
        $CI->db->order_by('id','DESC');
//        $CI->db->join($CI->config->item('table_services_uisc').' services_uisc' ,'services_uisc.uisc_id = uisc_infos.id','INNER' );
        $results = $CI->db->get()->result_array();
        return $results;
    }
    // get_warehouse_product_info
    public static function get_warehouse_product_info()
    {
        $CI = & get_instance();
        $CI->db->from($CI->config->item('table_product_assign').' pa');
        $CI->db->select('pa.id');
        $CI->db->where('pa.status', 1);
        $sub = $CI->db->get_compiled_select();

        $CI->db->from($CI->config->item('table_product').' product');
        $CI->db->select('COUNT(product.id) as number_of_product');
        $CI->db->select('warehouse.warehouse_name');
        $CI->db->where("product.id NOT IN ($sub)", NULL, FALSE);
        $CI->db->group_by('warehouse.id');
        $CI->db->join($CI->config->item('table_warehouse').' warehouse' ,'warehouse.id = product.warehouse_id','LEFT OUTER' );
        $results = $CI->db->get()->result_array();
        return $results;
    }
    // get_warehouse_product_info
    public static function get_ticket_status_info()
    {
        $CI = & get_instance();
        $CI->db->from($CI->config->item('table_ticket_issue').' ticket_issue');
        $CI->db->select('count(ticket_issue.id) number_of_ticket, status');
        $CI->db->group_by('ticket_issue.status');
        $results = $CI->db->get()->result_array();
        $data = array();
        foreach($results as $dd)
        {
            $data[$dd['status']] = $dd['number_of_ticket'];
        }
        return $data;
    }
    // get_my_product_list
    public static function get_my_product_list()
    {
        $CI = & get_instance();
        $user =  User_helper::get_user();
        $CI->db->from($CI->config->item('table_product_assign').' pa');
        $CI->db->select('product.product_name,pa.assign_date,pa.return_date');
        $CI->db->where('pa.user_id',$user->id);
        $CI->db->where('pa.status',1);
        $CI->db->join($CI->config->item('table_product').' product' ,'product.id = pa.product_id','LEFT' );
        $results = $CI->db->get()->result_array();
        return $results;
    }
//    get_recent_ticket_issue_by_user
    public static function get_recent_ticket_issue_by_user()
    {
        $user = User_helper::get_user();
        $CI = & get_instance();
        $CI->db->from($CI->config->item('table_ticket_issue').' ticket_issue');
        $CI->db->where('user_id',$user->id);
        $CI->db->limit(5);
        $CI->db->order_by('id','DESC');
        $results = $CI->db->get()->result_array();
        return $results;
    }
//    get_requisition_info
    public static function get_requisition_info()
    {
        $data =array();
        $CI = & get_instance();
        $CI->db->from($CI->config->item('table_requisition').' requisition');
        $CI->db->select('count(requisition.id) total_requisition');
        $results = $CI->db->get()->result_array();
        $data['total_requisition'] = isset($results[0]['total_requisition']) ? $results[0]['total_requisition'] : 0;

        $CI->db->from($CI->config->item('table_requisition').' requisition');
        $CI->db->select('count(requisition.id) today_requisition');
        $CI->db->where('requisition.create_date >',strtotime("today midnight"));
        $results = $CI->db->get()->result_array();
        $data['today_requisition'] = isset($results[0]['today_requisition']) ? $results[0]['today_requisition'] : 0;
        return $data;
    }

}