<?php

	include_once 'Page.class.php';

	/**
	* Classe de la vue pour afficher les animaux
	*/
	class v_proposer extends Page
	{
		/**
		* Défini l'HTML de la page
		**/
		function set_html(){

			$html =''; //Initialisation de la variable de retour

			$html .= '<h3>Itinéraire</h3>';
			$html .= '<form method="post" action="super_controller.php">';
			$html .= '<input type="hidden" name="application" value="nouvelle_proposition" required>';
			$html .= '<input type="hidden" name="Id_Adherent" value="' . $_SESSION['id'] . ' " required>';
			$html .= '<br /><input type="hidden" name="Num_Permis" value="' . $_SESSION['permis'] . ' " required>';
			$html .= '<br /><input type="text" name="Lieu_Depart" placeholder="Lieu de départ" required><br>';
			$html .= '<br /><input type="text" name="Lieu_arrivee" placeholder="Lieu d\'arrivée" required><br>';
			$html .= '<br /><input type="date" name="date" required><br>';
			$html .= '<br /><input type="time" name="heure" required><br>';
			$html .= '<br /><input type="number" name="Nb_Passagers_Max" placeholder="Nb passagers" required><br>';
			$html .= '<br /><textarea name="Commentaire" rows="10" cols="50">Saisir les informations du trajet ici.</textarea><br>';
			$html .= '<input type="submit" name="submit" class="button" value="Go !">';
			$html .= '</form>';

			//On retourne tout ce qu'on vient de créer en HTML dans l'attribut correspondant de la page
			$this->html = $html;
		}
	}
?>