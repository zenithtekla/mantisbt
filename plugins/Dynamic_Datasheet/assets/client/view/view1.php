<?php
require_once("../../../model/core/model.php");

$ext_files       = new assetInit();
$ext_files->css  = ["view1_1.css", "view1_2.css"];
$ext_files->js   = ["view1_1.js", "view1_2.js"];

$html_doc->load_css($ext_files->css);
$html_doc->load_js($ext_files->js);
