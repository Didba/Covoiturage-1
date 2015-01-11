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
			$html .= $this->get_nav('Mes messages');
			$html .= '
				<div class="menu">
				<ul class="onglets small">
				<li class="active"><a href="super_controller.php?application=recu">Réception</a></li>
				<li><a href="super_controller.php?application=envoye">Envoyé</a></li>


			</ul>
			</div>'	;

			foreach ($elts as $key => $elt) {
				$html .= '<li class="vehicule">';
				$html .= '<b>De : '.$elt->adherent_from()->nom().'</br>';
				$html .= ''.$elt->date().'</br>';
				$html .= '</br> Objet : '.$elt->sujet().'</b></br>';
				$html .= '</br><p>	'.$elt->message().'</p></br>';
				$html .= '<form action="super_controller.php" method="post">
						<input type="hidden" value="new_message" name="application">
						<input type="hidden" value="' . $elt->sujet() . '" name="sujet">
						<input type="hidden" name="id_adherent_to" value="'.$elt->adherent_from()->id_adherent().'" name="id_adherent_to">
						<input type="hidden" name="id_adherent_from" value="' . $_SESSION['id'] . '" name="id_adherent_from">
						<div class="button_wrapper"><input type="submit" name="submit"  value="Répondre"></div>
					</form>';
				$html .= '</li>';
			}
			$html .= '</ul>';
			//On retourne tout ce qu'on vient de créer en HTML dans l'attribut correspondant de la page
			$this->html = $html;
		}
	}
?>