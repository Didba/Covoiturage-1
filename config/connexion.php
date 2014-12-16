<?php

    // Connexion à la base de données: Si la base existe, aucune erreur n'est relevée, on indique dans la variable gloable "co" que tout est bon. Sinon, on se connecte sans préciser de base, et on l'indique par un message d'alerte.
    try
    {
        $db = new PDO('mysql:host=localhost;dbname=covoiturage', 'root', '');
        $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        $db->query("SET lc_time_names = 'fr_FR'");
        $db->exec("SET CHARACTER SET utf8");

        // /**
        // * On vérifie maintenant si la table "produits" existe. Si oui, o valide la connexion dans la supervariable co, sinon on précise le message
        // **/

        // $check = $db->query("SELECT 1 FROM produits");
        // if ($check !== FALSE) {
        //     $_SESSION['co'] = true;
        // }
        // else
        // {
        //     $_SESSION['msg'] = 'La table "produits" n\'existe pas. Vous pouvez la créer depuis le menu.'; //die('Erreur : '.$e->getMessage());
        //     $_SESSION['co'] = false;
        // }
    }
    catch(Exception $e)
    {
        echo "Prob de connexion";
        // $db = new PDO('mysql:host=localhost', 'root', '');
        // $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        // $db->query("SET lc_time_names = 'fr_FR'");
        // $db->exec("SET CHARACTER SET utf8");
        // $_SESSION['msg'] = "La base de données n'existe pas. Vous pouvez la créer depuis le menu."; //die('Erreur : '.$e->getMessage());
        // $_SESSION['co'] = false;
    }

    define('SALT', '²ebdè"nk');

?>