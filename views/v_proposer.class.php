<?php

	include_once 'views/v_compte.class.php';

	class v_proposer extends v_compte
	{
		/**
		* Défini l'HTML de la page
		**/
		function set_html($elts){

			$html =''; //Initialisation de la variable de retour
			$html .= $this->get_nav("Proposer un trajet");

			$html .= '<form method="post" action="super_controller.php" class="form">';
			$html .= '<input type="hidden" name="application" value="nouvelle_proposition" required>';
			$html .= '<input type="hidden" name="Id_Adherent" value="' . $_SESSION['id'] . ' " required>';
			$html .= '<br /><input type="hidden" name="Num_Permis" value="' . $_SESSION['permis'] . ' " required>';
			$html .= '<br />';
			$html .= '<label for="lieu_depart">Lieu de départ : </label><input type="text" id="depart" name="lieu_depart" placeholder="Lieu de départ" required><br>';
			$html .= '<br /><label for="lieu_arrivee">Lieu d\'arrivée : </label><input type="text" id="arrivee" name="lieu_arrivee" placeholder="Lieu d\'arrivée" required><br>';
			$html .= '<br /><label for="date">Date : </label><input type="date" name="date" value="' . date('Y-m-d') . '" required><br>';
			$html .= '<br /><label for="heure">Heure : </label><input type="time" name="heure" value="12:00" required><br>';
			$html .= '<br /><label for="caracteristique">Caracteristique : </label>';
			foreach ($elts['caracteristique'] as $key => $carac) {
				$html .= '<p><input type="checkbox" name="caracteristique[]" value="'.$carac->id_caracteristique().'" />'.$carac->nom().'</p>';
			}
			$html .= '<br /><label for="nb_passagers_max">Nombre de passagers : </label><input type="number" name="nb_passagers_max" required><br>';
			$html .= '<br /><label for="commentaire">Commentaire : </label><textarea name="commentaire" rows="10" cols="50" placeholder="Saisir les informations du trajet ici"></textarea><br>';
			$html .= '<div class="button_wrapper"><input type="submit" name="submit" class="button" value="GO !"></div>';
			$html .= '</form>';

			//On retourne tout ce qu'on vient de créer en HTML dans l'attribut correspondant de la page
			$this->html = $html;
		}
	}
?>