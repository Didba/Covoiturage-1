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
			$html .= '<b>Prénom : </b><input type="text" name="prenom" value="' . $adherent->prenom() . '" required><br>';
			$html .= '<br /><b>Nom : </b><input type="text" name="nom" value="' . $adherent->nom() . '" required><br>';
			if($adherent->sexe()=="Homme"):
				$html .= '<br /><b>Sexe : </b>&male;<input type="radio" name="sexe" value="1" checked> &female;<input type="radio" name="sexe" value="0"><br>';
			else:
				$html .= '<br /><b>Sexe : </b>&male;<input type="radio" name="sexe" value="1"> &female;<input type="radio" name="sexe" value="0" checked><br>';
			endif;
			$html .= '<br /><b>Date de naissance : </b><input type="date" name="dateNaiss" value="' . $adherent->date_naissance() . '" required><br>';
			$html .= '<br /><b>Téléphone : </b><input type="text" name="telephone" value="' . $adherent->telephone() . '" required><br>';
			$html .= '<br /><b>Mail : </b><input type="text" name="mail" value="' . $adherent->mail() . '" required><br>';
			$html .= '<br /><b>Mot de passe : </b><input type="password" name="password" required><br>';
			$html .= '<br /><b>Conducteur ? : </b><input type="checkbox" name="conducteur" value="1" required';
			if(method_exists($adherent,'numPermis'))
			{
				$html .= ' checked';
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