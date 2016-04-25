<?php
require_once("../../../model/core/model.php");

$ext_files       = new assetInit();
$ext_files->css  = ["view3_1.css", "view3_2.css"];
$ext_files->js   = ["view3_1.js", "view3_2.js"];

$html_doc->load_css($ext_files->css);
$html_doc->load_js($ext_files->js);
