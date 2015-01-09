<?php

	include_once 'views/v_compte.class.php';

	class v_proposer extends v_compte
	{
		/**
		* Défini l'HTML de la page
		**/
		function set_html(){

			$html =''; //Initialisation de la variable de retour
			$html .= $this->get_nav("Proposer un trajet");

			$html .= '<form method="post" action="super_controller.php" class="form">';
			$html .= '<input type="hidden" name="application" value="nouvelle_proposition" required>';
			$html .= '<input type="hidden" name="Id_Adherent" value="' . $_SESSION['id'] . ' " required>';
			$html .= '<br /><input type="hidden" name="Num_Permis" value="' . $_SESSION['permis'] . ' " required>';
			$html .= '<br /><input type="text" id="depart" name="Lieu_Depart" placeholder="Lieu de départ" required><br>';
			$html .= '<br /><input type="text" id="arrivee" name="Lieu_arrivee" placeholder="Lieu d\'arrivée" required><br>';
			$html .= '<br /><input type="date" name="date" value="' . date('Y-m-d') . '" required><br>';
			$html .= '<br /><input type="time" name="heure" value="12:00" required><br>';
			$html .= '<br /><input type="number" name="Nb_Passagers_Max" placeholder="Nb passagers" required><br>';
			$html .= '<br /><textarea name="commentaire" rows="10" cols="50" placeholder="Saisir les informations du trajet ici"></textarea><br>';
			$html .= '<div class="button_wrapper"><input type="submit" name="submit" class="button" value="GO !"></div>';
			$html .= '</form>';

			//On retourne tout ce qu'on vient de créer en HTML dans l'attribut correspondant de la page
			$this->html = $html;
		}
	}
?>