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

			$html .= '<div class="index_wrapper">';
			$html .= '<h2>Où voulez vous aller?</h2>';
			$html .= '<form method="post" action="super_controller.php?apptype=Display&application=recherche" class="index_form">';
			$html .= '<input type="text" name="start" placeholder="Départ" required>';
			$html .= '<input type="text" name="finish" placeholder="Destination" required>';
			$html .= '<input type="date" name="date" value="2014-12-16" required>';
			$html .= '<input type="submit" name="submit" class="button" value="GO !">';
			$html .= '</form>';
			$html .= '</div>';

			//On retourne tout ce qu'on vient de créer en HTML dans l'attribut correspondant de la page
			$this->html = $html;
		}
	}
?>