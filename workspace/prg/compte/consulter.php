<?php session_start(); ob_start();

require_once "../_treatments.php";

try 
{
    $account = 
    isset($_SESSION[_treatments::get_string('connected')] ) ? 
    $_SESSION[_treatments::get_string('connected')] :
    _treatments::throw_exception("Accès refusé !!!");
    
    $post = (isset($_POST) && count($_POST) > 0) ? $_POST : _treatments::throw_exception("Reference manquante !!!");
    $cmd = "SELECT * FROM `compte` WHERE `reference_compte` LIKE :ref";
    $params = array(
        array("label" => "ref", "value" => $post["refb"])
    );

    $result = _treatments::execute_command($cmd, $params);
    $compte = (isset($result) && $result !== false && $result->rowCount() > 0) ? $result->fetchObject() : NULL;

    if (isset($compte))
    {
        // TODO : A changer
        echo "
        Référence : "   .htmlentities($compte->reference_compte)."<br>
        IBAN : "        .htmlentities($compte->iban_compte). "<br>
        Code : "        .htmlentities($compte->code_compte). "<br>
        Date d'ajout : ".htmlentities($compte->date_ajout_compte). "<br>
        Type : "        .htmlentities ($compte->type_compte). "<br>
        Etat : "        .htmlentities($compte->etat_compte). "<br>";
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
