<?php

	include_once 'Page.class.php';
	/**
	* Classe de la vue pour afficher les animaux
	*/
	class v_message extends Page
	{
		/**
		* Défini l'HTML de la page
		**/
		function set_html(){

			$html =''; //Initialisation de la variable de retour

			$html .= '<h3>Messagerie</h3>';
			$html .= '<form method="post" action="super_controller.php">';
			$html .= '<input type="hidden" name="application" value="nouvelle_message" required><br>';
			$html .= '<input type="text" name="Id_Adherent_From" placeholder="From" required><br>';
			$html .= '<br /><input type="text" name="Id_Addherent_To" placeholder="To" required><br>';
			$html .= '<br /><input type="date" name="date" value="date" required><br>';
			$html .= '<br /><input type="text" name="sujet" placeholder="sujet" required><br>';
			$html .= '<br /><textarea name="message" rows="10" cols="50">Saisir votre message ici.</textarea><br>';
			$html .= '<input type="submit" name="submit" class="button" value="GO !">';
			$html .= '</form>';

			//On retourne tout ce qu'on vient de créer en HTML dans l'attribut correspondant de la page
			$this->html = $html;
		}
	}
?>