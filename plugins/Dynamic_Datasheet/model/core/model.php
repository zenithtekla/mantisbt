<?php
require_once("../../../config_inc.php");

class assetInit {
    public function __construct ( array $args = [] ) {
        if ( !empty($args) ) {
            foreach ($args as $prop => $args ){
                $this->{$prop} = $args;
            }
        }
    }
    public function __call($method, $args = null ) {
        // echo "Method '" . $method ."' has been called with " . count($args) . " parameter(s)!";
        $args = array_merge(array("assetInit" => $this), $args); // Note: method argument 0 will always referred to the main class ($this).
        if (isset($this->{$method}) && is_callable($this->{$method})) {
            return call_user_func_array($this->{$method}, $args);
        } else {
            throw new Exception("Fatal error: Call to undefined method assetInit::{$method}()");
        }
    }
}

$html_doc           = new assetInit();
$html_doc->load_css = [];
$html_doc->load_js  = [];
$html_doc->load_img = [];

foreach ($html_doc as $fn => $val) {
    if (!$val instanceOf Closure) {
        $html_doc->{$fn} = function($stdObject, $val='') use ($fn) { 
        switch (true) {
            case strpos( $fn, 'append' ) !== false:
                break;
            case strpos( $fn, 'load_css' ) !== false:
                if (!is_array($val))
                    echo '<link rel="stylesheet" href="'.CSS_PATH.$val.'">';
                else {
                    foreach ($val as $v){
                        echo '<link rel="stylesheet" href="'.CSS_PATH.$v.'">';
                    }
                }
                break;
            case strpos( $fn, 'load_js' ) !== false:
                if (!is_array($val))
                    echo '<script src="'.JS_PATH.$val.'" type="text/javascript" ></script>';
                else {
                    foreach ($val as $v){
                        echo '<script src="'.JS_PATH.$v.'" type="text/javascript" ></script>';
                    }
                }
                break;
            case strpos( $fn, 'load_img' ) !== false:
                if (!is_array($val))
                    echo '<img src="'.IMG_PATH.$val.'" width="20" height="15" title="X" alt="X">';
                else {
                    foreach ($val as $v){
                        echo '<img src="'.IMG_PATH.$v.'" width="20" height="15" title="X" alt="X">';
                    }
                }
                break;
            
            default:
                if (isset($val))
                    $stdObject->{$fn} = $val;
                else
                    return $stdObject->{$fn};
                break;
        }
        };
    }
}