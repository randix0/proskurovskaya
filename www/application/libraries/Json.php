<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Json {
    function __construct() {
    }
/*
    function parse($params = array(), $noCache = true) {
        if($noCache) { //ie fix
            header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
            header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
            header("Cache-Control: no-store, no-cache, must-revalidate");
            header("Cache-Control: post-check=0, pre-check=0", false);
            header("Pragma: no-cache");
        }

        header('Content-type: application/json; charset=utf-8');

        echo json_encode($params);
    }
*/

    function parse($params = array(), $noCache = true)
    {
        $config =& get_config();
        $this->CI =& get_instance();
        $this->CI->output->set_content_type('application/json')->set_output(json_encode($params));
    }

}