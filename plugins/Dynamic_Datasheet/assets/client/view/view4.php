<?php
require_once("../../../model/core/model.php");

$ext_files       = new assetInit();
$ext_files->css  = ["view4_1.css", "view4_2.css"];
$ext_files->js   = ["view4_1.js", "view4_2.js"];

$html_doc->load_css($ext_files->css);
$html_doc->load_js($ext_files->js);
