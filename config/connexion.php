<?php

    // Connexion à la base de données: Si la base existe, aucune erreur n'est relevée, on indique dans la variable gloable "co" que tout est bon. Sinon, on se connecte sans préciser de base, et on l'indique par un message d'alerte.
    try
    {
        $db = new PDO('mysql:host=localhost;dbname=covoiturage', 'root', '');
        $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        $db->query("SET lc_time_names = 'fr_FR'");
        $db->exec("SET CHARACTER SET utf8");
    }
    catch(Exception $e)
    {
        echo "Echec de la connexion de connexion";
    }

    define('SALT', '²ebdè"nk'); // A éventuellement ajouter au chiffrage des mots de passe

?>