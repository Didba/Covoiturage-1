<?php

	include_once 'v_compte.class.php';
	/**
	* Classe de la vue pour afficher les animaux
	*/
	class v_msg_new extends v_compte
	{
		/**
		* Défini l'HTML de la page
		**/
		function set_html(){

			$html =''; //Initialisation de la variable de retour

			$html .= '<aside>';
			$html .= '<ul>';

			$html .= $this->get_nav('Mes messages');

			$html .= '
				<div id="menu">
				<ul id="onglets">
				<li><a href="super_controller.php?application=recu"><h4>Réception</h4></a></li>
				<li><a href="super_controller.php?application=envoye"><h4>Envoyé</h4></a></li>


			</ul>
			</div>'	;

			$html .= '</aside>';

			$html .= '<form method="post" action="super_controller.php" class="form">';
			$html .= '<input type="hidden" name="application" value="nouveau_message" required>';
			$html .= '<input type="hidden" name="id_adherent_from" value="'.$_SESSION['id'].'" required>';
			$html .= '<input type="hidden" name="id_adherent_to" value="' . $_POST['id_adherent_to']. '" required>';
			$html .= '<input type="hidden" name="sujet" value="' . $_POST['sujet']. '" required>';
			$html .= '<textarea name="message" rows="10" cols="50" placeholder="Saisir votre message ici"></textarea><br>';
			$html .= '<div class="button_wrapper"><input type="submit" name="submit" class="button" value="Envoyer !"></div>';
			$html .= '</form>';

			//On retourne tout ce qu'on vient de créer en HTML dans l'attribut correspondant de la page
			$this->html = $html;
		}
	}
?>