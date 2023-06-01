<?php session_start(); ob_start();
require_once "../_treatments.php";
$_SESSION[_treatments::get_string('connected')] = NULL;
session_regenerate_id();
session_destroy();
header('location: ../../../index.html');