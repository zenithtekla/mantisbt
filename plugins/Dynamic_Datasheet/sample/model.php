<?php
$html_doc = (object) array
(
    "css"   => array(),
    "js"    => array()
);


$html_doc->css = ["test.css", "test2.css"];
$html_doc->js = ["test.js", "test2.js"];
print_r($html_doc);
echo "<br/>";

class assetHandler {
    public function __construct ( array $args = [] ) {
        if ( !empty($args) ) {
            foreach ($args as $prop => $args ){
                $this->{$prop} = $args;
            }
        }
    }
    public function __call($method, $args = null ) {
        echo "Method '" . $method ."' has been called with " . count($args) . " parameter(s)!";
    }
}

$html_doc = new assetHandler();
$html_doc->css = ["test.css", "test2.css"];
$html_doc->js = ["test.js", "test2.js"];
print_r($html_doc);