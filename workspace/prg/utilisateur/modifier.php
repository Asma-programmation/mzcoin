<?php session_start(); ob_start();
require_once "../_treatments.php";

try 
{
    $account = 
    isset($_SESSION[_treatments::get_string('connected')] ) ? 
    $_SESSION[_treatments::get_string('connected')] :
    _treatments::throw_exception("Accès refusé !!!");

    $post = (isset($_POST) && count($_POST) > 0) ? $_POST : _treatments::throw_exception("Données manquante(s) !!!");
    $cmd = "UPDATE `utilisateur` 
            SET `nom_utilisateur`=:nu,
                `prenom_utilisateur`=:pu,
                `date_naissance_utilisateur`=:dau,
                `adresse_utilisateur`=:au,
                `agglomeration_utilisateur`=:aggu,
                `code_postal_utilisateur`=:cpu,
                `email_utilisateur`=:eu,
                `mobile_utilisateur`=:mu,
                `piece_identite_recto_utilisateur`=:piru,
                `piece_identite_verso_utilisateur`=:pivu,
                `password_utilisateur`=:passu,
            WHERE `reference_utilisateur`=:ref";
    $params = array(
        array("label" => "ref", "value" => _treatments::generate_reference()),
        array("label" => "nu", "value" => $post["nom_utilisateur"]),
        array("label" => "pu", "value" => $post["prenom_utilisateur"]),
        array("label" => "dau", "value" => $post["date_naissance_utilisateur"]),
        array("label" => "au", "value" => $post["adresse_utilisateur"]),
        array("label" => "aggu", "value" => $post["agglomeration_utilisateur"]),
        array("label" => "cpu", "value" => $post["code_postal_utilisateur"]),
        array("label" => "eu", "value" => $post["email_utilisateur"]),
        array("label" => "mu", "value" => $post["mobile_utilisateur"]),
        array("label" => "piru", "value" => $post["piece_identite_recto_utilisateur"]),
        array("label" => "pivu", "value" => $post["piece_identite_verso_utilisateur"]),
        array("label" => "passu", "value" => $post["password_utilisateur"]),
        array("label" => "ref", "value" => $post["reference_utilisateur"])
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