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

			$html .= '<aside>';
			$html .= '<ul>';


			$html .= $this->get_nav('Vehicules');

			$html .= '
				<div id="menu">
				<ul id="onglets">
				<li class="active"><a href="super_controller.php?application=mes_vehicules"><h4>Liste véhicules</h4></a></li>
				<li><a href="super_controller.php?application=new_vehicule"><h4>Ajouter nouveau</h4></a></li>

			</ul>
			</div>'	;

			$html .= '</aside>';
			
			//liste des vehicules du conducteur
			foreach($elts['vehicule'] as $key => $elt){
				//var_dump($elts);
				$html .= '<b>Marque : </b>'.$elt->marque().'</br>';
				$html .= '<b>Modèle : </b>'.$elt->modele().'</br>';
				$html .= '<b>Type : </b>'.$elt->type().'</br>';
				$html .= '<b>Couleur : <font color='.$elt->couleur().'>'.$elt->couleur().'</font></b></br>';
				$html .= '<b>Carburant : </b>'.$elt->carburant().'</br>';
				$html .= '<b>Immatriculation : </b>'.$elt->immatriculation().'</br>';
				$html .= '<hr>';
			}
			
			

			//On retourne tout ce qu'on vient de créer en HTML dans l'attribut correspondant de la page
			$this->html = $html;
		}
	}
?>
