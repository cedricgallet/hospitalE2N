<?php

define('DSN', 'mysql:host=localhost;dbname=dwwm_hospitale2n');
define('LOGIN', 'root');
define('PASSWORD', 'root');
define('NB_ELEMENTS_BY_PAGE', 5);

$displayMsg = array(
    '0' => ['type' => 'alert-danger', 'msg' => 'Une erreur inconnue s\'est produite'],
    '1' => ['type' => 'alert-success', 'msg' => 'Le patient a bien été ajouté'],
    '2' => ['type' => 'alert-success', 'msg' => 'Le patient a bien été mis à jour'],
    '3' => ['type' => 'alert-danger', 'msg' => 'Le patient n\'a pas été trouvé'],
    '4' => ['type' => 'alert-danger', 'msg' => 'Le patient n\'a pas été enregistré en base de données'],
    '5' => ['type' => 'alert-danger', 'msg' => 'Le patient n\'a pas été mis à jour'],
    '6' => ['type' => 'alert-success', 'msg' => 'Le rdv a bien été mis à jour'],
    '7' => ['type' => 'alert-danger', 'msg' => 'Le rdv n\'a pas été mis à jour'],
    '8' => ['type' => 'alert-danger', 'msg' => 'Le rdv n\'a pas été trouvé'],
    '9' => ['type' => 'alert-success', 'msg' => 'Le rdv a bien été supprimé'],
    '10' => ['type' => 'alert-success', 'msg' => 'Le patient a bien été supprimé'],
    '23000' => ['type' => 'alert-danger', 'msg' => 'Vous ne pouvez pas effectuer cette action. Problème de contrainte sur la BDD.'],
    
);