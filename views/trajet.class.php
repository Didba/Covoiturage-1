<?php
	include 'Display.class.php';

	class display_Trajet extends Display
	{
		private $_manager;
		private $_data;
		private $_id;
		private $_success;
		private $_fail;
		private $_location;

		function __construct($manager,$id=null,$data=null)
		{
		}

		/**
		* Execution de l'action
		**/
		function exec(){
			if(isset($this->_id))
			{
				$_SESSION['msg'] = call_user_func(array($this->_manager, $this->_function), $this->_id)?$this->_success:$this->_fail;
			}
			else if(isset($this->_data))
			{
				$_SESSION['msg'] = call_user_func(array($this->_manager, $this->_function), $this->_data)?$this->_success:$this->_fail;
			}
			else
			{
				$_SESSION['msg'] = call_user_func(array($this->_manager, $this->_function))?$this->_success:$this->_fail;
			}

			header($this->_location);
		}

		abstract function setStr();



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