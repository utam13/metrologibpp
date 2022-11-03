<?php defined('BASEPATH') or exit('No direct script access allowed');
// generate pdf
function generate_pdf($name, $tpl, $data)
{
    $ci = &get_instance();
    $data['data'] = $data;
    $ci->load->view($tpl, $data);
    // Get output html
    $html = $ci->output->get_output();
    // add external css library
    // $html .= '<link href="' . base_url() . 'assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">';
    // Load pdf library
    $ci->load->library('pdf');
    $ci->dompdf->loadHtml($html);
    // setup size
    $ci->dompdf->set_option('isRemoteEnabled', true);
    // $ci->dompdf->setPaper('A4', 'portrait');
    $ci->dompdf->setPaper(array(0, 0, 609.4488, 935.433), 'landscape');
    // Render the HTML as PDF
    $ci->dompdf->render();
    // Output  PDF (1 = download and 0 = preview)
    $ci->dompdf->stream($name, array("Attachment" => 0));
}
