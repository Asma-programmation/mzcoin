<?php session_start(); ob_start();
require_once "../_treatments.php";

try 
{
    $post = (isset($_POST) && count($_POST) > 0) ? $_POST : _treatments::throw_exception("Login ou mot de passe manquant(s) !!!");
    $cmd = "INSERT INTO `utilisateur`(
                    `reference_utilisateur`, 
                    `nom_utilisateur`, 
                    `prenom_utilisateur`, 
                    `date_naissance_utilisateur`, 
                    `adresse_utilisateur`, 
                    `pays_utilisateur`, 
                    `agglomeration_utilisateur`, 
                    `code_postal_utilisateur`, 
                    `email_utilisateur`, 
                    `mobile_utilisateur`,
                     `nationalite_utilisateur`, 
                     `login_utilisateur`, 
                     `password_utilisateur`) 
            VALUES (:ref, :nom, :pnm, :dns, :adr, :pay, 
                    :agg, :cdp, :ema, :mob, :nat, :lgn, :pas)";
    $params = array(
        array("label" => "ref", "value" => _treatments::generate_reference()),
        array("label" => "nom", "value" => $post["nom"]),
        array("label" => "pnm", "value" => $post["prenom"]),
        array("label" => "dns", "value" => $post["date_naissance"]),
        array("label" => "adr", "value" => $post["adresse"]),
        array("label" => "pay", "value" => $post["pays"]),
        array("label" => "agg", "value" => $post["agglomeration"]),
        array("label" => "cdp", "value" => $post["code_postal"]),
        array("label" => "ema", "value" => $post["email"]),
        array("label" => "mob", "value" => $post["mobile"]),
        array("label" => "nat", "value" => $post["nationalite"]),
        array("label" => "lgn", "value" => $post["login"]),
        array("label" => "pas", "value" => $post["password"])
    );

    # TODO : 
    # 1. Contrôle d'âge >= 18 ans
    # 2. Contrôle CAPTCHA pour bloquer les robots virtuels et les formulaires externes (DoS)

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