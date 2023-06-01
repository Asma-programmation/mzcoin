<?php session_start(); ob_start();

require_once "../_treatments.php";

try 
{
    $account = 
    isset($_SESSION[_treatments::get_string('connected')] ) ? 
    $_SESSION[_treatments::get_string('connected')] :
    _treatments::throw_exception("Accès refusé !!!");
    
    $post = (isset($_POST) && count($_POST) > 0) ? $_POST : _treatments::throw_exception("Reference manquante !!!");
    $cmd = "SELECT * FROM `operation` WHERE `reference_operation` LIKE :ref";
    $params = array(
        array("label" => "ref", "value" => $post["refb"])
    );

    $result = _treatments::execute_command($cmd, $params);
    $operation = (isset($result) && $result !== false && $result->rowCount() > 0) ? $result->fetchObject() : NULL;

    if (isset($operation))
    {
        // TODO : A changer
        echo "
        Référence : "        .htmlentities($operation->reference_operation)."<br>
        Details : "          .htmlentities($operation->details_operation). "<br>
        Somme : "            .htmlentities($operation->somme_operation). "<br>
        Monnaie: "           .htmlentities($operation->monnaie_operation). "<br>
        Date d'ajout : "     .htmlentities ($operation->date_ajout_operation). "<br>
        Date d'annulation : ".htmlentities($operation->date_annulation_operation). "<br>
        Nature  : "          .htmlentities($operation->nature_operation). "<br>
        Type : "             .htmlentities($operation->type_operation). "<br>
        Etat : "             .htmlentities($operation->etat_operation). "<br>";

    } 
    else 
    {
        _treatments::throw_exception("Aucun enregistrement trouvé !");
    }
} 
catch (Exception $e) 
{
    _treatments::treat_exception($e, 0, 2);
}
