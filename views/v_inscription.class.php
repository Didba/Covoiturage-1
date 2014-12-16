<?php

	include_once 'Page.class.php';
	/**
	* Classe de la vue pour afficher les animaux
	*/
	class v_inscription extends Page
	{
		/**
		* Défini l'HTML de la page
		**/
		function set_html(){

			$html =''; //Initialisation de la variable de retour

			$html .= '<h3>Inscription</h3>';
			$html .= '<form method="post" action="super_controller.php">';
			$html .= '<input type="hidden" name="application" value="nouvelle_inscription" required><br>';
			$html .= '<input type="text" name="prenom" placeholder="Prénom" required><br>';
			$html .= '<input type="text" name="nom" placeholder="Nom" required><br>';
			$html .= '&male;<input type="radio" name="sexe" value="1" checked> &female;<input type="radio" name="sexe" value="0" required><br>';
			$html .= '<input type="date" name="dateNaiss" value="2014-12-16" required><br>';
			$html .= '<input type="text" name="telephone" placeholder="N° téléphone" required><br>';
			$html .= '<input type="text" name="mail" placeholder="Email" required><br>';
			$html .= '<input type="password" name="password" placeholder="Mot de passe" required><br>';
			$html .= '<input type="submit" name="submit" class="button" value="GO !">';
			$html .= '</form>';

			//On retourne tout ce qu'on vient de créer en HTML dans l'attribut correspondant de la page
			$this->html = $html;
		}
	}
?>