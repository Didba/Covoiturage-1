<?php

	include_once 'Page.class.php';

	/**
	* Classe de la vue pour afficher les animaux
	*/
	class v_mes_trajets extends Page
	{
		/**
		* Défini l'HTML de la page
		**/
		function set_html($elts){
		
			$html =''; //Initialisation de la variable de retour
			
			$html .= '<aside>';
			$html .= '<ul>';

			if(isset($_SESSION['permis']))
			{
				$html .= '	<li><a href="super_controller.php?application=proposer">Proposer un trajet</a></li>';
			}

			$html .= '
				<div id="menu">
				<ul id="onglets">
				<li><a href="super_controller.php?application=profil&id=' . $_SESSION['id'].'"> <h4>Mon profil</h4> </a></li>
				<li  class="active"><a href="super_controller.php?application=mes_trajets"><h4>Mes trajets</h4></a></li>
				<li><a href="super_controller.php?application=modif_profil"><h4>Modifier mon profil</h4></a></li>
				<li><a href="super_controller.php?application=mes_messages"><h4>Mes messages</h4></a></li>
			</ul>
			</div>'	;
			
			$html .= '</aside>';
			
			foreach ($elts as $key => $elt) {
				$html .= '<li>';
				$html .= $elt->date_traj();
				$html .= '</br><b>';
				$html .= $elt->lieu_depart() . ' > ' . $elt->lieu_arrivee();
				$html .= '</br></b>';
				$html .= $elt->conducteur()->nom() . ' ' . $elt->conducteur()->prenom();
				$html .='<hr>';
				$html .= '</li>';
				$html .= '</br>';
			}

			$html .= '</ul>';
			

			//On retourne tout ce qu'on vient de créer en HTML dans l'attribut correspondant de la page
			$this->html = $html;
		}
	}
?>