﻿<?php

	include_once 'Page.class.php';
	/**
	* Classe de la vue pour afficher les animaux
	*/
	class v_message extends Page
	{
		/**
		* Défini l'HTML de la page
		**/
		function set_html(){

			$html =''; //Initialisation de la variable de retour
			
			$html .= '<aside>';
			$html .= '<ul>';

			if(isset($_SESSION['permis']))
			{
				$html .= '	<li><a href="super_controller.php?application=proposer">Proposer un trajet</a></li>';
			}

			$html .= '
				<div id="menu">
				<ul id="onglets">
				<li><a href="super_controller.php?application=profil&id=' . $_SESSION['id'].'"> <h4>Mon profil</h4> </a></li>
				<li><a href="super_controller.php?application=mes_trajets"><h4>Mes trajets</h4></a></li>
				<li><a href="super_controller.php?application=modif_profil"><h4>Modifier mon profil</h4></a></li>
				<li><a href="super_controller.php?application=mes_messages"><h4>Mes messages</h4></a></li>
				<li class="active"><a href="super_controller.php?application=new_message"><h4>Nouveau message</h4></a></li>
				
			</ul>
			</div>'	;
			
			$html .= '</aside>';
			
			$html .= '<form method="post" action="super_controller.php">';
			$html .= '<input type="hidden" name="application" value="nouvelle_message" required><br>';
			$html .= '<input type="hidden" name="id_adherent_from" value="'.$_SESSION['id'].'" required><br>';
			$html .= '<br /><input type="number" name="id_idherent_to" placeholder="id adhérent dest" required><br>';
			$html .= '<br /><input type="date" name="date" value="date" required><br>';
			$html .= '<br /><input type="text" name="sujet" placeholder="sujet" required><br>';
			$html .= '<br /><textarea name="message" rows="10" cols="50">Saisir votre message ici.</textarea><br>';
			$html .= '<input type="submit" name="submit" class="button" value="GO !">';
			$html .= '</form>';

			//On retourne tout ce qu'on vient de créer en HTML dans l'attribut correspondant de la page
			$this->html = $html;
		}
	}
?>