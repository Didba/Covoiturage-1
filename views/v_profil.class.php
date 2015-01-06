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

			$html .= '<h4>Mon profil :</h4>';
			$html .= '<ul class="results">';
			$html .= '<img src="images/user.png" width="100" height="100" /><br />';
			$html .= $adherent->prenom() ;
			$html .= '' . $adherent->nom(). '<br />';
			$html .= $adherent->sexe() . '<br />';
			$html .= $adherent->telephone() . '<br />';
			$html .=   date('d/m/Y',strtotime($adherent->date_Naissance())) . '<br />';
			$html .=  $adherent->mail() . '<br />';

			$html .= '<div class="profil_nav">';
			$html .= '<ul>';

			if(isset($_SESSION['permis']))
			{
				$html .= '	<li><a href="super_controller.php?application=proposer">Proposer un trajet</a></li>';
			}

			$html .= '
				<li><a href="super_controller.php?application=mes_trajets">Mes trajets</a></li>
				<li><a href="super_controller.php?application=modif_profil">Modifier mon profil</a></li>
			</ul>'	;
			$html .= '</div>';

			//On retourne tout ce qu'on vient de créer en HTML dans l'attribut correspondant de la page
			$this->html = $html;
		}
	}
?>