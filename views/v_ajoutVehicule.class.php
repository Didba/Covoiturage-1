<?php

	include_once 'Page.class.php';

	/**
	* Classe de la vue pour afficher les vehicules
	*/
	class v_ajoutVehicule extends Page
	{
		/**
		* Défini l'HTML de la page
		**/
		function set_html(){
			
			$html =''; //Initialisation de la variable de retour

			$html .= '<h3>Ajouter véhicule</h3>';
			$html .= '<form method="post" action="super_controller.php">';
			$html .= '<input type="hidden" name="application" value="nouvelle_proposition" required><br>';
			$html .= '<input type="text" name="marque" placeholder="marque" required><br>';
			$html .= '<br /><input type="text" name="modele" placeholder="modele" required><br>';
			$html .= '<br /><input type="text" name="type" placeholder="type" required><br>';
			$html .= '<br /><input type="text" name="couleur" placeholder="couleur" required><br>';
			$html .= '<br /><input type="text" name="carburant" placeholder="carburant" required><br>';
			$html .= '<br /><input type="text" name="immarticulation" placeholder="immarticulation" required><br>';
			$html .= '<input type="submit" name="submit" class="button" value="Go !">';
			$html .= '</form>';

			//On retourne tout ce qu'on vient de créer en HTML dans l'attribut correspondant de la page
			$this->html = $html;
		}
	}
?>