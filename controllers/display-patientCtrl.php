<?php
require_once(dirname(__FILE__) . '/../models/Patient.php');
require_once(dirname(__FILE__) . '/../models/Appointment.php');

// Nettoyage de l'id passé en GET dans l'url
$id = intval(trim(filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT)));
/*************************************************************/

// Appel à la méthode statique permettant de récupérer toutes les infos d'un patient
$patient = Patient::get($id);
/*************************************************************/

// Appel à la méthode statique permettant de récupérer tous les rdv d'un patient
$allAppointments = Appointment::getAllByIdPatient($id);
/*************************************************************/

// Si le patient n'existe pas, on redirige vers la liste complète avec un code erreur
if(!$patient){
    header('location: /controllers/list-patientCtrl.php?msgCode=3');
}
/*************************************************************/


/* ************* AFFICHAGE DES VUES **************************/

include(dirname(__FILE__) . '/../views/templates/header.php');
    include(dirname(__FILE__) . '/../views/patients/display-patient.php');
    include(dirname(__FILE__) . '/../views/appointments/list-appointment.php');
include(dirname(__FILE__) . '/../views/templates/footer.php');

/*************************************************************/