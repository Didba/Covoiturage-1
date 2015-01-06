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
<<<<<<< HEAD

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
=======
			
			
			$html .= '<aside>';
>>>>>>> origin/master
			$html .= '<ul>';

			if(isset($_SESSION['permis']))
			{
				$html .= '	<li><a href="super_controller.php?application=proposer">Proposer un trajet</a></li>';
			}

			$html .= '
<<<<<<< HEAD
				<li><a href="super_controller.php?application=mes_trajets">Mes trajets</a></li>
				<li><a href="super_controller.php?application=modif_profil">Modifier mon profil</a></li>
			</ul>'	;
			$html .= '</div>';
=======
				<div id="menu">
				<ul id="onglets">
				<li class="active"><a href="super_controller.php?application=profil&id=' . $_SESSION['id'].'"><h4>Mon profil</h4> </a></li>
				<li><a href="super_controller.php?application=mes_trajets"><h4>Mes trajets</h4></a></li>
				<li><a href="super_controller.php?application=modif_profil"><h4>Modifier mon profil</h4></a></li>
				<li><a href="super_controller.php?application=mes_messages"><h4>Mes messages</h4></a></li>
			</ul>
			</div>'	;
			
			$html .= '</aside>';
			
			$html .= '<ul class="results">';
			$html .= '<img src="images/user.png" width="100" height="100" /><br />';
			$html .= '<class="result"><br /><b>Nom :     </b>' . $adherent->nom() . '</class><br />';
			$html .= '<br /><class="result"><b>Prenom :  </b>' . $adherent->prenom() . '</class><br />';
			$html .= '<br /><class="result"><b>Sexe :    </b>' . $adherent->sexe() . '</class><br />';
			$html .= '<br /><class="result"><b>Tel :     </b>'.  $adherent->telephone() . '</class><br />';
			$html .= '<br /><class="result"><b>Date naiss : </b>' .   date('d/m/Y',strtotime($adherent->date_Naissance())) . '</class><br />';
			$html .= '<br /><class="result"><b>Mail : </b>' .  $adherent->mail() . '</class><br />';

>>>>>>> origin/master

			//On retourne tout ce qu'on vient de créer en HTML dans l'attribut correspondant de la page
			$this->html = $html;
		}
	}
?>