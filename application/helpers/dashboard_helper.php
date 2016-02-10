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
        $CI->db->select('pa.product_id');
        $CI->db->where('pa.status', 1);
        $sub = $CI->db->get_compiled_select();

        $CI->db->from($CI->config->item('table_product').' product');
        $CI->db->select('product.warehouse_id,  count(product.id) as number_of_product');
        $CI->db->group_by('product.warehouse_id');
        $CI->db->where("product.id NOT IN ($sub)", NULL, FALSE);
        $no_of_product = $CI->db->get()->result_array();
        $product = array();
        foreach ($no_of_product as $p) {
            $product[$p['warehouse_id']] = $p['number_of_product'];
        }

        $CI->db->from($CI->config->item('table_warehouse').' warehouse');
        $CI->db->select('warehouse.id, warehouse.warehouse_name');
        $results = $CI->db->get()->result_array();

        foreach($results as &$result)
            $result['number_of_product'] = isset($product[$result['id']]) ? $product[$result['id']] : 0;
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
//  get_recent_assigned_ticket
    public static function get_recent_assigned_ticket()
    {
        $data =array();
        $user = User_helper::get_user();
        $CI = & get_instance();
        $CI->db->select("ticket_assign.id,
                            ticket_assign.ticket_issue_id,
                            ticket_assign.create_date,
                            ticket_assign.`status`,
                            `ticket_issue`.`subject`,
                            product.product_name,
                            users.name_bn,
                            users_assign.name_bn support_name,
                            ticket_assign.resolved_date");
        $CI->db->from($CI->config->item('table_ticket_assign').' ticket_assign');
        $CI->db->where('ticket_assign.user_id', $user->id);
        $CI->db->join($CI->config->item('table_ticket_issue').' ticket_issue','ticket_issue.id = ticket_assign.ticket_issue_id', 'INNER');
        $CI->db->join($CI->config->item('table_users').' users','users.id = ticket_issue.user_id', 'INNER');
        $CI->db->join($CI->config->item('table_users').' users_assign','users_assign.id = ticket_assign.user_id', 'INNER');
        $CI->db->join($CI->config->item('table_product').' product','product.id = ticket_issue.product_id', 'INNER');
        $CI->db->where('ticket_assign.status ='. $CI->config->item('STATUS_ASSIGN'));
        $CI->db->order_by('ticket_assign.ticket_issue_id', 'DESC');
        $data = $CI->db->get()->result_array();
        return $data;
    }

}