<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Webku extends CI_Controller
{
    public function _remap()
    {
        redirect('formlogin/C_formlogin');
    }
}
