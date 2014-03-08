<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of appinfo
 *
 * @author igs03102
 */
class app_shoppinglist implements \Console\Applications\IApplication
{
    //put your code here
    function getName() {
        return "Shopping list";
    }
    function getPanels() {
	$panels = array();
	$panels[] = array('name'=>'Print List','path'=>'print_list.php');

	return $panels;
    }

}
