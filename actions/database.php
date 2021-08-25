<?php

/* methode poo */
/* class Database{
    public function __construct(){

} */
try {
    session_start();
    $bdd = new PDO('mysql:host=localhost;dbname=test;charset=utf8', 'root', 'root');
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}
