<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kirim_email
{
    protected $CI;

    public function __construct()
    {
        $this->CI = &get_instance();

        $this->CI->load->helper('url');
        $this->CI->config->item('base_url');
        $this->CI->load->database();
    }

    public function email($email_pegawai, $judul, $pesan, $cc = "")
    {
        $email_sender = $this->CI->db->query("select * from emailsender")->result();
        foreach ($email_sender as $es) {
            $host = $es->host;
            $user = $es->email;
            $pass = $es->password;
            $port = $es->port;
            $ssl = $es->ssl;
        }

        $config['mailtype'] = 'html';
        $config['protocol'] = 'smtp';
        if ($ssl == 1) {
            $config['smtp_host'] = 'ssl://' . $host;
        } else {
            $config['smtp_host'] = $host;
        }

        $config['smtp_user'] = $user;
        $config['smtp_pass'] = $pass;
        $config['smtp_port'] = $port;

        $this->CI->load->library('email', $config);

        $this->CI->email->from($user, $judul);
        $this->CI->email->to($email_pegawai);
        if ($cc != "") {
            $this->CI->email->cc($cc);
        }
        $this->CI->email->subject($judul);
        $this->CI->email->message($pesan);

        if ($this->CI->email->send()) {
            $pesan = "Email berhasil dikirim";
        } else {
            $pesan = "Email tidak berhasil dikirim";
            //echo '<br />';
            //echo $this->email->print_debugger();
        }

        return $pesan;
    }
}
