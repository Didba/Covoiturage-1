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
			if(isset($_SESSION['msg']))
			{
				$this->message = $_SESSION['msg'];
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
			$html = $this->html . '<title>' . $this->title . '</title>';
			if(!empty($this->css))
			{
				foreach ($this->css as $link) {
					$html .= '<link href="' . $link . '" rel="stylesheet" type="text/css">';
				}
			}
			$html .= '</head>
			<body>';

			$html .= '<header>';
			$html .= '<a href="super_controller.php"><img src="images/logoCovoit.png" alt="Covoiturage en côte d\'Or" class="main_logo"></a>';
			//On n'affiche pas liens d'interraction avec la BDD dans le menu si la base n'existe pas
			if (isset($_SESSION['id'])) {
				$html .= '<nav>';
				$html .= '<ul class="nav">';
				$html .= '<li><a href="super_controller.php?apptype=display&application=profil&id=' . $_SESSION['id'] . '"><img src="images/user.png" alt=""><span class="username">Mon profil</span></a></li>';
				$html .= '</ul>';
				$html .= '</nav>';
			}
			else
			{
				$html .= '<nav>';
				$html .= '<ul class="nav">';
				$html .= '<li><form action="super_controller.php" method="post"><input type="hidden" name="apptype" value="Action"><input type="hidden" name="application" value="connexion">Connexion: <input type="text" name="mail" placeholder="Email..." required><input type="password" name="pwd" required placeholder="Mot de passe..."><input type="image" name="submit" src="images/ok.png"></form></li>';
				$html .= '</ul>';
				$html .= '</nav>';
			}

			$html .= '</header>';
			$html .= '<div class="content large">';

			//Si un message est à afficher, on l'ajoute au contenu de l'en-tête
			if($this->message)
			{
				$html .= '<div class="alert">' . $this->message . '</div>';
			}
			return $html;
		}

		/**
		* getter title
		**/
		function title(){
			return $this->title;
		}
	}

?>