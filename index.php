<?php
if (session_id() == '')
    session_name("ALPABAMA");
    session_start();
$ROOT_FOLDER = __DIR__;
$DS = DIRECTORY_SEPARATOR;
require_once $ROOT_FOLDER . $DS . 'lib' . $DS . 'File.php';
require 'controller/routeur.php';

