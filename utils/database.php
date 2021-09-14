<?php

require_once dirname(__FILE__).'/../config/config.php';

class Database{

    private static $_pdo;

    public static function getInstance(){
        try{
            if(is_null(self::$_pdo)){
                self::$_pdo = new PDO(DSN, LOGIN, PASSWORD);
                self::$_pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$_pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            }
            
        }catch(PDOException $e){
           echo 'erreur de connexion à la BDD : '. $e->getMessage();
        }
        return self::$_pdo;

    }
}