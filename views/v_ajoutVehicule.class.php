<?php

	include_once 'v_compte.class.php';

	/**
	* Classe de la vue pour afficher les vehicules
	*/
	class v_ajoutVehicule extends v_compte
	{
		/**
		* Défini l'HTML de la page
		**/
		function set_html($elts){

			$html =''; //Initialisation de la variable de retour
			$html .= '<aside>';
			$html .= '<ul>';
			$html .= $this->get_nav('Ajout de vehicule');

			$html .= '
				<div id="menu">
				<ul id="onglets">
				<li><a href="super_controller.php?application=mes_vehicules"><h4>Liste véhicules</h4></a></li>
				<li class="active"><a href="super_controller.php?application=new_vehicule"><h4>Ajouter nouveau</h4></a></li>

			</ul>
			</div>'	;

			$html .= '</aside>';

			
			$html .= '<form method="post" action="super_controller.php">';
			$html .= '<input type="hidden" name="application" value="nouvel_ajoutVehicule" required>';
			$html .= '<label for="marque">Marque : </label><input type="text" name="marque" required>';
			$html .= '<br /><label for="modele">Modele : </label><input type="text" name="modele" required>';
			$html .= '<br /><label for="type">Type : </label><select name="type" required>';
			foreach ($elts['types'] as $key => $carb) {
				$html .= '	<option value="' . $carb->id_type() . '">' . $carb->libelle() . '</option>';
			}
			$html .= '</select>';
			$html .= '<br /><label for="couleur">Couleur : </label><input type="text" name="couleur" required>';
			$html .= '<br /><label for="carburant">Carburant : </label><select name="carburant" required>';
			foreach ($elts['carburants'] as $key => $carb) {
				$html .= '	<option value="' . $carb->id_carburant() . '">' . $carb->libelle() . '</option>';
			}
			$html .= '</select>';
			$html .= '<br /><label for="immatriculation">N° d\'immatriculation : </label><input type="text" name="immatriculation" required>';
			$html .= '<br />';
			$html .= '<input type="submit" name="submit" class="button" value="Go !">';
			$html .= '</form>';

			//On retourne tout ce qu'on vient de créer en HTML dans l'attribut correspondant de la page
			$this->html = $html;
		}
	}
?>
