<?php
	include_once 'views/Page.class.php';
	/**
	* Classe de la vue pour afficher les animaux
	*/
	class v_compte extends Page
	{
		//Constructeur du manager, on y instancie PDO
		function get_nav($active)
		{

			 $tab = array (
				"Mon profil"  => array("addr" => "super_controller.php?application=profil&id=" . $_SESSION['id'], "cond" => false),
				"Proposer un trajet" => array("addr" => "super_controller.php?application=proposer", "cond" => 'isset($_SESSION["permis"])'),
				"Mes trajets"   => array("addr" => "super_controller.php?application=mes_trajets", "cond" => false),
				"Modifier mon profil"   => array("addr" => "super_controller.php?application=modif_profil", "cond" => false),
				"Mes messages"   => array("addr" => "super_controller.php?application=mes_messages", "cond" => false)
			);

			$nav = '';

			$nav .= '<div class="profil_nav">';


			$nav .= '</div>';
			$nav .= '
				<div id="menu">
				<ul id="onglets">
				';
			foreach ($tab as $nom => $value) {
				$display = true;
				if ($value['cond'])
				{
					if(!eval("return " . $value['cond'] . ";"))
					{
						$display = false;
					}
				}

				if($display)
				{
					$nav .= '<li';
					if($active==$nom)
					{
						$nav .= ' class="active"';
					}
					$nav .= '>';
					$nav .= '<a href="' . $value['addr'] . '">' . $nom . '</a>';


					$nav .= '</li>';
				}
			}

			$nav .= '
			</ul>
			</div>';
			return $nav;
		}

	}
?>