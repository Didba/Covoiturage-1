<?php

	include_once 'Page.class.php';
	/**
	* Classe de la vue pour afficher les animaux
	*/
	class v_trajets extends Page
	{
		/**
		* Défini l'HTML de la page
		**/
		function set_html($list){

			$html =''; //Initialisation de la variable de retour

			$html .= '<div class="query_data">';

			$html .= $_SESSION['recherche']['Lieu_Depart'] . ' > ' . $_SESSION['recherche']['Lieu_arrivee'] . ' - ' . $_SESSION['recherche']['date']; //on récupère les données de la requete de l'utilisateur dans la varible de session qu'on a défini dans le controller

			$html .= '</div>';
			$html .= '<ul class="results">';
			foreach ($list as $key => $trajet) {
				$html .= '<li class="result">Trajet n°' . $trajet->id_trajet() . ' - ' .  $trajet->conducteur()->Prenom(). ' ' . substr($trajet->conducteur()->Nom(), 0,1) . '.</li>';
			}
			$html .= '</ul>';

			//On retourne tout ce qu'on vient de créer en HTML dans l'attribut correspondant de la page
			$this->html = $html;
		}
	}



?>