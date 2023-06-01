<?php session_start(); ob_start();
require_once "../_treatments.php";

try 
{
    $account = 
    isset($_SESSION[_treatments::get_string('connected')] ) ? 
    $_SESSION[_treatments::get_string('connected')] :
    _treatments::throw_exception("Accès refusé !!!");
    
    $post = (isset($_POST) && count($_POST) > 0) ? $_POST : _treatments::throw_exception("Données manquante(s) !!!");
    $reference = _treatments::generate_reference();
    $post = (isset($_POST) && count($_POST) > 0) ? $_POST : _treatments::throw_exception("Login ou mot de passe manquant(s) !!!");
    $cmd = "INSERT INTO `balance`(
                    `reference_balance`, 
                    `somme_balance`, 
                    `monnaie_balance`, 
                    `type_balance`, 
                    `compte_balance`) 
            VALUES (:ref, :smb, :mnb, :tyb, :cmb)";
    $params = array(
        array("label" => "ref", "value" => $reference),
        array("label" => "smb", "value" => $post["somme"]),
        array("label" => "mnb", "value" => $post["monnaie"]),
        array("label" => "tyb", "value" => $post["type"]),
        array("label" => "cmb", "value" => $post["compte"])
    );
    $result = _treatments::execute_command($cmd, $params);
    $state = (isset($result) && $result !== false && $result->rowCount() > 0);

    if($state)
    {
        _treatments::display_message("Opération terminée avec succès", 1, 2);
    }
    else
    {
        _treatments::throw_exception("Echèc de l'opération !");
    }
} 
catch (Exception $e) 
{
    _treatments::treat_exception($e, 0, 2);
}