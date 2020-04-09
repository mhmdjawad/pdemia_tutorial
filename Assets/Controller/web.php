<?php

class WEB{
    public static function StartWeb(){
        //todo load classes for utility DAL Util
        session_start();
        ob_start();
        include "Assets/Classes/fct.php";
        include "Assets/Classes/DAL.php";
        include "Assets/Classes/UTIL.php";
        define("URI",self::getURI());
        (GOP == "GET") ? WEB::HGet() : WEB::HPost(); 
    }
    public static function getURI(){
        $URI = trim($_SERVER['REQUEST_URI'],"/");
        $URI = strtolower($URI);
        $URI = str_replace("-","_",$URI);
        $URI = str_replace(" ","_",$URI);
        $URI = str_replace("%20","_",$URI);
        return $URI;
    }
    public static function HGet($f = null){
        $URI = explode("/",URI);
        if($f == null) $f = (isset($URI[IX]) && $URI[IX]!="") ? $URI[IX] : "home";
        if(method_exists(new WEB(),$f)){
            WEB::$f();
        }
        else{
            WEB::home();
        }
    }
    public static function HPost(){
        $key = $_POST['key'];
        $funs = explode("/",$key);
        if(method_exists(new WEB(),$funs[0])){
            $f = $funs[0];
            self::$f($funs);
        }
        else{
            p("function does not exist");
            p($_POST);
        }
    }
    public static function home(){
        include "Assets/view/head.php";
        include "Assets/view/nav.php";
        include "Assets/view/home.php";
        include "Assets/view/foot.php";
    }
    public static function login($f = null){
        if($f == null || count($f) < 2){
            include "Assets/view/head.php";
            include "Assets/view/nav.php";
            include "Assets/view/login.php";
            include "Assets/view/foot.php";
        }
        elseif($f[1] == "submitlogin"){
            $email = $_POST['email'];
            $passw = $_POST['password'];
            $d = DAL::call_sp("select * from account where email=:email",[
                ["k"=>"email","v"=>$email]
            ]);
            if(count($d) == 0){
                p("email not found","red");
            }
            else{
                $d = $d[0];
                if($d["password"] == $passw){
                    $_SESSION["user"] = $d;
                    p("login successful");
                }
                else{
                    p("wrong password","red");
                }
            }
        }
    }
}
?>