<?php

session_start();

include('../config/bd.php');

//Si session deja ok, on ne retourne plus sur signin
if(isset($_SESSION['id'])){
    header('Location: index.php');
    exit;
}

//Si la variable $_POST est remplie, on traite le form
if(!empty($_POST)){
    extract($_POST);
    $valid = true; 
}

// On prend le bon formulaire grâce au "name" de la balise "input"

if(isset($_POST('inscription'))){
    

    $mail = htmlentities(strtolower(trim($mail)));
    $login = htmlentities(trim($login));
    $password = trim($password);

//verif

if(empty($mail)){
    $valid=false;
    $mailnotok = "Le mail ne peux pas être vide";
}

if(empty($login)){
    $valid=false;
    $loginnotok = "le login ne peux pas être vide";
}

if(empty($password)){
    $valid=false;
    $passwordnotok = "le mot de passe ne peux pas être vide";
}
    
    