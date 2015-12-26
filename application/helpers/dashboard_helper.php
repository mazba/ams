<?php
class Dashboard_helper
{
    // Center Count
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

}