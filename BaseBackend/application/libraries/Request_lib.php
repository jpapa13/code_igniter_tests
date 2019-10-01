<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Request_lib {
    protected $CI;

    // We'll use a constructor, as you can't directly call a function
    // from a property definition.
    public function __construct()
    {
            // Assign the CodeIgniter super-object
            $this->CI =& get_instance();
            $this->CI->load->library("form_validation");
    }

    public function validar($request = [],$rules = [])
    {
        $this->CI->form_validation->set_data($request);
        $this->CI->form_validation->set_rules($rules);
        return $this->CI->form_validation->run();
    }
}
