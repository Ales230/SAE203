<?php
session_start();
try{
    $db = new PDO(
        'mysql:host=localhost;dbname=location_materiel;charset=utf8',
        'root'
    );    
    $db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(Exception $e){
    die('Erreur'.$e->getMessage());
    
}