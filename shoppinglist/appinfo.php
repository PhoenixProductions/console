<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once(__DIR__.'/vendor/autoload.php');
/**
 * Description of appinfo
 *
 * @author igs03102
 */
class app_shoppinglist extends \Console\Applications\BaseApplication implements \Console\Applications\IApplication 
{
	function __construct() {
		$this->name = 'Shopping list';
	}
/*
    //put your code here
    function getName() {
        return "Shopping list";
    }
*/
    function getPanels() {
	$panels = array();
	$panels[] = array('name'=>'Print Latest List','path'=>'print_list.php', 'action'=>'printlist');
	$panels[] = array('name'=>'List Notes','path'=>'listnotes.php', 'action'=>'listnotes');
	return $panels;
    }

    function init_evernote() {
	$token = get_config()->shoppinglist->evernotekey;
//        print_r($token);
//	die();
	$this->ENCLIENT = new \Evernote\Client(array('token' => $token, 'sandbox'=>false));
        $this->NS = $this->ENCLIENT->getNoteStore();
    }

    function dispatch_listnotes() {
	global $OUTPUT;
	ini_set('display_errors','1');
	$this->init_evernote();
	
	//ob_start();
	//todo get notes in the "list" tag that are newer than the last printed date.

	$filter = new \EDAM\NoteStore\NoteFilter();
	$filter->order = 2;	// order by updated 
	$filter->ascending = false;

	$note = get_param('noteid', 'string', false);
	$start = get_param('start',0);
	if (!$note) {
	$OUTPUT->shownavbar = true;
	$notes = $this->get_notes($filter,$start);
	echo $OUTPUT->header();
	echo "<p>Select a note to print</p>";
	echo "<ul>";
	foreach($notes->notes as $n) {
		echo "<li><a href='?path=shoppinglist&action=listnotes&noteid={$n->guid}'>{$n->title}</a></li>";
	}
	echo "</ul>";
	echo $OUTPUT->footer();
	$out = ob_get_clean();
	return false;
	} else {
	$n = $this->NS->getNote($note, true,false,false,false);

	$body ='<h1>'.$n->title.'</h1><div>Printed '. date('r')."</div>";
	$body.=format_note($n);

	$page =  get_page($body);
	$this->send_to_lp($page);
	header('Location:'. $CFG->wwwroot.'/?app=shoppinglist'); //redirect to this app home page
	}
    }

    function send_to_lp($html, $style = '', $dump = false) {
	$key = get_config()->shoppinglist->lpkey;
	if ($html == '') {
		return;
	}
	$ch = curl_init('http://remote.bergcloud.com/playground/direct_print/'.$key);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, 'html='. urlencode($html));
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
	$result = curl_exec($ch);		
	curl_close($ch);
	error_log("Little Printer result:".$result);
    }  
    function get_notes($filter, $start =0,$limit = 10) {
        try {
        $spec = new \EDAM\NoteStore\NotesMetadataResultSpec();
        $spec->includeTitle = True;

        $notelist = $this->NS->findNotesMetadata($filter, $start, $limit, $spec);
        return  $notelist;
	}
        catch(Exception $e) {
                echo($e->errorCode);
                exit();
        }

    }
}
