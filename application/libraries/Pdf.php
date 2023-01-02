<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Pdf {
    function __construct() {
        include_once APPPATH . '/libraries/Tcetak.php';
    }
}
