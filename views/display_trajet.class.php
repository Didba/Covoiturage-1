<?php
	include 'Display.class.php';

	class display_Trajet extends Display
	{

		function setTitle()
		{
			$this->_title = 'Trajet ' . $this->_id;
		}

					//On vérifie si un ID a bien été fourni
					if(isset($id))
					{
						include_once 'views/admin/v_trajet.class.php';
						$page = new v_trajet("Trajet " + $id);
						$page->set_html($traj_manager->getTrajet($id));
					}
					else
					{
						$_SESSION['msg'] = 'Veuillez demander un trajet valide';
						header('Location: index.php?action=trajets');
					}
	}
?>