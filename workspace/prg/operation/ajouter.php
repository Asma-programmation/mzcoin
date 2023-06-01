<?php session_start();
ob_start();
require_once "../_treatments.php";

try {
    // Récupération du compte client connecté
    $account =
        isset($_SESSION[_treatments::get_string('connected')]) ?
        $_SESSION[_treatments::get_string('connected')] :
        _treatments::throw_exception("Accès refusé !!!");

    // Récupération des données de l'opération de transfert d'argent
    $post = (isset($_POST) && count($_POST) > 0) ? $_POST : _treatments::throw_exception("Données manquante(s) !!!");

    // Génération de la référence unique de l'opération en cours
    $reference = _treatments::generate_reference();

    // Commande SQL permettant l'ajout d'une nouvelle opération
    $cmd = "INSERT INTO `operation`(
                            `reference_operation`, 
                            `destinataire_operation`, 
                            `details_operation`, 
                            `somme_operation`, 
                            `monnaie_operation`, 
                            `type_operation`, 
                            `compte_operation`) 
                 VALUES (:ref, :dst, :dtl, :som, :mon, :tpo, :cpt )";

    // Paramètres/Données du formulaire assicié(e)s à la commande d'ajout de l'opération en cours
    $params = array(
        array("label" => "ref", "value" => $reference),
        array("label" => "dst", "value" => $post["destinataire"]),
        array("label" => "dtl", "value" => $post["details'"]),
        array("label" => "som", "value" => $post["somme"]),
        array("label" => "mon", "value" => $post["monnaie"]),
        array("label" => "tpo", "value" => $post["type"]),
        array("label" => "cpt", "value" => $post["compte"])
    );

    // Exécution de l'ajout de la nouvelle opération dans la table opération
    $result = _treatments::execute_command($cmd, $params);

    // Evaluation de l'état de l'ajout (True or False)
    $state = (isset($result) && $result !== false && $result->rowCount() > 0);

    if ($state) // En cas de succès d'ajout de la nouvelle opération
    {
        // Création d'une commande SQL pour ajouter la somme d'argent transférée à la balance du destinataire
        $cmd1 = "UPDATE `all_data_user_account_balance` 
                    SET `somme_balance` = `somme_balance` + :som 
                  WHERE iban_compte LIKE :dst AND monnaie_balance LIKE :mon";

        // Paramètres associés à la commande précédente
        $params1 = array(
            array("label" => "dst", "value" => $post["destinataire"]),
            array("label" => "som", "value" => $post["somme"]),
            array("label" => "mon", "value" => $post["monnaie"])
        );
        $result1 = _treatments::execute_command($cmd1, $params1);
        $state1 = (isset($result1) && $result1 !== false && $result1->rowCount() > 0);

        if ($state1) // En cas de succès d'ajout de la somme d'argent dans la balance du destinataire
        {
            // Création et exécution du retrait de la somme d'argent transférée dpuis la balance du client
            $cmd2 = "UPDATE `all_data_user_account_balance` 
                        SET `somme_balance` = `somme_balance` - :som 
                    WHERE id_utilisateur = :id AND monnaie_balance LIKE :mon";
            $params2 = array(
                array("label" => "id", "value" => $account->id_utilisateur),
                array("label" => "som", "value" => $post["somme"]),
                array("label" => "mon", "value" => $post["monnaie"])
            );
            $result2 = _treatments::execute_command($cmd2, $params2);
            $state2 = (isset($result2) && $result2 !== false && $result2->rowCount() > 0);

            if ($state2) // En cas de succès du retrait
            {
                // Affichage d'un message de succès
                _treatments::display_message("Opération terminée avec succès", 1, 2);
            } else // En cas d'echèc du retrait
            {
                // Annulation de l'ajout de la somme d'argent transférée dans la balance du destinataire
                $cmd1 = "UPDATE `all_data_user_account_balance` 
                            SET `somme_balance` = `somme_balance` - :som 
                          WHERE iban_compte LIKE :dst AND monnaie_balance LIKE :mon";
                $params1 = array(
                    array("label" => "dst", "value" => $post["destinataire"]),
                    array("label" => "som", "value" => $post["somme"]),
                    array("label" => "mon", "value" => $post["monnaie"])
                );
                $result1 = _treatments::execute_command($cmd1, $params1);
                $state1 = (isset($result1) && $result1 !== false && $result1->rowCount() > 0);

                // Suppression de la nouvelle opération 
                $cmd = "DELETE FROM operation WHERE reference_operation LIKE :ref";
                $params = array(array("label" => "ref", "value" => $reference));
                $result = _treatments::execute_command($cmd, $params);
                $state = (isset($result) && $result !== false && $result->rowCount() > 0);

                // Déclanchement d'une exception
                _treatments::throw_exception("Echèc de l'opération !");
            }
        } 
        else // En cas d'echèc de l'ajout de la somme d'argent dans la balance du destinataire
        {
            // Suppression de la nouvelle opération 
            $cmd = "DELETE FROM operation WHERE reference_operation LIKE :ref";
            $params = array(array("label" => "ref", "value" => $reference));
            $result = _treatments::execute_command($cmd, $params);
            $state = (isset($result) && $result !== false && $result->rowCount() > 0);

            // Déclanchement d'une erreur
            _treatments::throw_exception("Echèc de l'opération !");
        }
    } else {
        _treatments::throw_exception("Echèc de l'opération !");
    }
} catch (Exception $e) {
    _treatments::treat_exception($e, 0, 2);
}
