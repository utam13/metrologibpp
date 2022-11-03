<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Infoapp
{
    protected $CI;

    public function __construct()
    {
        $this->CI = &get_instance();

        $this->CI->load->database();
    }

    public function info()
    {
        $kantor = $this->CI->db->query("select * from kantor")->row_array();
        $dataapp['namakantor'] = empty($kantor) ? "-" : html_entity_decode($kantor['nama']);
        $dataapp['alamatkantor'] = empty($kantor) ? "-" : html_entity_decode($kantor['alamat']);
        $dataapp['telpkantor'] = empty($kantor) ? "-" : $kantor['telp'];
        $dataapp['wakantor'] = empty($kantor) || $kantor['wa'] == "" ? "-" : $kantor['wa'];
        $dataapp['emailkantor'] = empty($kantor) ? "-" : $kantor['email'];
        $dataapp['webkantor'] = empty($kantor) ? "-" : $kantor['web'];
        $dataapp['waktuaktif'] = empty($kantor) ? "-" : $kantor['waktuaktif'];
        $dataapp['googlemapkantor'] = empty($kantor) ? "-" : $kantor['googlemap'];
        $dataapp['igkantor'] = empty($kantor) || $kantor['ig'] == "" ? "-" : $kantor['ig'];
        $dataapp['fbkantor'] = empty($kantor) || $kantor['fb'] == "" ? "-" : $kantor['fb'];
        $dataapp['youtubekantor'] = empty($kantor) || $kantor['youtube'] == "" ? "-" : $kantor['youtube'];
        $dataapp['logo'] = empty($kantor) ? "-" : $kantor['logo'];

        if ($dataapp['logo'] == "") {
            $dataapp['file_logo'] = base_url() . "upload/no-image.png";
        } else {
            $file_target = "upload/logo/" . $dataapp['logo'];
            if (file_exists($file_target)) {
                $dataapp['file_logo'] = base_url() . "upload/logo/" . $dataapp['logo'];
            } else {
                $dataapp['file_logo'] = base_url() . "upload/no-image.png";
            }
        }

        $dataapp['slide']= $this->CI->db->query("select * from slide")->result();

        return $dataapp;
    }
}
