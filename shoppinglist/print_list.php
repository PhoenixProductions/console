<?php
$devToken='';
require 'vendor/autoload.php';

function get_param($name, $default) {
	$field = $_GET;
	if (isset($field[$name])) {
		if (!empty($field[$name])){
			return $field[$name];
		}
	}
	return $default;
}

function init_evernote($token) {
	global $ENCLIENT, $NS;
	$ENCLIENT = new Evernote\Client(array('token' => $token, 'sandbox'=>false));
	$NS = $ENCLIENT->getNoteStore();
}

function get_notes($filter) {
	try {
	global $ENCLIENT, $NS;
	$spec = new EDAM\NoteStore\NotesMetadataResultSpec();
	$spec->includeTitle = True;
	 
	$notelist = $NS->findNotesMetadata($filter, 0, 1, $spec);
	 
	$c = '';
	$notes = array();
	foreach($notelist->notes as $n) {
		$notes[] = $NS->getNote($n->guid, true,false,false,false);
	}
	return $notes;
	}
	catch(Exception $e) {
		echo($e->errorCode);
		exit();
	}
}

function get_template() {
	$template = file_get_contents(__DIR__.'/page.tpl');
	return $template;
}

function get_page($body,$header='') {
	$template = get_template();
	$page = str_replace("{%%HEADCONTENT%%}", $header, $template);	//replace head maerk
	$page = str_replace("{%%BODYCONTENT%%}", $body, $page);
	return $page;
}

function format_note($note) {
	$out = '';
	
	$out .= "<h2>{$note->title}</h2>";	
	$out .= "{$note->content}";

	return $out;
}


ini_set('display_errors','1');
//$deliverycount = get_param('delivery_count', false);
$tagguid = 'e2684873-2d55-493f-bcd9-2cba4aee2f0b';
//$tagguid = get_param('listtagguid', false);
if ($tagguid === false) {
	$tagguid = '39c5c5d0-6ee5-457f-ba79-9b4481b59faf';
}
//$etagval = md5($deliverycount);
//fetch shopping list notes:
init_evernote($devToken);

//todo get notes in the "list" tag that are newer than the last printed date.

$filter = new EDAM\NoteStore\NoteFilter();
$filter->tagGuids = array($tagguid);
$filter->order = 2;	// order by updated 
$filter->ascending = false;

$notes = get_notes($filter);

$body ='<h1>Shopping List</h1><div>Printed '. date('r')."</div>";
foreach($notes as $note) {
	$body.=format_note($note);
}
$etagval = md5($devToken.$body);
//set ETag
//header('ETag:"' .$etagval.'"');

$page =  get_page($body);
//echo $page;	
send_to_lp($page);
header('Location:index.php');
//"body{ font-size:12pt}\nen-todo { height:10px; width:10px;border: 1px solid black; display:inline-block; margin-right:3px}\n");

function send_to_lp($html, $style = '', $dump = false) {
	if ($html == '') {
		return;
	}
	$key ='';
	$ch = curl_init('http://remote.bergcloud.com/playground/direct_print/'.$key);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, 'html='. urlencode($html));
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
	$result = curl_exec($ch);		
	curl_close($ch);
	error_log("Little Printer result:".$result);
}
