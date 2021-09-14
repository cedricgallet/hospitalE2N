<?php

require_once(dirname(__FILE__).'/../utils/database.php');

class Patient{

    private $_firstname;
    private $_lastname;
    private $_birthdate;
    private $_phone;
    private $_mail;
    private $_pdo;

    /**
     * Méthode magique qui permet d'hydrater notre objet 'patient'
     * 
     * @return boolean
     */
    public function __construct($lastname=NULL, $firstname=NULL, $birthdate=NULL, $phone=NULL, $mail=NULL){
        
        // Hydratation de l'objet contenant la connexion à la BDD
        $this->_lastname = $lastname;
        $this->_firstname = $firstname;
        $this->_birthdate = $birthdate;
        $this->_phone = $phone;
        $this->_mail = $mail;

        $this->_pdo = Database::getInstance();
    }

    /**
     * Méthode qui permet de créer un patient
     * 
     * @return boolean
     */
    public function create(){

        try{
            $sql = 'INSERT INTO `patients` (`lastname`, `firstname`, `birthdate`, `phone`, `mail`) 
                    VALUES (:lastname, :firstname, :birthdate, :phone, :mail);';
            $sth = $this->_pdo->prepare($sql);

            $sth->bindValue(':lastname',$this->_lastname,PDO::PARAM_STR);
            $sth->bindValue(':firstname',$this->_firstname,PDO::PARAM_STR);
            $sth->bindValue(':birthdate',$this->_birthdate,PDO::PARAM_STR);
            $sth->bindValue(':phone',$this->_phone,PDO::PARAM_STR);
            $sth->bindValue(':mail',$this->_mail,PDO::PARAM_STR);
            return $sth->execute();
        }
        catch(PDOException $e){
            return $e->getCode();
        }

    }

    
    /**
     * Méthode qui permet de lister tous les patients existants en fonction d'un mot clé et selon pagination
     * 
     * @return array
     */
    public static function getAll($search='', $limit=null, $offset=0){
        
        try{
            if(!is_null($limit)){ // Si une limite est fixée, il faut tout lister
                $sql = 'SELECT * FROM `patients` 
                WHERE `lastname` LIKE :search 
                OR `firstname` LIKE :search 
                LIMIT :limit OFFSET :offset;';
            } else {
                $sql = 'SELECT * FROM `patients` 
                WHERE `lastname` LIKE :search 
                OR `firstname` LIKE :search;';
            }

            $pdo = Database::getInstance();

            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':search','%'.$search.'%',PDO::PARAM_STR);
            
            if(!is_null($limit)){
                $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
                $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            }
            
            $stmt->execute();
            return($stmt->fetchAll());
        }
        catch(PDOException $e){
            return false;
        }

    }

    /**
     * Méthode qui permet de récupérer le profil d'un patient
     * 
     * @return object
     */
    public static function get($id){
        
        $pdo = Database::getInstance();

        try{
            $sql = 'SELECT * FROM `patients` 
                    WHERE `id` = :id;';
            $sth = $pdo->prepare($sql);

            $sth->bindValue(':id',$id,PDO::PARAM_INT);
            $sth->execute();
            return($sth->fetch());
        }
        catch(PDOException $e){
            return false;
        }

    }

    /**
     * Méthode qui permet de mettre à jour un patient
     * 
     * @return boolean
     */
    public function update($id){

        try{
            $sql = 'UPDATE `patients` 
                    SET `lastname` = :lastname, 
                        `firstname` = :firstname, 
                        `birthdate` = :birthdate, 
                        `phone` = :phone, 
                        `mail` = :mail
                    WHERE `id` = :id;';
            $sth = $this->_pdo->prepare($sql);
            $sth->bindValue(':lastname',$this->_lastname,PDO::PARAM_STR);
            $sth->bindValue(':firstname',$this->_firstname,PDO::PARAM_STR);
            $sth->bindValue(':birthdate',$this->_birthdate,PDO::PARAM_STR);
            $sth->bindValue(':phone',$this->_phone,PDO::PARAM_STR);
            $sth->bindValue(':mail',$this->_mail,PDO::PARAM_STR);
            $sth->bindValue(':id',$id,PDO::PARAM_INT);
            return($sth->execute()); 
        }
        catch(PDOException $e){
            return $e->getCode();
        }

    }


    /**
     * Méthode qui permet de supprimer un patient
     * 
     * @return boolean
     */
    public static function delete($id){

        $pdo = Database::getInstance();

        try{
            $sql = 'DELETE FROM `patients`
                    WHERE `id` = :id;';
            $sth = $pdo->prepare($sql);
            $sth->bindValue(':id',$id,PDO::PARAM_INT);
            $sth->execute();
            if($sth->rowCount()==0)
                return 3;
            else
                return 10;
        }
        catch(PDOException $e){
            return $e->getCode();
        }

    }

    /**
     * Méthode qui permet de compter les patients
     * 
     * @return int
     */
    public static function count($s){
        $pdo = Database::getInstance();
        try{
            $sql = 'SELECT * FROM `patients`
                WHERE `lastname` LIKE :search 
                OR `firstname` LIKE :search;';

            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':search','%'.$s.'%',PDO::PARAM_STR);
            $stmt->execute();
            return($stmt->rowCount());
        }
        catch(PDOException $e){
            return 0;
        }
        
    }
    

}