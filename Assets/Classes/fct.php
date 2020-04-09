<?php

define("SELF_DIR","http://localhost/_TUT/");
define("IX",1);
define("GOP",$_SERVER['REQUEST_METHOD']);
function p($o, $c = "#83b8ff"){
    echo '<pre style="padding :5px ; background:'.$c.'" > ';
    print_r($o);
    echo '</pre>';
}

?>