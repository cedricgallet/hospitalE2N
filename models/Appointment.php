<?php
require_once(dirname(__FILE__).'/../utils/database.php');

class Appointment{

    private $_dateHour;
    private $_idPatients;
    private $_pdo;

    /**
     * Méthode magique appellée lors de l'instanciation de l'objet dans le controlleur. Elle permet d'hydrater notre objet 'Appointment'
     * 
     * @return boolean
     */
    public function __construct($dateHour=NULL, $idPatients=NULL){
        // Hydratation de l'objet contenant la connexion à la BDD
        $this->_pdo = Database::getInstance();
        $this->_dateHour = $dateHour;
        $this->_idPatients = $idPatients;
    }

    /**
     * Méthode qui permet de créer un rendez-vous
     * 
     * @return boolean
     */
    public function create(){

        try{
            $sql = 'INSERT INTO `appointmffents` (`dateHour`, `idPatients`) 
                    VALUES (:dateHour, :idPatients);';
            $stmt = $this->_pdo->prepare($sql);

            $stmt->bindValue(':dateHour',$this->_dateHour,PDO::PARAM_STR);
            $stmt->bindValue(':idPatients',$this->_idPatients,PDO::PARAM_INT);
            return $stmt->execute();
        }
        catch(PDOException $e){
            return $e->getCode();
        }

    }

    /**
     * Méthode qui permet de récupérer le rendez-vous d'un patient
     * 
     * @return object
     */
    public static function get($id){
        
        $pdo = Database::getInstance();

        try{
            $sql = 'SELECT * FROM `appointments` 
                    WHERE `id` = :id;';
            $sth = $pdo->prepare($sql);

            $sth->bindValue(':id',$id,PDO::PARAM_INT);
            $sth->execute();
            $appointment = $sth->fetch();
            if(!$appointment){
                return '8';
            }
            
            return $appointment;
        }
        catch(PDOException $e){
            return $e->getCode();
        }

    }

    /**
     * Méthode qui permet de lister tous les rdv
     * 
     * @return array
     */
    public static function getAll(){

        $pdo = Database::getInstance();

        try{
            $sql = '    SELECT `appointments`.`id` as `appointmentId`, `patients`.`id` as `patientId`, `patients`.*, `appointments`.* 
                        FROM `appointments` 
                        INNER JOIN `patients`
                        ON `appointments`.`idPatients` = `patients`.`id`
                        ORDER BY `appointments`.`dateHour` DESC;';
            $stmt = $pdo->query($sql);
            return $stmt->fetchAll();
        }
        catch(PDOException $e){
            return false;
        }

    }

    /**
     * Méthode qui permet de modifier un rendez-vous
     * 
     * @return boolean
     */
    public function update($id){

        try{
            $sql = 'UPDATE `appointments` SET `dateHour` = :dateHour, `idPatients` = :idPatients
                    WHERE `id` = :id;';
            $sth = $this->_pdo->prepare($sql);
            $sth->bindValue(':dateHour',$this->_dateHour,PDO::PARAM_STR);
            $sth->bindValue(':idPatients',$this->_idPatients,PDO::PARAM_INT);
            $sth->bindValue(':id',$id,PDO::PARAM_INT);
            return($sth->execute()); 
        }
        catch(PDOException $e){
            return $e->getCode();
        }

    }

    /**
     * Méthode qui permet de supprimer un rendez-vous
     * 
     * @return boolean
     */
    public static function delete($id){

        $pdo = Database::getInstance();

        try{
            $sql = 'DELETE FROM `appointments`
                    WHERE `id` = :id;';
            $sth = $pdo->prepare($sql);
            $sth->bindValue(':id',$id,PDO::PARAM_INT);
            $sth->execute();
            if($sth->rowCount()==0)
                return 8;
            else
                return 9;
        }
        catch(PDOException $e){
            return $e->getCode();
        }

    }

    /**
     * Méthode qui permet de lister tous les rdv d'un patient
     * 
     * @return array
     */
    public static function getAllByIdPatient($id){

        $pdo = Database::getInstance();

        try{
            $sql = '    SELECT `appointments`.`id` as `appointmentId`, `patients`.`id` as `patientId`, `patients`.*, `appointments`.* 
                        FROM `appointments` 
                        INNER JOIN `patients`
                        ON `appointments`.`idPatients` = `patients`.`id`
                        WHERE `appointments`.`idPatients` = :id
                        ORDER BY `appointments`.`dateHour` DESC;';
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute(); 
            return $stmt->fetchAll();
        }
        catch(PDOException $e){
            return $e->getCode();
        }

    }
    


}