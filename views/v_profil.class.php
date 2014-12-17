﻿<?php
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

			$html .= '<h4>Mon profil :</h4>';
			$html .= '<ul class="results">';
			$html .= '<img src="images/user.png" width="100" height="100" /><br />';
			$html .= '<class="result"><br /><b>Nom :     </b>' . $adherent->nom() . '</class><br />';
			$html .= '<br /><class="result"><b>Prenom :  </b>' . $adherent->prenom() . '</class><br />';
			$html .= '<br /><class="result"><b>Sexe :    </b>' . $adherent->sexe() . '</class><br />';
			$html .= '<br /><class="result"><b>Tel :     </b>'.  $adherent->telephone() . '</class><br />';
			$html .= '<br /><class="result"><b>Date naiss : </b>' .   date('d/m/Y',strtotime($adherent->date_Naissance())) . '</class><br />';
			$html .= '<br /><class="result"><b>Mail : </b>' .  $adherent->mail() . '</class><br />';

			//On retourne tout ce qu'on vient de créer en HTML dans l'attribut correspondant de la page
			$this->html = $html;
		}
	}
?>