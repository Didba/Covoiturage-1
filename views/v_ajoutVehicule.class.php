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
			$html .= '<h4>Liste des véhicules</h4>';
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

			$html .= '<h4>Ajouter véhicule</h4>';
			$html .= '<form method="post" action="super_controller.php">';
			$html .= '<input type="hidden" name="application" value="nouvel_ajoutVehicule" required><br>';
			$html .= '<input type="text" name="marque" placeholder="marque" required><br>';
			$html .= '<br /><input type="text" name="modele" placeholder="modele" required><br>';
			$html .= '<br /><select name="type" required>';
			foreach ($elts['types'] as $key => $carb) {
				$html .= '	<option value="' . $carb->id_type() . '">' . $carb->libelle() . '</option>';
			}
			$html .= '</select>';
			$html .= '<br /><input type="text" name="couleur" placeholder="couleur" required><br>';
			$html .= '<br /><select name="carburant" required>';
			foreach ($elts['carburants'] as $key => $carb) {
				$html .= '	<option value="' . $carb->id_carburant() . '">' . $carb->libelle() . '</option>';
			}
			$html .= '</select>';
			$html .= '<br>';
			$html .= '<br /><input type="text" name="immatriculation" placeholder="immatriculation" required><br>';
			$html .= '<input type="submit" name="submit" class="button" value="Go !">';
			$html .= '</form>';

			//On retourne tout ce qu'on vient de créer en HTML dans l'attribut correspondant de la page
			$this->html = $html;
		}
	}
?>
