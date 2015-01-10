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
			$html .= '<h4>En tant que passager</h4>';
			$html .= '<ul>';
			foreach ($elts['passager'] as $key => $elt) {
				$html .= '<li class="result">';
				$html .= '<div class="result_data">';
				$html .= '<div class="cities">';
				$html .= ucfirst($elt->trajet()->lieu_depart()) . ' > ';
				$html .= ucfirst($elt->trajet()->lieu_arrivee());
				$html .= '</div>';
				$html .= '<div class="heure">';
				$html .= date('h:m', strtotime($elt->trajet()->date_traj()));
				$html .= '</div>';
				$html .= date('d/m/y', strtotime($elt->trajet()->date_traj()));
				$html .= '<br />';
				$html .= $elt->trajet()->distance() . 'kms';
				$html .= '</br>';
				$html .= gmdate('H\hi',$elt->trajet()->time()) . '';
				$html .= '</br>Places invité(s) réservées : ' . $elt->nb_invites();
				$html .= '</br>Nombre de passagers : ' . ($elt->trajet()->nb_passagers_max()-$elt->trajet()->nb_passagers_rest()) . '/' . $elt->trajet()->nb_passagers_max();
				$html .= '</div>';
				$html .= '<div class="result_driver">';
				$html .= $elt->conducteur()->prenom(). ' ' . substr($elt->conducteur()->nom(), 0,1) . '.';
				$html .= '</div>';
				$html .= '<div class="result_resa">';
				$html .= $elt->trajet()->frais() . '€';
				$html .= '</br>';
				$html .= '<form action="super_controller.php" method="post">
						<input type="hidden" value="new_message" name="application">
						<input type="hidden" value="' . $elt->trajet()->lieu_depart() . ' > ' . $elt->trajet()->lieu_arrivee() . ', le ' . date('d/m/y', strtotime($elt->trajet()->date_traj())) . ' à ' . date('h:m', strtotime($elt->trajet()->date_traj())) . '" name="sujet">
						<input type="hidden" name="id_adherent_to" value="'.$elt->conducteur()->id_adherent().'" name="id_adherent_to">
						<input type="hidden" name="id_adherent_from" value="' . $_SESSION['id'] . '" name="id_adherent_from">
						<input type="submit" name="submit"  value="Contacter">
					</form>';
				$html .= '<a href="super_controller.php?application=annuler&id_trajet=' . $elt->id_trajet() . '">Annuler cette réservation</a>';
				$html .= '</div>';
				$html .= '</li>';
				//$html .= '</br>';
			}

			if(isset($_SESSION['permis']))
			{
				$html .= '</ul>';
				$html .= '<h4>En tant que conducteur</h4>';
				$html .= '<ul>';
				foreach ($elts['conducteur'] as $key => $elt) {
					$html .= '<li class="result">';
					$html .= '<div class="result_data">';
					$html .= '<div class="cities">';
					$html .= ucfirst($elt->lieu_depart()) . ' > ';
					$html .= ucfirst($elt->lieu_arrivee());
					$html .= '</div>';
					$html .= '<div class="heure">';
					$html .= date('h:m', strtotime($elt->date_traj()));
					$html .= '</div>';
					$html .= date('d/m/y', strtotime($elt->date_traj()));
					$html .= '<br />';
					$html .= $elt->distance() . 'kms';
					$html .= '</br>';
					$html .= gmdate('H\hi',$elt->time()) . '';
					$html .= '</br>Nombre de passagers : ' . ($elt->nb_passagers_max()-$elt->nb_passagers_rest()) . '/' . $elt->nb_passagers_max();
					$html .= '</div>';
					$html .= '<div class="result_driver">';
					$html .= $elt->conducteur()->Prenom(). ' ' . substr($elt->conducteur()->Nom(), 0,1) . '.';
					$html .= '</div>';
					$html .= '<div class="result_resa">';
					$html .= $elt->frais() . '€ <i>par passager</i>';
					$html .= '</br>';
					$html .= '<a href="super_controller.php?application=annuler_trajet&id_trajet=' . $elt->id_trajet() . '">Annuler ce trajet</a>';
					$html .= '</div>';
					$html .= '</li>';
					$html .= '</br>';
				}

				$html .= '</ul>';
			}


			//On retourne tout ce qu'on vient de créer en HTML dans l'attribut correspondant de la page
			$this->html = $html;
		}
	}
?>