﻿<?php

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
			
			$html .= '
			<div id="menu">
			<ul id="onglets">
				<li><a href="super_controller.php?application=proposer"><h4>Proposer un trajet</h4></a></li>
			</ul>
			</div>'	;

			foreach ($elts['passager'] as $key => $elt) {
				$html .= '<li>';
				$html .= '<div class="result_data">';
				$html .= $elt->trajet()->lieu_depart() . ' > ';
				$html .= $elt->trajet()->lieu_arrivee();
				$html .= '</br>';
				$html .= ucfirst($elt->date_traj());
				$html .= '</br>';
				$html .= $elt->trajet()->distance() . 'kms';
				$html .= '</br>';
				$html .= gmdate('H\hi',$elt->trajet()->time()) . '';
				$html .= '</br>';
				$html .= $elt->frais() . '€';
				$html .= '</br>Places réservées : ' . $elt->nb_invites();
				$html .= '</div>';
				$html .= '<div class="result_driver">';
				$html .= $elt->conducteur()->Prenom(). ' ' . substr($elt->conducteur()->Nom(), 0,1) . '.';
				$html .= '</div>';
				$html .= '<a href="super_controller.php?application=annuler&id_trajet=' . $elt->id_trajet() . '">Annuler</a>';
				$html .= '</li>';
				$html .= '</br>';
			}


			foreach ($elts['conducteur'] as $key => $elt) {
				$html .= '<li>';
				$html .= '<div class="result_data">';
				$html .= $elt->trajet()->lieu_depart() . ' > ';
				$html .= $elt->trajet()->lieu_arrivee();
				$html .= '</br>';
				$html .= ucfirst($elt->date_traj());
				$html .= '</br>';
				$html .= $elt->trajet()->distance() . 'kms';
				$html .= '</br>';
				$html .= gmdate('H\hi',$elt->trajet()->time()) . '';
				$html .= '</br>';
				$html .= $elt->frais() . '€';
				$html .= '</br>Places réservées : ' . $elt->nb_invites();
				$html .= '</div>';
				$html .= '<div class="result_driver">';
				$html .= $elt->conducteur()->Prenom(). ' ' . substr($elt->conducteur()->Nom(), 0,1) . '.';
				$html .= '</div>';
				$html .= '<a href="super_controller.php?application=annuler&id_trajet=' . $elt->id_trajet() . '">Annuler</a>';
				$html .= '</li>';
				$html .= '</br>';
			}

			$html .= '</ul>';


			//On retourne tout ce qu'on vient de créer en HTML dans l'attribut correspondant de la page
			$this->html = $html;
		}
	}
?>