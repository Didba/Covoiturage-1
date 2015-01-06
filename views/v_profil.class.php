<?php
	include_once 'views/v_compte.class.php';
	/**
	* Classe de la vue pour afficher les animaux
	*/
	class v_profil extends v_compte
	{
		/**
		* Défini l'HTML de la page
		**/
		function set_html($list){
			extract($list);// On extrait les données contenues dans la liste (qui est un tableau)
			$html =''; //Initialisation de la variable de retour

			$html .= $this->get_nav("Mon profil");

			$html .= '<ul class="results">';
			$html .= '<img src="images/user.png" width="100" height="100" /><br />';
			$html .= $adherent->prenom() ;
			$html .= ' ' . $adherent->nom(). '<br />';
			$html .= $adherent->sexe() . '<br />';
			$html .= $adherent->telephone() . '<br />';
			$html .=   date('d/m/Y',strtotime($adherent->date_Naissance())) . '<br />';
			$html .=  $adherent->mail() . '<br />';

			//On retourne tout ce qu'on vient de créer en HTML dans l'attribut correspondant de la page
			$this->html = $html;
		}
	}
?>