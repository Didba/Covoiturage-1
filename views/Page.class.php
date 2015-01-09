<?php

/*--------------------------------------------------------------------------------------------------------*/
/*-----------Ceci est la classe de page de base, dont héritent toutes les vues --------*/
/*------------ Elle contient un objet de type Head, contenant toutes les infos ----------*/
/*------------- correspondantes, un string contenant le contenu de la page------------*/
/*-------------------------------------------------------------------------------------------------------*/

	include_once 'Head.class.php';
	/**
	* Page class
	*/
	class Page
	{

		public $head;
		public $html;
		public $scripts = array();

		function __construct($title)
		{
			echo '<!DOCTYPE html>
	<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">';
			$this->head = new Head($title);
		}

		//Destructeur, dans lequel le rendu est effectué et transmis au navigateur
		function __destruct(){
			$scripts = '
			';
			if (!empty($this->scripts)) {
				foreach($this->scripts as $script)
				{
					$scripts .= '
			<script type="text/javascript" src="' . $script . '"></script>';
				}
			}
			echo  $this->head->to_html() . $this->html . '
			</div>' .$scripts . '
		</body>
	</html>';
			unset($_SESSION['msg']);
		}

		//Ajout des script nécessaires à la page (ex: jQuery, plugins...)
		function add_script($link){
			array_push($this->scripts, $link);
		}
	}
?>