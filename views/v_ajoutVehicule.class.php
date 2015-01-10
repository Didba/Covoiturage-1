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

			$html .= '<h3>Ajouter véhicule</h3>';
			$html .= '<form method="post" action="super_controller.php">';
			$html .= '<input type="hidden" name="application" value="nouvelle_proposition" required><br>';
			$html .= '<input type="text" name="marque" placeholder="marque" required><br>';
			$html .= '<br /><input type="text" name="modele" placeholder="modele" required><br>';
			$html .= '<br /><input type="text" name="type" placeholder="type" required><br>';
			$html .= '<br /><input type="text" name="couleur" placeholder="couleur" required><br>';
			$html .= '<br /><input type="text" name="carburant" placeholder="carburant" required><br>';
			$html .= '<br /><input type="text" name="immarticulation" placeholder="immarticulation" required><br>';
			$html .= '<input type="submit" name="submit" class="button" value="Go !">';
			$html .= '</form>';
			
			//liste des vehicules du conducteur
			$html .= '<h3>Liste des véhicules</h3>';
			$html .= '</form>';
			$html .= '<table border=1>';
			$html .= '<tr>';
			$html .= '<th>Marque </th> <th> Modele </th> <th> Type </th> <th> Couleur </th> <th> Carburant </th> <th> Immarticulation </th>';
			$html .= '</tr>';
			foreach($elts['vehicule'] as $key => $elt){
				//var_dump($elts);
				$html .= '<tr>';
				$html .= '<td>'.$elt->marque().'</td>';
				$html .= '<td>'.$elt->modele().'</td>';
				$html .= '<td>'.$elt->type().'</td>';
				$html .= '<td>'.$elt->couleur().'</td>';
				$html .= '<td>'.$elt->carburant().'</td>';
				$html .= '<td>'.$elt->immarticulation().'</td>';
				$html .= '<td>'.$elt->immarticulation().'</td>';
				$html .= '</tr>';
			}
			$html .= '</table>';

			//On retourne tout ce qu'on vient de créer en HTML dans l'attribut correspondant de la page
			$this->html = $html;
		}
	}
?>