<?php
	include_once 'views/Page.class.php';
	/**
	* Classe de la vue pour afficher les animaux
	*/
	class v_profil extends Page
	{
		/**
		* Défini l'HTML de la page
		**/
		function set_html($list){
			extract($list);// On extrait les données contenues dans la liste (qui est un tableau)

			$html =''; //Initialisation de la variable de retour

			$html .= '<h4>Profil :</h4>';
			$html .= '<ul class="results">';
			$html .= '<li class="result">Membre n°' . $adherent->Id_Adherent() . '  ' .  $adherent->Prenom(). ' ' . $adherent->Nom(). ' ' . $adherent->sexe() .  $adherent->telephone() .   $adherent->Date_Naissance() .  $adherent->mail(). '</li>';

			//On retourne tout ce qu'on vient de créer en HTML dans l'attribut correspondant de la page
			$this->html = $html;
		}
	}
?>