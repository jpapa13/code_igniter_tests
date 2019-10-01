<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pagination_lib {
    protected $CI;

    // We'll use a constructor, as you can't directly call a function
    // from a property definition.
    public function __construct()
    {
        // Assign the CodeIgniter super-object
        $this->CI =& get_instance();
    }

    public function response($request,$result,$total)
    {
        return array(
            'rows'=>$result,
            'rows_count'=>count($result),
            'rows_total'=>$total,
            'rows_actual'=>(isset($request['draw'])?$request['draw']:0)
        );
    }
    public function render($request,$search_columns,$order)
    {
        if(isset($request['length']) && isset($request['start'])){
            $this->CI->db->limit($request['length'],$request['start']);
        }
        if(!empty($request['search']['value'])){
            $this->CI->db->group_start();
            $search = mb_strtolower($request['search']['value']);
            foreach($search_columns as $val){
                $this->CI->db->or_like($val,$search);
            }
            $this->CI->db->group_end();
        }
        if(!empty($request['order'])){
            $this->CI->db->order_by($order[$request['order'][0]['column']],$request['order'][0]['dir']);
        }
    }
    public function render_count($request,$search_columns)
    {
        if(!empty($request['search']['value'])){
            $this->CI->db->group_start();
            $search = mb_strtolower($request['search']['value']);
            foreach($search_columns as $val){
                $this->CI->db->or_like($val,$search);
            }
            $this->CI->db->group_end();
        }
    }
}
