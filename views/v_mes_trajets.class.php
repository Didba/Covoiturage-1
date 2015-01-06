<?php

	include_once 'v_compte.class.php';

	/**
	* Classe de la vue pour afficher les animaux
	*/
	class v_mes_trajets extends v_compte
	{
		/**
		* Défini l'HTML de la page
		**/
		function set_html($elts){

			$html =''; //Initialisation de la variable de retour

			$html .= $this->get_nav("Mes trajets");

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