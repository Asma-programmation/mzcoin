<?php session_start(); ob_start();

require_once "../_treatments.php";

try 
{
    $account = 
    isset($_SESSION[_treatments::get_string('connected')] ) ? 
    $_SESSION[_treatments::get_string('connected')] :
    _treatments::throw_exception("Accès refusé !!!");
    
    $post = (isset($_POST) && count($_POST) > 0) ? $_POST : _treatments::throw_exception("Reference manquante !!!");
    $cmd = "SELECT * FROM `balance` WHERE `reference_balance` LIKE :ref";
    $params = array(
        array("label" => "ref", "value" => $post["refb"])
    );

    $result = _treatments::execute_command($cmd, $params);
    $balance = (isset($result) && $result !== false && $result->rowCount() > 0) ? $result->fetchObject() : NULL;

    if (isset($balance))
    {
        // TODO : A changer
        echo "
        Référence : ".htmlentities($balance->reference_balance)."<br>
        Somme : "    .htmlentities($balance->somme_balance). "<br>
        Monnaie : "  .htmlentities($balance->monnaie_balance). "<br>
        Type : "     .htmlentities($balance->type_balance). "<br>
        État : "     .htmlentities ($balance->etat_balance). "<br>
        Compte : "   .htmlentities($balance->compte_balance). "<br>";
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
