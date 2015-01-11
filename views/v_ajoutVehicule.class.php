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

			$html .= $this->get_nav("Mes vehicules");

			//liste des vehicules du conducteur
			$html .= '<h4>Liste de mes véhicules</h4>';
			$html .= '</form>';
			$html .= '<table border=1>';
			$html .= '<tr>';
			$html .= '<th>Marque </th> <th> Modele </th> <th> Type </th> <th> Couleur </th> <th> Carburant </th> <th> immatriculation </th>';
			$html .= '</tr>';
			foreach($elts['vehicule'] as $key => $elt){
				//var_dump($elts);
				$html .= '<tr>';
				$html .= '<td>'.$elt->marque().'</td>';
				$html .= '<td>'.$elt->modele().'</td>';
				$html .= '<td>'.$elt->type().'</td>';
				$html .= '<td style="background-color:'.$elt->couleur().'"></td>';
				$html .= '<td>'.$elt->carburant().'</td>';
				$html .= '<td>'.$elt->immatriculation().'</td>';
				$html .= '</tr>';
			}
			$html .= '</table>';
			$html .= '<br />';

			$html .= '<h4>Ajouter un véhicule</h4>';
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
			$html .= '<div class="button_wrapper"><input type="submit" name="submit" class="button" value="Ajouter"></div>';
			$html .= '</form>';

			//On retourne tout ce qu'on vient de créer en HTML dans l'attribut correspondant de la page
			$this->html = $html;
		}
	}
?>
