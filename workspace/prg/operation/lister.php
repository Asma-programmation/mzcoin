<?php session_start(); ob_start(); // Destinées à la sécurité d'accès

require_once "../_treatments.php";

try 
{
    $account = 
    isset($_SESSION[_treatments::get_string('connected')] ) ? 
    $_SESSION[_treatments::get_string('connected')] :
    _treatments::throw_exception("Accès refusé !!!");
    //code...
} 
catch (Exception $e) 
{
    _treatments::treat_exception($e, 0, 2);
}
