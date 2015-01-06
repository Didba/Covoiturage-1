<?php
	include_once 'views/Page.class.php';
	include_once('models/AdherentManager.class.php');
	/**
	* Classe de la vue pour afficher les animaux
	*/
	class v_modif_profil extends Page
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
				<li class="active"><a href="super_controller.php?application=modif_profil"><h4>Modifier mon profil</h4></a></li>
				<li><a href="super_controller.php?application=mes_messages"><h4>Mes messages</h4></a></li>
				
			</ul>
			</div>'	;
			
			$html .= '</aside>';
		

			$html .= '<form method="post" action="super_controller.php">';
			$html .= '<input type="hidden" name="application" value="nouvelle_modif" required><br>';
			$html .= '<b>Prénom : </b><input type="text" name="prenom" value=" Prenom " required><br>';
			$html .= '<br /><b>Nom : </b><input type="text" name="nom" placeholder="Nom" required><br>';
			$html .= '<br /><b>Sexe : </b>&male;<input type="radio" name="sexe" value="1" checked> &female;<input type="radio" name="sexe" value="0" required><br>';
			$html .= '<br /><b>Date naiss : </b><input type="date" name="dateNaiss" value="date" required><br>';
			$html .= '<br /><b>Tel : </b><input type="text" name="telephone" placeholder="N° téléphone" required><br>';
			$html .= '<br /><b>Mail : </b><input type="text" name="mail" placeholder="Email" required><br>';
			$html .= '<br /><b>Mdp : </b><input type="password" name="password" placeholder="Mot de passe" required><br>';
			$html .= '<input type="submit" name="submit" class="button" value="GO !">';
			$html .= '</form>';

					
		
		$html .= '<a href="super_controller.php?application=supprimer"><h5>Supprimer compte</h5></a>';
		
		
			//On retourne tout ce qu'on vient de créer en HTML dans l'attribut correspondant de la page
			$this->html = $html;
		}
	}
?>