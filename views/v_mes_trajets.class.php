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

			$html .= '<h3>Mes trajets</h3>';
			$html .= '<ul>';
			foreach ($elts as $key => $elt) {
				$html .= '<li>';
				$html .= $elt->date_traj();
				$html .= '</br>';
				$html .= $elt->lieu_depart() . ' > ' . $elt->lieu_arrivee();
				$html .= '</br>';
				$html .= $elt->conducteur()->nom() . ' ' . $elt->conducteur()->prenom();
				$html .= '</li>';
			}

			$html .= '</ul>';

			//On retourne tout ce qu'on vient de créer en HTML dans l'attribut correspondant de la page
			$this->html = $html;
		}
	}
?>