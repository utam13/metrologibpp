<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Captcha
{
    protected $CI;

    public function __construct()
    {
        $this->CI = &get_instance();
    }

    public function createcaptcha()
    {
        // clear image captcha
        $filesfrom = glob('./assets/img/captcha/*'); 
        foreach($filesfrom as $file) {
            if(is_file($file)) 
                unlink($file); 
        }

        $vals = [
            // 'word'          => substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 8),
            'word'          => substr(str_shuffle('1234567890'), 0, 4),
            'img_path'      => './assets/img/captcha/',
            'img_url'       => base_url('assets/img/captcha/'),
            'img_width'     => 180,
            'img_height'    => 40,
            'expiration'    => 7200,
            'word_length'   => 8,
            'font_path'     => FCPATH.'system/fonts/texb.ttf',
            'font_size'     => 17,
            'img_id'        => 'Imageid',
            // 'pool'          => '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ',
            'pool'          => '0123456789',
    
            'colors'        => [
                    'background'=> [255, 255, 255],
                    'border'    => [255, 255, 255],
                    'text'      => [102, 84, 35],
                    'grid'      => [231, 189, 78]
                ]
            ];
        
        $captcha = create_captcha($vals);

        return $captcha;
    }
}
