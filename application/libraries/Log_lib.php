<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Log_lib
{
    protected $CI;

    public function __construct()
    {
        $this->CI = &get_instance();

        $this->CI->load->helper('url');
        $this->CI->config->item('base_url');
        $this->CI->load->library('session');
        $this->CI->load->library('user_agent');
        $this->CI->load->database();
    }

    public function log_info($aktifitas)
    {
        //get user from session
        $user = "";
        if ($this->CI->session->userdata('nip') != null) {
            $user =  $this->CI->session->userdata('nip') . " - " . $this->CI->session->userdata('nama');
        }

        if ($this->CI->session->userdata('nis') != null) {
            $user =  $this->CI->session->userdata('nis') . " - " . $this->CI->session->userdata('nama');
        }


        //get datetime
        $waktu_log     = date('Y-m-d H:i:s');

        //get ip address
        $iplog = $this->CI->input->ip_address();

        //get browser and OS
        //$browser = get_browser(null, true);
        $user_os    = $this->CI->agent->platform();
        $ua         = $this->CI->agent->browser() . " (" . $this->CI->agent->version() . ")";

        $infobrowser = "using " . $ua . " in " . $user_os . " (OS)";

        //simpan log
        $save = $this->CI->db->query("insert into loginfo values ('','$waktu_log','$user','$iplog','$infobrowser','$aktifitas')");
    }
}
