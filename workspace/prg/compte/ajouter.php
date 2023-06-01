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
    $code = _treatments::generate_code(3);
    $iban = 
        ($post["type"] == 1) ? 
        "DZ"._treatments::generate_code(18) : 
        ($post["type"] == 2 || $post["type"] == 3 ? 
            _treatments::generate_code(16) : 
            _treatments::throw_exception("Type inconnu !!!"));

    $cmd = "INSERT INTO `compte`(
                    `reference_compte`, 
                    `iban_compte`, 
                    `code_carte_compte`, 
                    `type_compte`, 
                    `client_compte`) 
            VALUES (:ref, :ibn, :ccc, :tpc, :clc)";

    $params = array(
        array("label" => "ref", "value" => $reference),
        array("label" => "ibn", "value" => $iban),
        array("label" => "ccc", "value" => $code),
        array("label" => "tpc", "value" => $post["type"]),
        array("label" => "clc", "value" => $account->id_utilisateur));

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