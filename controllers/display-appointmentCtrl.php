<?php
require_once(dirname(__FILE__) . '/../models/Appointment.php');
require_once(dirname(__FILE__) . '/../models/Patient.php');

// Nettoyage de l'id passé en GET dans l'url
$id = intval(trim(filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT)));
/*************************************************************/

// Appel à la méthode statique permettant de récupérer toutes les infos d'un patient
$appointment = Appointment::get($id);
/*************************************************************/

// Si le rdv n'est pas un objet, on redirige vers la liste complète avec le code erreur retourné par la méthode Appointment::get($id)
if(!is_object($appointment)){
    header('location: /controllers/list-appointmentCtrl.php?msgCode='.$appointment);
} else {
    $patient = Patient::get($appointment->idPatients);
}
/*************************************************************/


/* ************* AFFICHAGE DES VUES **************************/

include(dirname(__FILE__) . '/../views/templates/header.php');
    include(dirname(__FILE__) . '/../views/appointments/display-appointment.php');
include(dirname(__FILE__) . '/../views/templates/footer.php');

/*************************************************************/