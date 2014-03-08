<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of OutputRenderer
 *
 * @author igs03102
 */
class OutputRenderer {
    public  $shownavbar = true;
    public $showHome = true;
    function header() {
        $OUTPUT = $this;
        ob_start();
        include(get_config()->dirroot.'/theme/header.xhtml');
        $header = ob_get_clean();
        return $header;//file_get_contents(get_config()->dirroot.'/theme/header.xhtml');
    }
    function footer() {
        $OUTPUT = $this;
        ob_start();
        include(get_config()->dirroot.'/theme/footer.xhtml');
        $footer = ob_get_clean();
        return $footer;//file_get_contents(get_config()->dirroot.'/theme/header.xhtml');
        //return file_get_contents(get_config()->dirroot.'/theme/footer.xhtml');
    }
}
