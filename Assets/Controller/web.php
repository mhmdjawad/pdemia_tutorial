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
            if(GOP == "GET"){
                include "Assets/view/head.php";
                include "Assets/view/nav.php";
            }
            include "Assets/view/login.php";
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
                $salt = $d['salt'];
                $passw = md5($passw.$salt);
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
    public static function tourism(){
        include "Assets/view/head.php";
        include "Assets/view/nav.php";
        include "Assets/view/tourism_sites.php";
        include "Assets/view/foot.php";
    }

    public static function register(){
        if(GOP == "GET"){
            include "Assets/view/head.php";
            include "Assets/view/nav.php";
        }
        echo '<div class="container RegisterFormContaienr">';
        $html = DAL::getFormForTable("account",[],["salt","tstp"]);
        echo $html;
        echo '</div>';
    }

    public static function profile(){
        $f = (GOP == "GET") ? explode("/",URI) : explode("/",$_POST[key($_POST)]);
        $IX = (GOP == "GET") ? IX+1 :1;
        if(!isset($f[$IX])){

        }
        elseif($f[$IX]=="DBCtrl"){
            
        }
        elseif($f[$IX]=="DBSave"){
            $d = $_POST;
            $table = $d['table'];
            unset($d['key']);
            unset($d['table']);
            if($table == "account"){
                $d = DAL::call_sp("select count(*) exist from account where email=:email",[
                    ["k"=>"email","v"=>$d['email']]
                ]);
                if($d[0]['exist'] > 0){
                    die("email used by another account use to loguin");
                }
                $time = time();
                $d['salt'] = md5($time);
                $d['password'] = md5($d['password'].$d['salt']);
                $r = DAL::insert($table,$d);
                if($f > 0){
                    p("account registered");
                }
                else{
                    p("account not registered");
                }
            }
        }
        else{
            p("unkonw key ");
        }

    }
}
?>