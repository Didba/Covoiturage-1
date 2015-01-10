<?php

	include_once 'Page.class.php';
	/**
	* Classe de la vue pour afficher les animaux
	*/
	class v_inscription extends Page
	{
		/**
		* Défini l'HTML de la page
		**/
		function set_html(){

			$html =''; //Initialisation de la variable de retour

			$html .= '<h3>Inscription</h3>';
			$html .= '<form method="post" action="super_controller.php" enctype="multipart/form-data">';
			$html .= '<input type="hidden" name="application" value="nouvelle_inscription" required><br>';
			$html .= '<label for="prenom">Prénom : </label><input type="text" name="prenom" placeholder="Prénom" required><br>';
			$html .= '<br /><label for="nom">Nom : </label><input type="text" name="nom" placeholder="Nom" required><br>';
			$html .= '<br /><label for="sexe">Genre : </label>&male;<input type="radio" name="sexe" value="1" checked> &female;<input type="radio" name="sexe" value="0" required><br>';
			$html .= '<br /><label for="date_naissance">Date de naissance : </label><input type="date" name="date_naissance" value="date" required><br>';
			$html .= '<br /><label for="telephone">Téléphone : </label><input type="text" name="telephone" placeholder="N° téléphone" required><br>';
			$html .= '<br /><label for="mail">Email : </label><input type="text" name="mail" placeholder="Email" required><br>';
			$html .= '<br /><label for="password">Mot de passe : </label><input type="password" name="password" placeholder="Mot de passe" required><br>';
			$html .= '<br /><label for="conducteur">Conducteur ? : </label><input type="checkbox" name="conducteur" value="1"><br>';
			$html .= '<br /><label for="num_permis">Numéro de permis <i>(Si conducteur)</i> : </label><input type="text" name="num_permis">';
			$html .= '<br>';
			$html .= '<div class="fileUpload">
					<span>Ajouter une photo <i>(taille max. : 2mo)</i></span>
					<input name="photo" type="file" class="upload"/>
				</div><br />';
			$html .= '<input type="submit" name="submit" class="button" value="GO !">';
			$html .= '</form>';

			//On retourne tout ce qu'on vient de créer en HTML dans l'attribut correspondant de la page
			$this->html = $html;
		}
	}
?>