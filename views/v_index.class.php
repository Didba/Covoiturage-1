<?php

	include_once 'Page.class.php';
	/**
	* Classe de la vue pour afficher les animaux
	*/
	class v_index extends Page
	{
		/**
		* Défini l'HTML de la page
		**/
		function set_html(){

			$html =''; //Initialisation de la variable de retour

			$html .= '';

			$html .= '<div class="index_wrapper">';
			$html .= '<h2>Où voulez vous aller?</h2>';
			$html .= '<form method="post" action="super_controller.php" class="index_form">';
			$html .= '<input type="hidden" name="apptype" value="Display">';
			$html .= '<input type="hidden" name="application" value="recherche">';
			$html .= '<input type="text" name="start" placeholder="Départ">';
			$html .= '<input type="text" name="finish" placeholder="Destination">';
			$html .= '<input type="date" name="date" value="2014-05-21">';
			$html .= '<input type="time" name="time" value="18:25:00">';
			$html .= '<input type="image" name="submit">';
			$html .= '</form>';
			$html .= '</div>';

			//On retourne tout ce qu'on vient de créer en HTML dans l'attribut correspondant de la page
			$this->html = $html;
		}
	}



?>