<?php session_start(); ob_start();

require_once "../_treatments.php";

try {
    $account = 
    isset($_SESSION[_treatments::get_string('connected')] ) ? 
    $_SESSION[_treatments::get_string('connected')] :
    _treatments::throw_exception("Accès refusé !!!");
    
    $post = (isset($_POST) && count($_POST) > 0) ? $_POST : _treatments::throw_exception("Données manquante(s) !!!");
    
    $cmd = "UPDATE `balance` SET `etat_balance` = :etb WHERE `reference_balance` = :ref";
    
    $params = array(
        array("label" => "etb", "value" => $post["etb"]),
        array("label" => "ref", "value" => $post["refb"])
    );

    $result = _treatments::execute_command($cmd, $params);
    $state = (isset($result) && $result !== false && $result->rowCount() > 0);

    if ($state) 
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
