<?php

	include_once 'v_compte.class.php';

	/**
	* Classe de la vue pour afficher les vehicules
	*/
	class v_mes_vehicules extends v_compte
	{
		/**
		* Défini l'HTML de la page
		**/
		function set_html($elts){

			$html =''; //Initialisation de la variable de retour

			$html .= '<ul>';

			$html .= $this->get_nav('Vehicules');

			$html .= '
				<div id="menu">
				<ul id="onglets">
				<li class="active"><a href="super_controller.php?application=mes_vehicules"><h4>Mes véhicules</h4></a></li>
				<li><a href="super_controller.php?application=new_vehicule"><h4>Ajouter un nouveau véhicule</h4></a></li>

			</ul>
			</div>'	;
			$html .= '<ul>';
			//liste des vehicules du conducteur
			foreach($elts['vehicule'] as $key => $elt){

				$html .= '<li class="vehicule">';
				$html .= '<b>Marque : </b>'.$elt->marque().'</br>';
				$html .= '<b>Modèle : </b>'.$elt->modele().'</br>';
				$html .= '<b>Type : </b>'.$elt->type().'</br>';
				$html .= '<b>Couleur : </b><div class="colortile" style="background-color:' . $elt->couleur() . '"></div></br>';
				$html .= '<b>Carburant : </b>'.$elt->carburant().'</br>';
				$html .= '<b>Immatriculation : </b>'.$elt->immatriculation().'</br>';
				$html .= '</li>';
			}

			$html .= '</ul>';

			//On retourne tout ce qu'on vient de créer en HTML dans l'attribut correspondant de la page
			$this->html = $html;
		}
	}
?>
