<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Namabulan
{
    protected $CI;

    public function __construct()
    {
        $this->CI = &get_instance();

        $this->CI->load->database();
    }

    public function namabln($bln)
    {
        switch ($bln) {
            case 1:
                $nama = "Januari";
                break;
            case 2:
                $nama = "Februari";
                break;
            case 3:
                $nama = "Maret";
                break;
            case 4:
                $nama = "April";
                break;
            case 5:
                $nama = "Mei";
                break;
            case 6:
                $nama = "Juni";
                break;
            case 7:
                $nama = "Juli";
                break;
            case 8:
                $nama = "Agustus";
                break;
            case 9:
                $nama = "September";
                break;
            case 10:
                $nama = "Oktober";
                break;
            case 11:
                $nama = "November";
                break;
            case 12:
                $nama = "Desember";
                break;
            default:
                $nama = "";
                break;
        }

        return $nama;
    }
}
