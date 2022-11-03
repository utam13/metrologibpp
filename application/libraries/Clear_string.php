<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Clear_string
{
    protected $CI;

    public function __construct()
    {
        $this->CI = &get_instance();
    }

    public function clear_quotes($string)
    {
        $phrase = ["&quot;"];
        $text1 = str_replace($phrase, "", $string);
        $text2 = str_replace("[", "(", $text1);
        $text3 = str_replace("]", ")", $text2);
        $text4 = preg_replace('~[\r\n]+~', '\n', $text3);
        $text5 = str_replace("%20", " ", $text4);
        $text6 = str_replace("+", "", $text5);
        $text7 = str_replace("/", "&#47;", $text6);
        $text8 = str_replace("'", "&#039;", $text7);
        $clear_text = $text8;

        return  $clear_text;
    }
}
