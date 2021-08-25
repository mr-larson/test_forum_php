<?php
require ('actions/database.php');
//Validate Form
if (isset($_POST['validate'])) {
    //Validate DataBase User
    if(!empty($_POST['pseudo']) && !empty($_POST['lastname']) && !empty($_POST['firstname']) && !empty($_POST['password'])) {
        $user_pseudo = htmlspecialchars($_POST['pseudo']);
        $user_lastname = htmlspecialchars($_POST['lastname']);
        $user_firstname = htmlspecialchars($_POST['firstname']);
        $user_password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        //Checking if user already exists
        $checkIfUserAlreadyExists = $bdd->prepare('SELECT * FROM users WHERE pseudo = ?');
        $checkIfUserAlreadyExists->execute(array($user_pseudo));

        if($checkIfUserAlreadyExists->rowCount() == 0) {
            $insertUser = $bdd->prepare('INSERT INTO users (pseudo, lastname, firstname, password) VALUES (?, ?, ?, ?)');
            $insertUser->execute(array($user_pseudo, $user_lastname, $user_firstname, $user_password));

            $getInfosUser = $bdd->prepare('SELECT id FROM users WHERE pseudo = ? AND lastname = ? AND firstname = ?');
            $getInfosUser->execute(array($user_pseudo, $user_lastname, $user_firstname));

            $user_id = $getInfosUser->fetch()['id'];

            $_SESSION['auth'] = true;
            $_SESSION['user_id'] = $user_id;
            $_SESSION['user_pseudo'] = $user_pseudo;
            $_SESSION['user_lastname'] = $user_lastname;
            $_SESSION['user_firstname'] = $user_firstname;

        } else {
            $errorMsg = '<div class="alert alert-danger" role="alert">Le pseudo que vous avez saisi existe déjà !</div>';
        }

    } else {
        $errorMsg = "Veuillez compléter tous les champs ...";
    }
}