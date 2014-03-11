<?php
function redirect($url) {    
    header('Location: '. $url);
    exit();
}

function get_param($name,$type, $default=false, $limit = false) {
	$targets = array($_GET, $_POST);
	$opt = NULL;
	if ($limit === false || $limit == 'GET') {
		$opt = isset($_GET[$name])?$_GET[$name]: $opt;
	}
	if ($limit === false || $limit == 'POST') {
		$opt = isset($_POST[$name])?$_POST[$name]: $opt;
	}
	if (is_null($opt)) {
		return $default;
	}

	//$opt = sanityCheck($opt,$type, false);
	return $opt;	//@TODO do some processing to make sure it's sane and not going to cause problems.
}

function sanityCheck($string, $type, $length){

  // assign the type
  $type = 'is_'.$type;

  if(!$type($string))
    {
    return FALSE;
    }
  // now we see if there is anything in the string
  elseif(empty($string))
    {
    return FALSE;
    }
  // then we check how long the string is
  elseif($length !== false && strlen($string) > $length)
    {
    return FALSE;
    }
  else
    {
    // if all is well, we return TRUE
    return TRUE;
    }
}
