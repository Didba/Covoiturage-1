<?php
	include_once 'v_compte.class.php';
	/**
	* Classe de la vue pour afficher les messages
	*/
	class v_msg_recu extends v_compte
	{
		/**
		* Défini l'HTML de la page
		**/
		function set_html($elts){
			$html =''; //Initialisation de la variable de retour
			
			$html .= '<aside>';
			$html .= '<ul>';
			
			$html .= $this->get_nav('Mes messages');
			$html .= '
				<div id="menu">
				<ul id="onglets">
				<li class="active"><a href="super_controller.php?application=recu"><h4>Réception</h4></a></li>
				<li><a href="super_controller.php?application=envoyer"><h4>Envoyé</h4></a></li>
				
				
			</ul>
			</div>'	;
			
			$html .= '</aside>';
			
			foreach ($elts as $key => $elt) {
				$html .= '<li>';
				$html .= '<b>De : '.$elt->adherent_from()->nom().'</br>';
				//$html .= '<b>À : '.$elt->adherent_to()->nom().'</br>';
				$html .= ''.$elt->date().'</br>';
				$html .= '</br> Objet : '.$elt->sujet().'</b></br>';
				$html .= '</br><p>	'.$elt->message().'</p></br>';
				$html .= '<form action="super_controller.php" method="post">
						<input type="hidden" value="new_message" name="application">
						<input type="hidden" value="' . $elt->sujet() . '" name="sujet">
						<input type="hidden" name="id_adherent_to" value="'.$elt->adherent_to()->id_adherent().'" name="id_adherent_to">
						<input type="hidden" name="id_adherent_from" value="' . $_SESSION['id'] . '" name="id_adherent_from">
						<input type="submit" name="submit"  value="Répondre">
					</form>';
				$html .= '</li></br>';
				$html .='<hr>';
			}
			$html .= '</ul>';
			//On retourne tout ce qu'on vient de créer en HTML dans l'attribut correspondant de la page
			$this->html = $html;
		}
	}
?>