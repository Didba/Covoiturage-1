<?php
	include_once 'views/v_compte.class.php';
	include_once('models/AdherentManager.class.php');
	/**
	* Classe de la vue pour afficher les animaux
	*/
	class v_modif_profil extends v_compte
	{
		/**
		* Défini l'HTML de la page
		**/
		function set_html($list){

			extract($list);// On extrait les données contenues dans la liste (qui est un tableau)
			$html =''; //Initialisation de la variable de retour

			$html .= $this->get_nav("Modifier mon profil");

			$html .= '<form method="post" action="super_controller.php">';
			$html .= '<input type="hidden" name="application" value="nouvelle_modif" required><br>';
			$html .= '<label for="prenom">Prénom : </label><input type="text" name="prenom" value="' . $adherent->prenom() . '" required><br>';
			$html .= '<br /><label for="nom">Nom : </label><input type="text" name="nom" value="' . $adherent->nom() . '" required><br>';
			if($adherent->sexe()=="Homme"):
				$html .= '<br /><label for="sexe">Genre : </label>&male;<input type="radio" name="sexe" value="1" checked> &female;<input type="radio" name="sexe" value="0"><br>';
			else:
				$html .= '<br /><label for="sexe">Genre : </label>&male;<input type="radio" name="sexe" value="1"> &female;<input type="radio" name="sexe" value="0" checked><br>';
			endif;
			$html .= '<br /><label for="date_naissance">Date de naissance : </label><input type="date" name="date_naissance" value="' . $adherent->date_naissance() . '" required><br>';
			$html .= '<br /><label for="telephone">Téléphone : </label><input type="text" name="telephone" value="' . $adherent->telephone() . '" required><br>';
			$html .= '<br /><label for="mail">Adresse email : </label><input type="text" name="mail" value="' . $adherent->mail() . '" required><br>';
			$html .= '<br /><label for="password">Mot de passe : </label><input type="password" name="password" required><br>';
			$html .= '<br /><label for="new_password">Nouveau mot de passe : </label><input type="password" name="new_password"><br>';
			$html .= '<br /><label for="conf_password">Confirmer le nouveau mot de passe : </label><input type="password" name="conf_password"><br>';
			$html .= '<br /><label for="conducteur">Conducteur ? : </label><input type="checkbox" name="conducteur" value="1"';
			if(method_exists($adherent,'num_permis'))
			{
				$html .= ' checked';
			}
			$html .= '><br>';
			$html .= '<br /><label for="num_permis">Numéro de permis <i>(Si conducteur)</i> : </label><input type="text" name="num_permis"';
			if(method_exists($adherent,'num_permis'))
			{
				$html .= ' value="' . $adherent->num_permis() . '"';
			}
			$html .= '><br>';
			$html .= '<input type="submit" name="submit" class="button" value="GO !">';
			$html .= '</form>';

		$html .= '<a href="super_controller.php?application=supprimer"><h5>Supprimer compte</h5></a>';


			//On retourne tout ce qu'on vient de créer en HTML dans l'attribut correspondant de la page
			$this->html = $html;
		}
	}
?>