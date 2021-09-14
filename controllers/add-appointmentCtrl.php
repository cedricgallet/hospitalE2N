<?php
include(dirname(__FILE__) . '/../config/regexp.php');
include(dirname(__FILE__) . '/../models/Patient.php');
include(dirname(__FILE__) . '/../models/Appointment.php');

// Initialisation du tableau d'erreurs
$errorsArray = array();
/*************************************/

// Appel à la méthode statique permettant de récupérer tous les patients
$allPatients = Patient::getAll();
/*************************************************************/

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    // DATE ET HEURE DE RDV
    // On verifie l'existance et on nettoie
    $dateHour = trim(filter_input(INPUT_POST, 'dateHour', FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES));

    //On test si le champ n'est pas vide
    if(!empty($dateHour)){
        // On test la valeur
        $testRegex = preg_match(REGEXP_DATE_HOUR,$dateHour);

        if($testRegex == false){
            $errorsArray['dateHour_error'] = 'Le date n\'est pas valide, le format attendu est JJ/MM/AAAA HH:mm';
        }
    }else{
        $errorsArray['dateHour_error'] = 'Le champ est obligatoire';
    }

    // ***************************************************************

    $idPatients = trim(filter_input(INPUT_POST, 'idPatients', FILTER_SANITIZE_NUMBER_INT));

    // Si il n'y a pas d'erreurs, on enregistre un nouveau patient.
    if(empty($errorsArray) ){
        $appointment = new Appointment($dateHour,$idPatients);
        if($appointment->create()===true){
            header('location: /controllers/list-appointmentCtrl.php?msgCode=6');
        } else {
            // Si l'enregistrement s'est mal passé, on affiche à nouveau le formulaire de création avec un message d'erreur.
            $msgCode = 7;
        }
    }
}

/* ************* AFFICHAGE DES VUES **************************/

include(dirname(__FILE__) . '/../views/templates/header.php');
    include(dirname(__FILE__) . '/../views/appointments/form-appointment.php');
include(dirname(__FILE__) . '/../views/templates/footer.php');

/*************************************************************/