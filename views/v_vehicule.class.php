<?php

	include_once 'v_compte.class.php';

	/**
	* Classe de la vue pour afficher les messages
	*/
	class v_vehicule extends v_compte
	{
		/**
		* Défini l'HTML de la page
		**/
		function set_html(){

			$html =''; //Initialisation de la variable de retour


			$html .= $this->get_nav('Vehicule');

			$html .= '<aside>';
			$html .= '<ul>';



			$html .= '
				<div id="menu">
				<ul id="onglets">
				<li class="active"><a href="super_controller.php?application=mes_vehicules"><h4>Liste véhicule</h4></a></li>
				<li><a href="super_controller.php?application=new_vehicule"><h4>Ajouter nouveau</h4></a></li>


			</ul>
			</div>'	;

			$html .= '</aside>';

			$html .= '</ul>';

			//On retourne tout ce qu'on vient de créer en HTML dans l'attribut correspondant de la page
			$this->html = $html;
		}
	}
?>