<?php

/*--------------------------------------------------------------------------------------------------------*/
/*-----------Ceci est la classe du head de la page. Elle est chargée de rendre --------*/
/*--------- la balise head (avec le titre, les feuilles css), le menu de navigation -------*/
/*--------------------- et d'éventuels messages destinés à l'utilisateur--------------------*/
/*-------------------------------------------------------------------------------------------------------*/

	/**
	* Page head
	*/
	class Head
	{
		public $html;
		private $title;
		private $message;
		private $css = array();

		function __construct($t)
		{
			$this->title = $t;
			$this->html = '
			<head>
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
				<!--[if lt IE 9]>
				<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
				<![endif]-->';

			//On vérifie maintenant si le système a enregistré un message à communiquer à l'utilisateur (confirmation d'ajout, suppression etc.). Si oui, on initialise l'attribut correspondant. Sinon, on init. à False
			if(isset($GLOBALS['msg']))
			{
				$this->message = $GLOBALS['msg'];
			}
			else
			{
				$this->message = false;
			}
		}

		/**
		* Ajout d'une feuille de style à l'array correspondant
		**/
		function add_css($c){
			array_push($this->css, $c);
		}

		/**
		* Rendu HTML de l'head: on ajoute l'ensemble de l'HTML dans une variable string
		**/
		function to_html(){
			$result = $this->html . '<title>' . $this->title . '</title>';
			if(!empty($this->css))
			{
				foreach ($this->css as $link) {
					$result .= '<link href="' . $link . '" rel="stylesheet" type="text/css">';
				}
			}
			$result .= '</head>
			<body>';

			$result .= '<header>';
			$result .= '<h1>Boutique</h1>';
			$result .= '</header>';
			$result .= '<div class="content large">';
			$result .= '<nav>';
			//On n'affiche pas liens d'interraction avec la BDD dans le menu si la base n'existe pas
			if ($GLOBALS['co']) {
				$result .= '	<div class="nav_td"><a href="TD-04.php" class="nav_link animalerie">Liste des produit</a></div>';
				if (isset($_SESSION['admin'])) {
					$result .= '	<div class="nav_td"><a href="TD-04.php?action=ajout" class="nav_link animalerie">Ajouter un produit</a></div>';
				}
				else
				{
					$result .= '	<div class="nav_td"><a href="TD-04.php?action=panier" class="nav_link animalerie">Panier</a></div>';
				}
				$result .= '	<div class="nav_td"><a href="TD-04.php?action=rechercher" class="nav_link animalerie">Rechercher un produit</a></div>';
			}
			//$result .= '	<div class="nav_td"><a href="config/createTable.php" class="nav_link animalerie">Créer / Réinitialiser la BDD</a></div>';
			$result .= '</nav>';
			//Si un message est à afficher, on l'ajoute au contenu de l'en-tête
			if(isset($_SESSION['admin']))
			{
				$result .= '<div class="disconnexion"><a href="TD-04.php?action=deconnexion">DECONNEXION</a></div>';
			}
			if($this->message)
			{
				$result .= '<div class="alert">' . $this->message . '</div>';
			}
			return $result;
		}
	}

?>