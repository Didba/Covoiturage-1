<?php

	include_once 'v_compte.class.php';

	/**
	* Classe de la vue pour afficher les messages
	*/
	class v_mes_messages extends v_compte
	{
		/**
		* Défini l'HTML de la page
		**/
		function set_html(){

			$html =''; //Initialisation de la variable de retour
			

			$html .= $this->get_nav('Mes messages');
			
			$html .= '<aside>';
			$html .= '<ul>';

			

			$html .= '
				<div id="menu">
				<ul id="onglets">
				<li><a href="super_controller.php?application=recu"><h4>Réception</h4></a></li>
				<li><a href="super_controller.php?application=envoyer"><h4>Envoyé</h4></a></li>
				
				
			</ul>
			</div>'	;
			
			$html .= '</aside>';

			$html .= '</ul>';

			//On retourne tout ce qu'on vient de créer en HTML dans l'attribut correspondant de la page
			$this->html = $html;
		}
	}
?>