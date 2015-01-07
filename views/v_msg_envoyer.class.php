<?php

	include_once 'v_compte.class.php';

	/**
	* Classe de la vue pour afficher les messages
	*/
	class v_msg_envoyer extends v_compte
	{
		/**
		* Défini l'HTML de la page
		**/
		function set_html($elts){
		
		$html =''; //Initialisation de la variable de retour
			
			$html .= '<aside>';
			$html .= '<ul>';

			if(isset($_SESSION['permis']))
			{
				$html .= '	<li><a href="super_controller.php?application=proposer">Proposer un trajet</a></li>';
			}
			
			$html .= $this->get_nav('Mes messages');

			$html .= '
				<div id="menu">
				<ul id="onglets">
				<li><a href="super_controller.php?application=recu"><h4>Réception</h4></a></li>
				<li class="active"><a href="super_controller.php?application=envoyer"><h4>Envoyé</h4></a></li>
				<li><a href="super_controller.php?application=new_message"><h4>Nouveau message</h4></a></li>
				
			</ul>
			</div>'	;
			
			$html .= '</aside>';
			

			foreach ($elts as $key => $elt) {
				$html .= '<li>';
				//$html .= '<b>De : '.$elt->adherent_from()->nom().'</br>';
				$html .= '<b>À : '.$elt->adherent_to()->nom().'</br>';
				$html .= '<b>'.$elt->date().'</br>';
				$html .= '</br> Sujet : </b>'.$elt->sujet().'</br>';
				$html .= '</br><p>	'.$elt->message().'</p></br>';

				$html .= '</li>';
				$html .='<hr>';

			}

			$html .= '</ul>';

			//On retourne tout ce qu'on vient de créer en HTML dans l'attribut correspondant de la page
			$this->html = $html;
		}
	}
?>