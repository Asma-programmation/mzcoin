<?php session_start(); ob_start(); // Destinées à la sécurité d'accès

require_once "../_treatments.php";

try 
{
    $html = '
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h6 class="mb-0">Mes comptes</h6>
        <div>
            <button class="btn btn-sm btn-sm-square btn-primary m-2" onclick="ajouter_compte();">
                <i class="fa fa-plus"></i>
            </button>
        </div>
    </div>';
    $account = 
        isset($_SESSION[_treatments::get_string('connected')] ) ? 
            $_SESSION[_treatments::get_string('connected')] :
            _treatments::throw_exception("Accès refusé !!!");

    $cmd = "SELECT * FROM all_data_user_account_balance WHERE client_compte = :id";
    $params = array(array("label" => "id", "value" => $account->id_utilisateur));

    $result = _treatments::execute_command($cmd, $params);
    $list = (isset($result) && $result !== false && $result->rowCount() > 0) ? $result : NULL;
    if(isset($list))
    {
        $html .= '
        <div class="d-flex align-items-center border-bottom py-2">
            <div class="w-100 ms-3">
                <div class="d-flex w-100 align-items-center justify-content-between">
                    <span>Compte N°'.$line->iban_compte.'</span><br>
                    <span>Montant : '.$line->somme_balance.' '.$line->monnaie_balance.'</span><br>
                    <input type="number" id="'.$line->reference_balance.'" >
                    <button class="btn btn-sm btn-sm-square btn-primary" title="Envoyer"
                        onclick="ajouter_operation();">
                        <i class="bi bi-cash"></i>
                    </button>
                    <button class="btn btn-sm btn-sm-square btn-primary" title="Geler le compte" 
                        onclick="modifier_etat_compte(\''.$line->reference_compte.'\', 0);">
                        <i class="bi bi-snow"></i>
                    </button>
                    <button class="btn btn-sm btn-sm-square btn-primary" title="Restaurer le compte" 
                        onclick="modifier_etat_compte(\''.$line->reference_compte.'\', 1);">
                        <i class="bi bi-snow"></i>
                    </button>
                </div>
            </div>
        </div>';
    }
} 
catch (Exception $e) 
{
    _treatments::treat_exception($e, 0, 2);
}
