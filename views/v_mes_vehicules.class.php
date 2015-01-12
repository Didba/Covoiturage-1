<?php

	include_once 'v_vehicule.class.php';

	/**
	* Classe de la vue pour afficher les vehicules
	*/
	class v_mes_vehicules extends v_vehicule
	{
		/**
		* Défini l'HTML de la page
		**/
		function set_html($elts){

			$html =''; //Initialisation de la variable de retour
			$html .= $this->get_nav('Mes véhicules');
			$html .= $this->get_nav_Vh('Ma liste');
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
				$html .= '<a href="super_controller.php?application=sup_vehicule&id_vehicule=' . $elt->id_vehicule() . '">Supprimer ce véhicule</a>';
				$html .= '</li>';
			}

			$html .= '</ul>';

			//On retourne tout ce qu'on vient de créer en HTML dans l'attribut correspondant de la page
			$this->html = $html;
		}
	}
?>
