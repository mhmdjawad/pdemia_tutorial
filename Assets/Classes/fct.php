<?php


//define("SELF_DIR","http://localhost/pdemia_tutorial/");
define('SELF_DIR',$_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['SERVER_NAME'].str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']));//."index.php/"
define("IX",1);
define("GOP",$_SERVER['REQUEST_METHOD']);
function p($o, $c = "#83b8ff"){
    echo '<pre style="padding :5px ; background:'.$c.'" > ';
    print_r($o);
    echo '</pre>';
}

?>