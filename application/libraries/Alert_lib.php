<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Alert_lib
{
    protected $CI;

    public function __construct()
    {
        $this->CI = &get_instance();
    }

    public function alert($pesan = "", $isipesan = "")
    {
        //pesan proses
        $datapesan['kode_alert'] = is_numeric($pesan);
        $datapesan['isipesan'] = $isipesan;

        $datapesan['jenisbox'] = "";
        switch ($pesan) {
            case "1":
                $datapesan['jenisbox'] = "alert-success";
                break;
            case "2":
                $datapesan['jenisbox'] = "alert-info";
                break;
            case "3":
                $datapesan['jenisbox'] = "alert-warning";
                break;
            case "4":
                $datapesan['jenisbox'] = "alert-danger";
                break;

            case "10":
                $datapesan['jenisbox'] = "alert-warning";
                break;
            case "11":
                $datapesan['jenisbox'] = "alert-danger";
                break;
            case "12":
                $datapesan['jenisbox'] = "alert-info";
                break;
            default:
                $datapesan['kode_alert'] = "";
                break;
        }

        return $datapesan;
    }
}
