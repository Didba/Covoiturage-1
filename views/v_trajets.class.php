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
			$html .= $_SESSION['recherche']['lieu_depart'] . ' > ' . $_SESSION['recherche']['lieu_arrivee'] . ' - Le ' . date('d/m/Y', strtotime($_SESSION['recherche']['date'])); // On récupère les données de la requete de l'utilisateur dans la variable de session qu'on a définie dans le controller

			$html .= '</div>';
			$html .= '<ul class="results">';
			$html .= '<h4>Liste des trajets correspondants :</h4>';
			if(empty($list)):$html .= 'Aucun résultat ne correspond à vos critères.'; //Si la liste est vide, on annonce que la recherche n'a retourné aucun résultat
			else:

			foreach ($list as $key => $trajet) {

				$max = $trajet->nb_passagers_rest()-1;

				$html .= '<li class="result">';
				$html .= '<div class="result_data">';
				$html .= '<div class="cities">';
				$html .= ucfirst($trajet->lieu_depart()) . ' > ';
				$html .= ucfirst($trajet->lieu_arrivee());
				$html .= '</div>';
				$html .= date('d/m/y', strtotime($trajet->date_traj())) . '<br />' . date('h:m', strtotime($trajet->date_traj()));
				$html .= '</br>';
				$html .= $trajet->distance() . 'kms';
				$html .= '</br>';
				$html .= gmdate('H\hi',$trajet->time()) . '';
				$html .= '</br>Nombre de passagers : ' . ($trajet->nb_passagers_max()-$trajet->nb_passagers_rest()) . '/' . $trajet->nb_passagers_max();
				$html .= '</div>';
				$html .= '<div class="result_driver">';
				$html .= $trajet->conducteur()->Prenom(). ' ' . substr($trajet->conducteur()->Nom(), 0,1) . '.';
				$html .= '</div>';
				$html .= '<div class="result_resa">';
				$html .= $trajet->frais() . '€ <i>par passager</i>';
					$html .= '</br>';
				if(isset($_SESSION['id'])&& $_SESSION['id']==$trajet->id_adherent())
				{
					$html .= '<p>Vous êtes le conducteur</p>';
				}
				else if(isset($_SESSION['id']))
				{
					if($trajet->nb_passagers_rest()!=0)
					{
						$html .= '<form action="super_controller.php" method="post">
							<input type="hidden" value="new_message" name="application">
							<input type="hidden" value="' . $trajet->lieu_depart() . ' > ' . $trajet->lieu_arrivee() . ', le ' . date('d/m/y', strtotime($trajet->date_traj())) . ' à ' . date('h:m', strtotime($trajet->date_traj())) . '" name="sujet">
							<input type="hidden" name="id_adherent_to" value="'.$trajet->conducteur()->id_adherent().'" name="id_adherent_to">
							<input type="hidden" name="id_adherent_from" value="' . $_SESSION['id'] . '" name="id_adherent_from">
							<input type="submit" name="submit" value="Contacter">
						</form>';


						$html .= '<form action="super_controller.php" method="post">
							<input type="hidden" value="reserver" name="application">
							<input type="hidden" value="' . $trajet->id_trajet() . '" name="id_trajet">
							<input type="hidden" value="' . $_SESSION['id'] . '" name="id_adherent">
							Places supplémentaires : <select name="nb_invites">';
						for ($i=0; $i <= $max; $i++) {
							$html .= '<option value="' . $i . '">' . $i . '</option>';
						}
						$html .= '</select>';

						$html .= '<input type="hidden" name="frais" value="' . $trajet->frais() . '">
							</br><input type="submit" name="submit" class="button" value="Réserver">
						</form>';
					}
					else
					{
						$html .= '<h4>Trajet complet</h4>';
					}
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