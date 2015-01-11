<?php

	include_once 'v_compte.class.php';

	/**
	* Classe de la vue pour afficher les messages
	*/
	class v_vehicule extends v_compte
	{
		/**
		* retourne la navigation des vues liées aux véhicules
		**/
		function get_nav_Vh($active){


			 $tab = array (
				"Ma liste" => array("addr" => "super_controller.php?application=mes_vehicules", "cond" => 'isset($_SESSION["permis"])'),
				"Ajouter un véhicule" => array("addr" => "super_controller.php?application=new_vehicule", "cond" => 'isset($_SESSION["permis"])')
			);

			$nav = '';
			$nav .= '
				<div class="menu">
				<ul class="onglets small">
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