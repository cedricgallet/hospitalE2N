<?php
include(dirname(__FILE__) . '/../config/regexp.php');

include(dirname(__FILE__) . '/../models/Patient.php');
include(dirname(__FILE__) . '/../models/Appointment.php');

// Initialisation du tableau d'erreurs
$errorsArray = array();
/*************************************/

// Nettoyage de l'id du rdv passé en GET dans l'url
$id = intval(trim(filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT)));
/*************************************************************/

// Appel à la méthode statique permettant de récupérer tous les patients
$allPatients = Patient::getAll();
/*************************************************************/

// Appel à la méthode statique permettant de récupérer un rendez-vous
$appointment = Appointment::get($id);

// Formattage de la date pour datetime-local
$dateHour=date('Y-m-d\TH:i', strtotime($appointment->dateHour));

// Récupération d'idPatients
$idPatients=$appointment->idPatients;

// Si $appointment est en erreur (la méthode ne nous retourne pas un objet), alors on redirige vers la liste de tous les rdv
if(!is_object($appointment)){
    header('location: /controllers/list-appointmentCtrl.php?msgCode='.$appointment);
}

//On ne controle que s'il y a des données envoyées 
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

    // Si il n'y a pas d'erreurs, on met à jour le rdv.
    if(empty($errorsArray) ){
        $appointment = new Appointment($dateHour, $idPatients);
        if($appointment->update($id)===true){
            header('location: /controllers/display-appointmentCtrl.php?id='.$id.'&msgCode=6');
        } else {
            $msgCode=5;
        }
    }

}

/* ************* AFFICHAGE DES VUES **************************/

include(dirname(__FILE__) . '/../views/templates/header.php');
    include(dirname(__FILE__) . '/../views/appointments/form-appointment.php');
include(dirname(__FILE__) . '/../views/templates/footer.php');

/*************************************************************/