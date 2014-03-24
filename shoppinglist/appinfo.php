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
//	$panels[] = array('name'=>'Print Latest List', 'action'=>'printlatest');
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

    function dispatch_printlatest() {
	global $OUTPUT;
	$preview = false;//get_param('preview','string', true);
	$tagguid = false;//get_config()->shoppinglist->tagguid;
	ini_set('display_errors','1');
	$this->init_evernote();
//$tagguid = get_param('listtagguid', false);
	if ($tagguid === false) {
		$tagguid = 'e2684873-2d55-493f-bcd9-2cba4aee2f0b';
//		$tagguid = '39c5c5d0-6ee5-457f-ba79-9b4481b59faf';
	}

//todo get notes in the "list" tag that are newer than the last printed date.

	$filter = new EDAM\NoteStore\NoteFilter();
	$filter->tagGuids = array($tagguid);
	$filter->order = 2;	// order by updated 
	$filter->ascending = false;

	$notes = $this->get_notes($filter, 0,1);

	$body ='<h1>Shopping List</h1><div>Printed '. date('r')."</div>";
	foreach($notes->notes as $note) {
		$n = $this->NS->getNote($note->guid, true,false,false,false);
		$body.=$this->format_note($n);
	}

	//$page =  get_page($body);
	$page =  $body;
///var_dump($preview);
	if ($preview) {
		$OUTPUT->shownavbar = true;
		echo $OUTPUT->header();
		echo $body;;
		echo $OUTPUT->footer();

	} else {
		$body = str_replace('<en-todo', '<div class="todobox"/><en-todo',$body);	
		echo $body;
//		send_to_lp($lpKey,$body);

	}
	exit();
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

	$OUTPUT->addStylesheet('shoppinglist/styles.css');
	$OUTPUT->addStylesheet('shoppinglist/lp_styles.css');

	echo $OUTPUT->header();
	echo "<p>Select a note to print</p>";
	echo "<ul>";
	foreach($notes->notes as $n) {
		echo "<li><a href='?app=shoppinglist&action=listnotes&noteid={$n->guid}'>{$n->title}</a>";
		echo "<a href='?app=shoppinglist&action=viewnote&noteid={$n->guid}'>[View]</a>";
		echo "</li>";
	}
	echo "</ul>";
	echo $OUTPUT->footer();
	$out = ob_get_clean();
	return false;
	} else {
	$n = $this->NS->getNote($note, true,false,false,false);

	$body ='<h1>'.$n->title.'</h1><div>Printed '. date('r')."</div>";
	$body.= $this->format_note($n);

	$page =  get_page($body);
	$this->send_to_lp($page);
	header('Location:'. $CFG->wwwroot.'/?app=shoppinglist'); //redirect to this app home page
	}
    }
    function dispatch_viewnote() {
	global $OUTPUT;
	$OUTPUT->shownavbar = true;
	$OUTPUT->addStylesheet('shoppinglist/styles.css');
	$this->init_evernote();
	$noteid = get_param('noteid', 'string', false);
	if ($noteid !== false) {
		$n = $this->NS->getNote($noteid, true, false, false, false);
		$body = $this->format_note($n);
		echo $OUTPUT->header();
		echo $body;
		echo $OUTPUT->footer();
		exit();
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
    function format_note($note) {
        $out = '';

        $out .= "<h2>{$note->title}</h2>";
        $out .= "{$note->content}";

        return $out;
    }
}
