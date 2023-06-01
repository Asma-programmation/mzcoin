<?php session_start(); ob_start();

require_once "../_treatments.php";

try {
    $account = 
    isset($_SESSION[_treatments::get_string('connected')] ) ? 
    $_SESSION[_treatments::get_string('connected')] :
    _treatments::throw_exception("Accès refusé !!!");
    
    $post = (isset($_POST) && count($_POST) > 0) ? $_POST : _treatments::throw_exception("Données manquante(s) !!!");
    
    $cmd = "UPDATE `compte` SET `etat_compte` = :eta WHERE `reference_compte` = :ref";
    
    $params = array(
        array("label" => "eta", "value" => $post["eta"]),
        array("label" => "ref", "value" => $post["ref"])
    );

    $result = _treatments::execute_command($cmd, $params);
    $state = (isset($result) && $result !== false && $result->rowCount() > 0);

    echo $state;
} 
catch (Exception $e) 
{
    _treatments::treat_exception($e, 0, 2);
}
