<?php
require_once(dirname(__FILE__) . '/../models/Patient.php');

// Nettoyage de l'id du patient passé en GET dans l'url
$id = intval(trim(filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT)));
/*********************************************************/

// Suppression du patient, et de tous ses rendez-vous. Une contrainte ON DELETE CASCADE, permet de supprimer tous les
// enregistrements d'appointment également.  
$code = intval(Patient::delete($id));

// On redirige vers la page du profil du patient avec un code pour le message
header('location: /controllers/list-patientCtrl.php?msgCode='.$code);
/*************************************************************/