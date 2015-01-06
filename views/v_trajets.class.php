<?php

	include_once 'Page.class.php';
	/**
	* Classe de la vue pour afficher les animaux
	*/
	class v_trajets extends Page
	{
		/**
		* Défini l'HTML de la page
		**/
		function set_html($list){

			$html =''; //Initialisation de la variable de retour

			$html .= '<div class="query_data">';
			$html .= '<h3>Recherche</h3>';
			$html .= $_SESSION['recherche']['Lieu_Depart'] . ' > ' . $_SESSION['recherche']['Lieu_arrivee'] . ' - Le ' . date('d/m/Y', strtotime($_SESSION['recherche']['date'])); // On récupère les données de la requete de l'utilisateur dans la variable de session qu'on a définie dans le controller

			$html .= '</div>';
			$html .= '<ul class="results">';
			$html .= '<h4>Liste des trajets correspondants :</h4>';
			if(empty($list)):$html .= 'Aucun résultat ne correspond à vos critères.'; //Si la liste est vide, on annonce que la recherche n'a retourné aucun résultat
			else:

			foreach ($list as $key => $trajet) {
				$html .= '<li class="result">';
				$html .= '<div class="result_data">';
				$html .= ucfirst($trajet->date_traj());
				$html .= '</br>';
				$html .= $trajet->distance() . 'kms';
				$html .= '</br>';
				$html .= gmdate('H\hi',$trajet->time()) . '';
				$html .= '</br>';
				$html .= $trajet->frais() . '€';
				$html .= '</div>';
				$html .= '<div class="result_driver">';
				$html .= $trajet->conducteur()->Prenom(). ' ' . substr($trajet->conducteur()->Nom(), 0,1) . '.';
				$html .= '</div>';
				$html .= '<div class="result_resa">';
				if(isset($_SESSION['id']))
				{
					$html .= '<form action="super_controller.php" method="post">
						<input type="hidden" value="reserver" name="application">
						<input type="hidden" value="' . $trajet->id_trajet() . '" name="id_trajet">
						<input type="hidden" value="' . $_SESSION['id'] . '" name="id_adherent">
						</br>Places : <input type="number" name="nb_invites" value="0">
						<input type="hidden" name="frais" value="' . $trajet->frais() . '">
						</br><input type="submit" name="submit" class="button" value="Réserver">
					</form>';
				}
				else
				{
					$html .= '<p>Connectez vous pour réserver</p>';
				}

				$html .= '</div>';
				$html .= '</li>';
			}
			$html .= '</ul>';
			endif;
			//On retourne tout ce qu'on vient de créer en HTML dans l'attribut correspondant de la page
			$this->html = $html;
		}
	}



?>